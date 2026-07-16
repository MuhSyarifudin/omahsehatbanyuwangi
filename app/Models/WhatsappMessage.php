<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappMessage extends Model
{
    protected $fillable = [
        'transaksi_id',
        'provider',
        'type',
        'target_number',
        'message_id',
        'message',
        'status',
        'failure_reason',
        'status_updated_at',
        'provider_response',
    ];

    protected $casts = [
        'provider_response' => 'array',
        'status_updated_at' => 'datetime',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}