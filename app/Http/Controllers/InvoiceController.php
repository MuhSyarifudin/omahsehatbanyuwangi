<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use PDF;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index($order_id,$token){

        $transaksi = Transaksi::where('order_id',$order_id)->where('invoice_token',$token)->firstOrFail();

        $jenis_terapi = DB::table('layanan_terapi')
        ->join('jenis_terapi', 'layanan_terapi.jenis_terapi', '=', 'jenis_terapi.id')
        ->where('layanan_terapi.id', $transaksi->terapi_id)
        ->select('layanan_terapi.nama as layanan', 'jenis_terapi.nama as jenis_terapi')
        ->first();

        return view('invoice.index',['marginBottom'=>false],compact('transaksi','jenis_terapi'));
    }

    public function download($order_id,$token){

    $transaksi = Transaksi::where('order_id',$order_id)->where('invoice_token',$token)->first();

    $jenis_terapi = DB::table('layanan_terapi')
        ->join('jenis_terapi', 'layanan_terapi.jenis_terapi', '=', 'jenis_terapi.id')
        ->where('layanan_terapi.id', $transaksi->terapi_id)
        ->select('layanan_terapi.nama as layanan', 'jenis_terapi.nama as jenis_terapi')
        ->first();

        $pdf = PDF::loadView('invoice.download', compact('transaksi','jenis_terapi'))
        ->setPaper('a4')
        ->setOption('zoom', 1.15)
        ->setOption('enable-local-file-access', true);

        return $pdf->download('invoice.pdf');
    // return view('invoice.download',compact('transaksi','jenis_terapi'));
    }

}
