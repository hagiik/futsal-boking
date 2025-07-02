<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Booking extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'user_id', 'field_id', 'booking_date',
        'start_time', 'end_time', 'status',
        'total_price', 'verification_sent',
        'booking_number','expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

protected static function booted()
{
    static::creating(function ($booking) {
        // Cek apakah booking_number belum diisi (biar tidak overwrite)
        if (! $booking->booking_number) {
            $today = now()->format('Ymd');
            $bookingCountToday = static::whereDate('created_at', now())->count() + 1;
            $bookingSequence = str_pad($bookingCountToday, 5, '0', STR_PAD_LEFT);

            // Coba ambil nama user dari relasi user (jika tersedia)
            $username = optional(Auth::user())->name ?? optional($booking->user)->name ?? 'user';
            $usernameSlug = Str::slug($username);

            $randomUnique = Str::random(8);

            $booking->booking_number = "BK-{$today}-{$bookingSequence}-{$usernameSlug}-{$randomUnique}";
        }
    });
}

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
            'booking_number',
            'user_id',
            'field_id',
            'booking_date',
            'start_time',
            'end_time',
            'status',
            'total_price',
        ])
        ->logOnlyDirty() // hanya log jika berubah
        ->useLogName('booking');
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
