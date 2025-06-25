<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembershipPointHistories extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'membership_id',
        'type',
        'points',
        'description',
    ];

    /**
     * Relasi ke Membership
     */
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}
