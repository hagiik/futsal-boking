<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'field_id', 'booking_date',
        'start_time', 'end_time', 'status',
        'total_price', 'verification_sent',
        'booking_number'
    ];
    protected static function booted()
    {
        static::creating(function ($booking) {
            // Format: BK-YYYYMMDD-xxxxx
            $date = now()->format('Ymd');
            $lastNumber = DB::table('bookings')
                ->whereDate('created_at', now()->toDateString())
                ->count() + 1;

            $booking->booking_number = 'BK-' . $date . '-' . str_pad($lastNumber, 5, '0', STR_PAD_LEFT);
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function reward()
    {
        return $this->hasOne(BookingReward::class);
    }
}
