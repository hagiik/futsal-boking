<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingReward extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['booking_id', 'points_earned'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
