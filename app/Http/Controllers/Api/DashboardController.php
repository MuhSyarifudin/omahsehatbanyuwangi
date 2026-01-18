<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function get_users_count(){
        $users_count = User::all()->count();

        return response()->json(['count_users'=>$users_count],200);
    }

    public function get_reservasi_count(){

        $reservasi_count = Transaksi::all()->count();

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
            ->limit(30)
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

        $user->unreadNotifications->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi ditandai sebagai dibaca'
        ], 200);
    }

    
}
