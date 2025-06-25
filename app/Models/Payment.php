<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_id', 'amount', 'method', 'status',
        'payment_url', 'paid_at'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
