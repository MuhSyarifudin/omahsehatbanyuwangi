<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visitor;
use App\Models\WhatsappMessage;
use Illuminate\Support\Facades\DB;

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
            ->where('status','paid')
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

        $jumlahVisitor = Visitor::all()->count();

        return view('admin.dashboard',compact('totalKeuntungan','jumlahReservasi','jumlahUser','jumlahVisitor'));
    }

    public function whatsappLogs()
    {
        $messages = WhatsappMessage::latest()
            ->paginate(10);

        return view(
            'admin.whatsapp.logs',
            compact('messages')
        );
    }

}
