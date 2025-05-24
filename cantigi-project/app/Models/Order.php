<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'vehicle_id',
        'driver_id',
        'booking_date',
        'booking_time',
        'booking_fuel_level',
        'guarantee_info'
    ];

    public function feedback() {
        return $this->hasMany(Feedback::class);
    }

    public function customers() {
        return $this->belongsTo(Customer::class);
    }

    public function vehicles() {
        return $this->belongsTo(Vehicle::class);
    }

    public function drivers() {
        return $this->belongsTo(Driver::class);
    }

    public function payments() {
        return $this->hasOne(Payment::class);
    }

    public function returnlog() {
        return $this->hasOne(ReturnLog::class);
    }
}
