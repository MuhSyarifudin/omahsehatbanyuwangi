<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? ['web'] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
    
                // Cek role pengguna dan arahkan ke halaman yang sesuai
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }
    
                if ($user->role === 'therapist') {
                    if (!$user->hasVerifiedEmail()) {
                        return redirect()->route('verification.notice');
                    }
                    return redirect()->route('therapist.dashboard');
                }
    
                return redirect(RouteServiceProvider::HOME);
            }
        }
    
        return $next($request);
    }
}
