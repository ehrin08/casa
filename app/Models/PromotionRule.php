<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromotionRule extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'is_off_peak_only' => 'boolean',
        'valid_from' => 'date',
        'valid_until' => 'date',
    ];

    public function applicableService()
    {
        return $this->belongsTo(Service::class, 'applicable_service_id');
    }

    public function customerPromotions()
    {
        return $this->hasMany(CustomerPromotion::class);
    }
}
