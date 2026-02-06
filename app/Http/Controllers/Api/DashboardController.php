<?php

namespace App\Http\Controllers\Api;

use App\Events\NotificationBellEvent;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{

    public function jumlah_keuntungan(){
        $now = now();

        $keuntungan = DB::table('transaksi')
            ->selectRaw('? as year, ? as month, COALESCE(SUM(total_harga),0) as total_keuntungan', [
                $now->year,
                $now->month
            ])
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->first();

        $total_keuntungan = $keuntungan->total_keuntungan ?? 0;

        return response()->json(['keuntungan'=>$total_keuntungan],200);
    }

    public function get_visitor_count(){
        $visitors = Visitor::whereBetween('visit_date', [
            now()->subDays(29),
            now()
        ])
        ->whereNull('user_id')
        ->where('role','!=','admin')
        ->count();

    return response()->json([
        'last_30_days' => $visitors
    ]);
    }

    public function trackVisitor()
    {
        return response()->json([
            'status' => true,
            'message' => 'Visitor tracked'
        ], 200);
    }

    public function get_users_count(){
        $users_count = User::all()->count();

        return response()->json(['count_users'=>$users_count],200);
    }

    public function get_reservasi_count(){

        $reservasi_count = DB::table('transaksi')
        ->whereYear('created_at', now()->year)
        ->whereMonth('created_at', now()->month)
        ->count();

        return response()->json(['count_reservasi'=>$reservasi_count],200);
    }

    public function jumlah_notifikasi(){
    $user = Auth::user();

    if (!$user) {
        return response()->json([
            'message' => 'Unauthenticated'
        ], 401);
    }

    return response()->json([
        'count_notifikasi' => $user->unreadNotifications->count()
    ], 200);
    }

    public function get_notifikasi(){
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        return response()->json([
            'count_notifikasi' => $user->unreadNotifications->count(),
            'notifikasi' => $user->notifications()
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($notif) {
                return [
                    'id' => $notif->id,
                    'data' => $notif->data,
                    'created_at' => $notif->created_at->diffForHumans(),
                    'read_at' => $notif->read_at
                ];
            })
        ]);
    }

    public function tes(){
        $tes = "Hello world";

        return response()->json(['tes'=>$tes],200);
    }

    
    public function markAsRead(Request $request, $id)
    {

        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        $notification = $user->notifications()->find($id);

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sebagai dibaca'
        ]);
    }

        public function markAsReadAll()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        $notif = $user->unreadNotifications;

        if ($notif->isNotEmpty()) {
            event(new NotificationBellEvent());
            $notif->markAsRead();
        }

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi ditandai sebagai dibaca'
        ], 200);
    }

    public function jamTerpakai()
    {
        $start = Carbon::today()->toDateString();
        $end   = Carbon::today()->addDays(2)->toDateString();

        $transaksi = Transaksi::whereBetween('tanggal', [$start, $end])
            ->select('tanggal', 'jam', 'tempat AS jenis_layanan')
            ->get();

        $result = [
            'center'   => [],
            'homecare' => [],
        ];

        foreach ($transaksi as $item) {

            $layanan = $item->jenis_layanan;

            if (!in_array($layanan, ['center', 'homecare'])) {
                continue;
            }

            $tanggal = Carbon::parse($item->tanggal)->format('Y-m-d');

            if (!isset($result[$layanan][$tanggal])) {
                $result[$layanan][$tanggal] = [];
            }

            if (!in_array($item->jam, $result[$layanan][$tanggal])) {
                $result[$layanan][$tanggal][] = $item->jam;
            }
        }

        return response()->json($result);
    }

    
}
