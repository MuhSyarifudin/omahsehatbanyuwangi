<?php

namespace App\Console\Commands;

use App\Events\NotificationBellEvent;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CancelExpiredReservasi extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservasi:cancel-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel reservasi yang belum dibayar lebih dari 1 hari';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expired = Transaksi::where('status', 'pending')
        ->where('created_at', '<=', Carbon::now()->subHours(24))
        ->update([
            'status' => 'expired'
        ]);
        
        event(new NotificationBellEvent());

    $this->info("Reservasi expired dibatalkan: {$expired}");
    }
}
