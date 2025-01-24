<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservasiController extends Controller
{
    public function index(){
        $layanan_terapi = DB::table('layanan_terapi')
        ->join('jenis_terapi', 'layanan_terapi.jenis_terapi', '=', 'jenis_terapi.id')
        ->select('layanan_terapi.id','layanan_terapi.nama AS nama_terapi', 'jenis_terapi.nama AS jenis_terapi')
        ->get();
        return view('reservasi.reservasi',['marginBottom' => true],compact('layanan_terapi'));
    }

    public function detail_reservasi(){

        $transaksi = session('transaksi');
        $snapToken = session('snapToken');
        $harga_terapi = session('harga_terapi');

        return view('reservasi.detail-reservasi',compact('transaksi','snapToken','harga_terapi'));
    }
}
