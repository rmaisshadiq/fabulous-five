<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];

    // GANTI dari "users()" ke "user()"
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function feedback() {
        return $this->hasMany(Feedback::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function requirements() {
        return $this->hasOne(RentalRequirements::class);
    }


}
