<?php

namespace App\Http\Middleware;

use App\Events\VisitorCountEvent;
use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip     = $request->ip();

        $exists = Visitor::where('ip_address', $request->ip())
        ->whereBetween('visit_date', [
            now()->startOfDay(),
            now()->endOfDay()
        ])
        ->exists();

            Visitor::firstOrCreate([
                'ip_address' => $ip,
                'visit_date' => now()->toDateString(),
            ]);    

        if (!$exists) {
            event(new VisitorCountEvent);
        }
    
        return $next($request);
    }
}
