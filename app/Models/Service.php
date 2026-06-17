<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'category',
        'price',
        'duration_minutes',
        'commission_rate',
        'description',
        'status',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    protected $casts = [
        'price' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'duration_minutes' => 'integer',
    ];
}
