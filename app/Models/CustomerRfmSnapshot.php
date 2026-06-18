<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerRfmSnapshot extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'calculated_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
