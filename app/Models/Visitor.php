<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_id',
        'visitor_id',
        'visit_date',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
