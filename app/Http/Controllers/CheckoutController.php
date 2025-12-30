<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use App\Events\NotifikasiReservasiEvent;
use App\Http\Requests\StoreReservationRequest;

class CheckoutController extends Controller
{
    public function checkout(StoreReservationRequest $request){

        $request->validated();
        
        $terapi = DB::table('layanan_terapi')
        ->where('id', $request->terapi)
        ->first();

        $transaksi = DB::transaction(function () use ($request,$terapi) {

            $totalHarga = $request->jumlah * $terapi->harga;

            $trx =  new Transaksi();

            $trx->nama = $request->nama_lengkap;
            $trx->nama_terapi =$terapi->nama;
            $trx->alamat = $request->alamat ?? null;
            $trx->jenis_kelamin = $request->jenis_kelamin;
            $trx->nohp = $request->nohp;
            $trx->tempat = $request->layanan;
            $trx->tanggal = $request->tanggal;
            $trx->hari = $request->hari;
            $trx->jam = $request->jam;
            $trx->jumlah = $request->jumlah;
            $trx->total_harga = $totalHarga;
            $trx->terapi_id = $terapi->id;
            $trx->order_id = 'ORDER_' . time();
            $trx->save();
        
            return $trx;
        });

        $harga_terapi = DB::table('layanan_terapi')->where('id',$request->terapi)->first()->harga;

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $transaksi->order_id,
                'gross_amount' => $transaksi->total_harga,
            ),
            'customer_details' => array(
                'nama' => $transaksi->nama,
                'phone' => $transaksi->nohp,
            ),
            'custom_field1' => $transaksi->id,
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        
        session()->put('transaksi',$transaksi);
        session()->put('snapToken',$snapToken);
        session()->put('harga_terapi',$harga_terapi);
    
        event(new NotifikasiReservasiEvent($transaksi));

        if ($transaksi->tempat == "Center") {

            return redirect()->route('detail.reservasi.terapi');

        } else if ($transaksi->tempat == "Homecare"){

            return redirect()->route('waiting.page');

        }
    }
}
