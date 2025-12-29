<?php

namespace App\Http\Controllers;

use App\Events\NotificationSent;
use App\Http\Requests\StoreReservationRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;

class CheckoutController extends Controller
{
    public function checkout(StoreReservationRequest $request){

        $request->validated();
        
        $terapi = DB::table('layanan_terapi')->where('id',$request->terapi)->first();

        $request->request->add(['total_harga'=>$request->jumlah * $terapi->harga]);

        $transaksi =  new Transaksi();

        $transaksi->nama = $request->nama_lengkap;
        $transaksi->nama_terapi = DB::table('layanan_terapi')->where('id',$request->terapi)->first()->nama;
        if (Isset($request->alamat)) {
            $transaksi->alamat = $request->alamat;
        }
        $transaksi->jenis_kelamin = $request->jenis_kelamin;
        $transaksi->nohp = $request->nohp;
        $transaksi->tempat = $request->layanan;
        $transaksi->tanggal = $request->tanggal;
        $transaksi->hari = $request->hari;
        $transaksi->jam = $request->jam;
        $transaksi->jumlah = $request->jumlah;
        $transaksi->total_harga = $request->total_harga;
        $transaksi->terapi_id = $request->terapi;
        $transaksi->order_id = 'ORDER_' . time();
        $transaksi->save();

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
    
        event(new NotificationSent($transaksi));

        if ($transaksi->tempat == "Center") {

            return redirect()->route('detail.reservasi.terapi');

        } else if ($transaksi->tempat == "Homecare"){

            return redirect()->route('waiting.page');

        }
    }
}
