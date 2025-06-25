<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FieldSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['field_id', 'day_of_week', 'start_time', 'end_time', 'is_active', 'price_per_hour'];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
