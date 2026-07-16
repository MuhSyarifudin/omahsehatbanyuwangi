<?php

namespace App\Jobs;

use App\Models\Transaksi;
use App\Models\WhatsappMessage;
use App\Services\FonnteService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsappJob implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    protected $transaksi;

    protected $message;

    protected $type;

    protected $deviceToken;

    /**
     * Create a new job instance.
     */
    public function __construct(
        Transaksi $transaksi,
        string $message,
        ?string $deviceToken,
        string $type = 'invoice'
    ) {
        $this->transaksi = $transaksi;

        $this->message = $message;

        $this->deviceToken = $deviceToken;

        $this->type = $type;
    }

    /**
     * Execute the job.
     */
    public function handle(
        FonnteService $fonnteService
    ): void {

        try {

            // Jika deviceToken kosong, simpan dengan status 'failed'
            if (!$this->deviceToken) {
                WhatsappMessage::create([
                    'transaksi_id' => $this->transaksi->id,
                    'provider' => 'fonnte',
                    'type' => $this->type,
                    'target_number' => $this->transaksi->nohp,
                    'message' => $this->message,
                    'status' => 'failed',
                    'failure_reason' => 'No active device token found',
                    'status_updated_at' => now(),
                ]);
                return;
            }

            $response = $fonnteService
                ->sendWhatsAppMessage(
                    $this->transaksi->nohp,
                    $this->message,
                    $this->deviceToken
                );

            $data = $response['data'] ?? [];
            $isSuccess = $response['status'] ?? false;

            WhatsappMessage::create([

                'transaksi_id' =>
                    $this->transaksi->id,

                'provider' =>
                    'fonnte',

                'type' =>
                    $this->type,

                'target_number' =>
                    $this->transaksi->nohp,

                'message_id' =>
                    $data['detail'] ?? null,

                'message' =>
                    $this->message,

                'status' =>
                    $isSuccess ? 'sent' : 'failed',

                'failure_reason' =>
                    $data['reason'] ?? $response['error'] ?? null,

                'status_updated_at' =>
                    now(),

                'provider_response' =>
                    $response,
            ]);

        } catch (\Throwable $e) {

            WhatsappMessage::create([

                'transaksi_id' =>
                    $this->transaksi->id,

                'provider' =>
                    'fonnte',

                'type' =>
                    $this->type,

                'target_number' =>
                    $this->transaksi->nohp,

                'message' =>
                    $this->message,

                'status' =>
                    'failed',

                'failure_reason' =>
                    $e->getMessage(),

                'status_updated_at' =>
                    now(),
            ]);

            throw $e;
        }
    }
}