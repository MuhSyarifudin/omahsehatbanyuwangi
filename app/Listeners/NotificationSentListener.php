<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\NotificationSent;
use App\Notifications\NotifikasiReservasi;
use Illuminate\Support\Facades\Notification;

class NotificationSentListener
{

    public function __construct()
    {
        
    }

    public function handle(NotificationSent $event): void
    {
        $admins = User::where('role','admin')->get();
        Notification::send($admins,new NotifikasiReservasi($event->transaksi));

    }
}
