<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public $table = 'device';
    protected $fillable = [
        'name', 
        'token', 
        'device',
        'is_active',
        'qr_url',
        'qr_requested_at',
        'is_activated'
    ];
}
