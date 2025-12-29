<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifikasiPaymentDone extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $transaksi;

    public function __construct($transaksi)
    {
        $this->transaksi = $transaksi;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the data to database.
     */
    public function toDatabase($notifiable)
    {
        return [
            'transaction_id' => $this->transaksi->order_id,
            'message' => $this->transaksi->nama.' Berhasil Bayar Reservasi!',
            'status' => 'Transaksi Sudah Bayar.',
        ];
    }

}
