<?php

namespace App\Listeners;

use App\Events\NotificationBellEvent;
use App\Events\NotifikasiPaymentBerhasilEvent;
use App\Jobs\SendWhatsappJob;
use App\Models\Device;
use App\Models\User;
use App\Notifications\NotifikasiPaymentDone;
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
        $transaksi = $event->transaksi;
        
        // Kirim notification ke admin
        $admins = User::where('role','admin')->get();
        Notification::send($admins,new NotifikasiPaymentDone($transaksi));

        event(new NotificationBellEvent());
        
        // Ambil device token yang aktif
        $token = Device::where('is_activated', true)->value('token');

        // Buat pesan WhatsApp
        if ($transaksi->tempat == "center") {
            $message = "
Halo ".$transaksi->nama.",

Reservasi Anda telah berhasil dikonfirmasi dan pembayaran sudah kami terima.

*Detail Reservasi*  
*Nama:* ".$transaksi->nama."  
*No. Whatsapp:* ".$transaksi->nohp."  
*Layanan:* ".$transaksi->tempat."  
*Tanggal:* ".dateid('l, j F Y', $transaksi->tanggal)."  
*Jam:* ".$transaksi->jam."  
*Jenis Terapi:* ".$transaksi->nama_terapi." - ".$transaksi->nama_jenis_terapi."  
*Jumlah Peserta:* ".$transaksi->jumlah." Orang  
*Total Harga:* ".rupiah($transaksi->total_harga)."  

Transaksi Anda *Berhasil/Lunas*!  
Silakan kunjungi tempat terapi kami pada *".dateid('l, j F Y', $transaksi->tanggal)."*  

*Lokasi Kami:* https://maps.app.goo.gl/4zxYbCwPog1yeE2a7

Terima kasih telah mempercayai layanan kami!
        ";
        } else {
            $message = "
Halo ".$transaksi->nama.",

Reservasi Anda telah berhasil dikonfirmasi dan pembayaran sudah kami terima.

*Detail Reservasi*  
*Nama:* ".$transaksi->nama."  
*No. Whatsapp:* ".$transaksi->nohp."  
*Layanan:* ".$transaksi->tempat."  
*Alamat*: ".$transaksi->alamat."  
*Tanggal:* ".dateid('l, j F Y', $transaksi->tanggal)."  
*Jam:* ".$transaksi->jam."  
*Jenis Terapi:* ".$transaksi->nama_terapi." - ".$transaksi->nama_jenis_terapi."  
*Jumlah Peserta:* ".$transaksi->jumlah." Orang  
*Total Harga:* ".rupiah($transaksi->total_harga)."  

Transaksi Anda *Berhasil/Lunas*!  
Kunjungan ke tempat Anda akan dilakukan pada *".dateid('l, j F Y', $transaksi->tanggal)."*  

*Lokasi Kami*: https://maps.app.goo.gl/4zxYbCwPog1yeE2a7  

Terima kasih telah mempercayai layanan kami!
        ";
        }

        // Dispatch WhatsApp job
        SendWhatsappJob::dispatch(
            $transaksi,
            $message,
            $token,
            'invoice'
        );

    }

}
