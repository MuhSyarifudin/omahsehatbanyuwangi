<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;

class ShowPaymentController extends Controller
{
    public function showPaymentPage($order_id){
        
        $transaksi = Transaksi::select('transaksi.*', 'jenis_terapi.nama AS nama_jenis_terapi')
    ->join('layanan_terapi', 'transaksi.terapi_id', '=', 'layanan_terapi.id')
    ->join('jenis_terapi', 'layanan_terapi.jenis_terapi', '=', 'jenis_terapi.id')
    ->where('transaksi.order_id', $order_id)
    ->first();
        $harga_terapi = DB::table('layanan_terapi')->where('id',$transaksi->terapi_id)->first()->harga;
         
        return view('reservasi.payment-page',['marginBottom'=>true,'snapToken'=>$transaksi->snap_token,'harga_terapi'=>$harga_terapi],compact('transaksi'));
    }
}
