<?php

namespace App\Listeners;

use App\Events\VisitorCountEvent;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class UpdateVisitorAfterLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {        
         /*
        |--------------------------------------------------------------------------
        | Ambil visitor_id dari cookie browser yang login
        |--------------------------------------------------------------------------
        */

        $visitor_id = Cookie::get('visitor_id');

        // if (!$visitor_id) {

        //     Log::warning('VISITOR ID TIDAK DITEMUKAN SAAT LOGIN');

        //     return;
        // }

        /*
        |--------------------------------------------------------------------------
        | Update visitor spesifik device/browser ini saja
        |--------------------------------------------------------------------------
        */

        Visitor::where('visitor_id', $visitor_id)
            ->whereDate('visit_date', now()->toDateString())
            ->update([
                'user_id' => $event->user->id,
                'role'    => $event->user->role
            ]);

        /*
        |--------------------------------------------------------------------------
        | Logging
        |--------------------------------------------------------------------------
        */

        // Log::info('VISITOR LOGIN TERHUBUNG', [
        //     'visitor_id' => $visitor_id,
        //     'user_id'    => $event->user->id,
        //     'role'       => $event->user->role,
        //     'ip'         => request()->ip(),
        // ]);

        /*
        |--------------------------------------------------------------------------
        | Broadcast event
        |--------------------------------------------------------------------------
        */

        $user = User::find($event->user->id);

        if ($user && $user->role == 'admin') {
            event(new VisitorCountEvent());
        }
    }
}
