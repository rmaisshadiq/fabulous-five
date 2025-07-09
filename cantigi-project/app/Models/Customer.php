<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone_number',
        'rental_requirement_id',
        'verification_status'
    ];

    // GANTI dari "users()" ke "user()"
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function feedback() {
        return $this->hasMany(Feedback::class);
    }

    public function order() {
        return $this->hasMany(Order::class);
    }

    public function requirement() {
        return $this->hasOne(RentalRequirements::class);
    }

    public function isVerified(): bool
    {
        return $this->verification_status === 'verified';
    }

    public function needsVerification(): bool
    {
        return $this->verification_status === 'unverified';
    }

    public function isPending(): bool
    {
        return $this->verification_status === 'pending';
    }
}
