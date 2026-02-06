<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'notifications';
    protected $fillable = ['type', 'notifiable_id', 'notifiable_type', 'data', 'read_at'];
}
