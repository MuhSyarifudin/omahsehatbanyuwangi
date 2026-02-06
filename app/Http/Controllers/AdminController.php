<?php

namespace App\Http\Controllers;

use App\Events\NotificationBellEvent;
use App\Models\JenisTerapi;
use App\Models\Layanan;
use App\Models\Notification;
use App\Models\User;
use App\Models\Transaksi;
use App\Models\Visitor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class AdminController extends Controller
{
    public function index(){

        $now = now();

        $keuntunganPerBulan = DB::table('transaksi')
            ->selectRaw('? as year, ? as month, COALESCE(SUM(total_harga),0) as total_keuntungan', [
                $now->year,
                $now->month
            ])
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->first();

        $totalKeuntungan = $keuntunganPerBulan->total_keuntungan ?? 0;

        $jumlahReservasi = DB::table('transaksi')
        ->whereYear('created_at', now()->year)
        ->whereMonth('created_at', now()->month)
        ->count();

        $jumlahUser = User::count();

        $today = now()->toDateString();

        $startDate = now()->subDays(29)->toDateString();
        $endDate   = now()->toDateString();

        $jumlahVisitor = Visitor::whereBetween('visit_date', [$startDate, $endDate])->whereNull('user_id')->count();

        return view('admin.dashboard',compact('totalKeuntungan','jumlahReservasi','jumlahUser','jumlahVisitor'));
    }

}
