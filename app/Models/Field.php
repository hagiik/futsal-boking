<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Field extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = ['name', 'slug', 'description', 'image', 'field_category_id'];

    protected $casts = [
        'image' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
            'field_category_id',
            'name',
            'slug',
            'description',
            'image',
        ])
        ->logOnlyDirty() // hanya log jika berubah
        ->useLogName('Lapangan');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'field_category_id');
    }

    public function schedules()
    {
        return $this->hasMany(FieldSchedule::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'field_facility');
    }


}
