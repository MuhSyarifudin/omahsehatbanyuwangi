<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifikasiBaru extends Notification
{
    use Queueable;

    protected $transaksi;

    public function __construct($transaksi)
    {
        $this->transaksi = $transaksi;
    }

    // Menentukan saluran notifikasi (email dan database)
    public function via($notifiable)
    {
        return ['database'];
    }

    // Notifikasi melalui database
    public function toDatabase($notifiable)
    {
        return [
            'transaction_id' => $this->transaksi->order_id,
            'message' => $this->transaksi->nama.' Melakukan Reservasi!',
            'status' => 'Berhasil',
        ];
    }
    
}
