<?php

namespace App\Http\Controllers\Api;

use App\Events\NotifikasiPaymentBerhasilEvent;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class TransaksiController extends Controller
{ 

    public function callback(){

    $json = json_decode(file_get_contents('php://input'), true);

    $orderId = $json['order_id'] ?? null;
    $transaction = $json['transaction_status'] ?? null;
    $status_code = $json['status_code'];
    $gross_amount = $json['gross_amount'];
    $signature_key = $json['signature_key'];

    $transaksi_id = $json['custom_field1'] ?? null;

    $transaksi= Transaksi::select('transaksi.*', 'jenis_terapi.nama AS nama_jenis_terapi')
    ->join('layanan_terapi', 'transaksi.terapi_id', '=', 'layanan_terapi.id')
    ->join('jenis_terapi', 'layanan_terapi.jenis_terapi', '=', 'jenis_terapi.id')
    ->where('transaksi.id', $transaksi_id)
    ->first();

    if ($transaksi == null) {
        return response()->json(['error','Transaksi tidak ditemukan'],404);
    }
    
    $serverKey = config('midtrans.server_key');
    $hashed = hash("sha512",$orderId.$status_code.$gross_amount.$serverKey);
    
    if ($hashed == $signature_key) {

    // Simpan status lama
    $statusLama = $transaksi->status;

    if ($transaction == 'capture' || $transaction == 'settlement') {

        // Hanya proses jika sebelumnya belum paid
        if ($statusLama !== 'paid') {

            $transaksi->status = 'paid';
            $transaksi->save();

            // Event ini akan trigger NotifikasiPaymentBerhasilListener
            // yang menangani pengiriman WhatsApp message
            event(new NotifikasiPaymentBerhasilEvent($transaksi));
        }

    } elseif ($transaction == 'pending') {

        $transaksi->status = 'pending';
        $transaksi->save();

    } elseif (
        $transaction == 'cancel' ||
        $transaction == 'deny' ||
        $transaction == 'expire'
    ) {

        $transaksi->status = 'canceled';
        $transaksi->save();
    }
}

    return response()->json(['message' => 'Status pembayaran diperbarui'], 200);
    }
    
}
