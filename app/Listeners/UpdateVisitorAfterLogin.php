<?php

namespace App\Listeners;

use App\Events\VisitorCountEvent;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        $ip = request()->ip();
        
        Visitor::where('ip_address', $ip)
        ->whereNull('user_id')
        ->whereDate('visit_date', now()->toDateString())
        ->update([
            'user_id' => $event->user->id,
            'role'    => $event->user->role
        ]);

        $user = User::find($event->user->id);
        
        if ($user->role == 'admin') {
            event(new VisitorCountEvent());
        }
    }
}
