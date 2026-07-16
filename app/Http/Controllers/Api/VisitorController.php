<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class VisitorController extends Controller
{
    public function recentlyUsers()
    {
        $visitors = User::where('role', 'admin')
            ->whereNotNull('last_activity')
            ->orderByDesc('last_activity')
            ->limit(10)
            ->get();

        $data = $visitors->map(function ($user) {
            $isOnline = $user->last_seen !== null;

            return [
                'name' => $user->name ?? 'Unknown',
                'status' => $isOnline ? 'Online' : 'Offline',
                'is_online' => $isOnline,
                'last_active' => $user->last_activity
                    ? \Carbon\Carbon::parse($user->last_activity)->diffForHumans()
                    : '-',
            ];
        });

        return response()->json($data);
    }
}
