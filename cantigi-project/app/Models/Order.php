<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'vehicle_id',
        'start_booking_date',
        'end_booking_date',
        'start_booking_time',
        'end_booking_time',
        'drop_address',
        'status',
    ];

    public function feedback() {
        return $this->hasMany(Feedback::class);
    }

    public function customer() {
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

    // Accessor agar bisa dipanggil sebagai "customer_name"
    public function getCustomerNameAttribute()
    {
        return $this->customer?->user?->name;
    }

    public function getVehicleNameAttribute()
    {
        return $this->vehicles?->name;
    }
}
