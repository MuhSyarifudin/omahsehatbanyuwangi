<?php

namespace App\Listeners;

use App\Events\NotifikasiPaymentBerhasilEvent;
use App\Models\User;
use App\Notifications\NotifikasiPaymentDone;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Notification;

class NotifikasiPaymentBerhasilListener
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
    public function handle(NotifikasiPaymentBerhasilEvent $event): void
    {
        $admins = User::where('role','admin')->get();
        Notification::send($admins,new NotifikasiPaymentDone($event->transaksi));
    }

}
