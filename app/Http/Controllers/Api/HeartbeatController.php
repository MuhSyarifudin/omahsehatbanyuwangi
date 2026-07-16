<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HeartbeatController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check()) {

            $user = auth()->user();

            $user->last_seen = now();

            $user->save();
        }

        return response()->json([
            'success' => true
        ]);
    }
}
