<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\User;

class AdminController extends Controller
{
    public function index(){

        $keuntunganPerBulan = DB::table('transaksi')
        ->select(DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_harga) as total_keuntungan'))
        ->where('status','paid')
        ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
        ->orderByDesc(DB::raw('YEAR(created_at)'))
        ->orderByDesc(DB::raw('MONTH(created_at)'))
        ->first();

        $totalKeuntungan = $keuntunganPerBulan->total_keuntungan ?? 0;

        $jumlahReservasi = DB::table('transaksi')
        ->select(DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_harga) as total_keuntungan'))
        ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
        ->orderByDesc(DB::raw('YEAR(created_at)'))
        ->orderByDesc(DB::raw('MONTH(created_at)'))
        ->count();

        $jumlahUser = User::count();

        return view('admin.dashboard',compact('totalKeuntungan','jumlahReservasi','jumlahUser'));
    }

    public function data_reservasi(){
        $transaksi = Transaksi::select(
            'transaksi.*',
            'layanan_terapi.nama as nama_layanan',
            'jenis_terapi.nama as nama_jenis_terapi'
        )
        ->join('layanan_terapi', 'transaksi.terapi_id', '=', 'layanan_terapi.id')
        ->join('jenis_terapi', 'layanan_terapi.jenis_terapi', '=', 'jenis_terapi.id')
        ->get();
    

        return view('admin.data-reservasi',compact('transaksi'));
    }

    public function data_user(){
        $users = User::all();

        return view('admin.data-users',compact('users'));
    }
}
