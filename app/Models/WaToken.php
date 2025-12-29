<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaToken extends Model
{
    use HasFactory;

    public $timestamp = true;
    public $table = 'wa_token';
    protected $fillable = ['nohp','active','token'];
}
