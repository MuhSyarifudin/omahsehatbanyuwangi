<?php

namespace App\Http\Middleware;

use App\Events\VisitorCountEvent;
use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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
        $ip = $request->ip();

        $user_agent = $request->userAgent();

        /*
        |--------------------------------------------------------------------------
        | Visitor ID dari Cookie
        |--------------------------------------------------------------------------
        */

        $visitor_id = Cookie::get('visitor_id');

        if (!$visitor_id) {

            $visitor_id = (string) Str::uuid();

            // simpan cookie selama 1 tahun
            Cookie::queue(
                'visitor_id',
                $visitor_id,
                60 * 24 * 365
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan visitor
        |--------------------------------------------------------------------------
        */

        $visitor = Visitor::firstOrCreate([
            'visitor_id' => $visitor_id,
            'visit_date' => now()->toDateString(),
        ], [
            'ip_address' => $ip,
            'user_agent' => $user_agent,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Logging
        |--------------------------------------------------------------------------
        */

        // Log::info('MIDDLEWARE JALAN', [
        //     'visitor_id' => $visitor_id,
        //     'ip' => $ip,
        //     'user_agent' => $user_agent,
        //     'url' => $request->fullUrl(),
        //     'method' => $request->method(),
        // ]);

        /*
        |--------------------------------------------------------------------------
        | Event visitor baru
        |--------------------------------------------------------------------------
        */

        if ($visitor->wasRecentlyCreated) {
            event(new VisitorCountEvent);
        }

        return $next($request);
    }
}