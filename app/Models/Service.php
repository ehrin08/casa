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

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    protected $casts = [
        'price' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'duration_minutes' => 'integer',
    ];
}
