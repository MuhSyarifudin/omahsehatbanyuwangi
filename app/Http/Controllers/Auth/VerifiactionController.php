<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerifiactionController extends Controller
{
    public function showForm()
    {
        return view('auth.verify-email');
    }

    // Mengirimkan email verifikasi
    public function sendVerificationLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email', // Pastikan email terdaftar
        ]);

        $user = User::where('email', $request->email)->first();

        // Cek jika email sudah diverifikasi
        if ($user->hasVerifiedEmail()) {
            return back()->with('message', 'Email sudah diverifikasi.');
        }

        // Kirim email verifikasi
        $user->sendEmailVerificationNotification();

        return back()->with('message', 'Email verifikasi telah dikirim.');
    }
}
