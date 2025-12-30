<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Auth;

class NotifikasiReservasiEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $count;
    public $transaksi;
    public $notifikasi;

    public function __construct($transaksi)
    {
        $user = Auth::user();
        $this->transaksi = $transaksi;
        $this->notifikasi = $user->unreadNotifications ?? null;
        $this->count = $user->unreadNotifications->count() ?? 0;
        
    }
}
