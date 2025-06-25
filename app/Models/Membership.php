<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'total_points', 'level'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pointHistories()
    {
        return $this->hasMany(MembershipPointHistories::class);
}

}
