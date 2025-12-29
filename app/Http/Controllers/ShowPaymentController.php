<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;

class ShowPaymentController extends Controller
{
    public function showPaymentPage($id){
        
        $transaksi = Transaksi::select('*')->where('id',$id)->first();
        $harga_terapi = DB::table('layanan_terapi')->where('id',$transaksi->terapi_id)->first()->harga;


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

        return view('reservasi.payment-page',['marginBottom'=>true,'snapToken'=>$snapToken,'harga_terapi'=>$harga_terapi],compact('transaksi'));
    }
}
