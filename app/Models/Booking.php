<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_reference',
        'customer_id',
        'created_by_user_id',
        'service_id',
        'therapist_id',
        'appointment_date',
        'start_time',
        'end_time',
        'customer_name',
        'customer_email',
        'customer_phone',
        'notes',
        'status',
        'payment_method',
        'payment_status',
        'service_price',
        'amount_paid',
        'notification_status',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'service_price' => 'decimal:2',
        'amount_paid' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function therapist(): BelongsTo
    {
        return $this->belongsTo(Therapist::class);
    }
}
