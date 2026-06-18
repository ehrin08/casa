<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function therapist()
    {
        return $this->hasOne(Therapist::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    public function createdBookings()
    {
        return $this->hasMany(Booking::class, 'created_by_user_id');
    }

    public function therapistAvailabilities(): HasMany
    {
        return $this->hasMany(TherapistAvailability::class, 'creator_id');
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class, 'customer_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'customer_id');
    }

    public function customerPromotions()
    {
        return $this->hasMany(CustomerPromotion::class, 'customer_id');
    }

    public function rfmSnapshot()
    {
        return $this->hasOne(CustomerRfmSnapshot::class, 'customer_id');
    }
}
