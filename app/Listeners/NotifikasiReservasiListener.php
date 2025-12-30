<?php

namespace App\Listeners;

use App\Events\NotifikasiReservasiEvent;
use App\Models\User;
use App\Notifications\NotifikasiReservasi;
use Illuminate\Support\Facades\Notification;

class NotifikasiReservasiListener
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
    public function handle(NotifikasiReservasiEvent $event): void
    {
        $admins = User::where('role','admin')->get();
        Notification::send($admins,new NotifikasiReservasi($event->transaksi));
    }
}
