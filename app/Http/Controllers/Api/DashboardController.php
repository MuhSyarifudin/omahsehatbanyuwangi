<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function jumlah_notifikasi(){
        $user = Auth::user();
        $count_notifikasi = $user->unreadNotifications->count();

        return response()->json(['count_notifikasi'=>$count_notifikasi],200);
    }

    public function get_notifikasi(){
        $user = Auth::user();
        return response()->json([
            'count_notifikasi' => $user->unreadNotifications->count(),
            'notifikasi' => $user->unreadNotifications->map(function ($notif) {
                return [
                    'id' => $notif->id,
                    'data' => $notif->data,
                    'created_at' => $notif->created_at->diffForHumans(),
                ];
            })
        ]);
    }

    public function tes(){
        $tes = "Hello world";

        return response()->json(['tes'=>$tes],200);
    }
}
