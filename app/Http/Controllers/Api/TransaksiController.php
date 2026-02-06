<?php

namespace App\Http\Controllers\Api;

use App\Models\WaToken;
use App\Models\Transaksi;
use App\Http\Controllers\Controller;
use App\Events\NotifikasiPaymentBerhasilEvent;
use App\Models\Device;

class TransaksiController extends Controller
{ 
 
    public function callback(){

    $json = json_decode(file_get_contents('php://input'), true);

    $orderId = $json['order_id'] ?? null;
    $transaction = $json['transaction_status'] ?? null;
    $status_code = $json['status_code'];
    $gross_amount = $json['gross_amount'];
    $signature_key = $json['signature_key'];

    $userId = $json['custom_field1'] ?? null;

    $transaksi = Transaksi::where('id', $userId)->first();
    if ($transaksi == null) {
        return response()->json(['error','Transaksi tidak ditemukan'],404);
    }
    
    $serverKey = config('midtrans.server_key');
    $hashed = hash("sha512",$orderId.$status_code.$gross_amount.$serverKey);
    if ($hashed == $signature_key) {

            if ($transaction == 'capture' || $transaction == 'settlement') {

                $transaksi->status = 'paid';

                event(new NotifikasiPaymentBerhasilEvent($transaksi));

            } elseif ($transaction == 'pending') {

                $transaksi->status = 'pending';

            } elseif ($transaction == 'cancel' || $transaction == 'deny' || $transaction == 'expire') {
                
                $transaksi->status = 'canceled';
            
            }

            $transaksi->save();
        };


        

$device = Device::where('is_activated',true)->first();

if ($transaksi->tempat == "Center") {
    $pesan = [
        'target'=>$transaksi->nohp,
        'message'=>"
📌 *Detail Reservasi*  
👤 *Nama:* ".$transaksi->nama."  
📱 *No. Whatsapp:* ".$transaksi->nohp."  
🏠 *Jenis Layanan:* ".$transaksi->tempat."  
🗓 *Tanggal:* ".dateid('l, j F Y', $transaksi->tanggal)."  
⏰ *Jam:* ".$transaksi->jam."  
💆‍♂️ *Jenis Terapi:* ".$transaksi->nama_layanan." - ".$transaksi->nama_jenis_terapi."  
👥 *Jumlah:* ".$transaksi->jumlah." Orang  
💰 *Total Harga:* ".rupiah($transaksi->total_harga)."  

✅ Transaksi Anda *Berhasil/Lunas*!  
✨ Silakan kunjungi tempat terapi kami pada *".dateid('l, j F Y', $transaksi->tanggal)."*  

📍 *Lokasi:* https://maps.app.goo.gl/4zxYbCwPog1yeE2a7
                "];

kirimPesan($token->token,$pesan);
} else if($device->tempat == "Homecare") {
$pesan = [
    'target'=>$transaksi->nohp,
    'message'=>"
📌 *Detail Reservasi*  
👤 *Nama:* ".$transaksi->nama."  
📱 *No. Whatsapp:* ".$transaksi->nohp."  
🏠 *Jenis Layanan:* ".$transaksi->tempat."  
📍 *Alamat*: ".$transaksi->alamat."  
🗓 *Tanggal:* ".dateid('l, j F Y', $transaksi->tanggal)."  
⏰ *Jam:* ".$transaksi->jam."  
💆‍♂️ *Jenis Terapi:* ".$transaksi->nama_jenis_terapi." - ".$transaksi->nama_layanan."
👥 *Jumlah:* ".$transaksi->jumlah." Orang  
💰 *Total Harga:* ".rupiah($transaksi->total_harga)."  

✅ Transaksi Anda *Berhasil/Lunas*!  
🚗 Kunjungan ke tempat Anda akan dilakukan pada *".dateid('l, j F Y', $transaksi->tanggal)."*  

📍 Lokasi: https://maps.app.goo.gl/4zxYbCwPog1yeE2a7  

Terima kasih telah mempercayai layanan kami! 😊✨ 
                "];

            kirimPesan($device->token,$pesan);

        }

    return response()->json(['message' => 'Status pembayaran diperbarui'], 200);
    }
    
}
