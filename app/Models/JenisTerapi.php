<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTerapi extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $table = 'jenis_terapi';
    protected $fillable = ['nama'];
}
