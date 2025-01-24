<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $table = 'Transaksi';
    protected $fillable = ['nama','phone','qty','total_price'];
}
