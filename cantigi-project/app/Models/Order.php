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
        'driver_id', // Added driver_id to fillable
        'start_booking_date',
        'end_booking_date',
        'start_booking_time',
        'end_booking_time',
        'drop_address',
        'status',
    ];

    protected $casts = [
        'start_booking_date' => 'date',
        'end_booking_date' => 'date',
        'start_booking_time' => 'datetime:H:i',
        'end_booking_time' => 'datetime:H:i',
    ];

    public function feedback() {
        return $this->hasMany(Feedback::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    // Fixed: should be vehicle (singular) not vehicles (plural)
    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    // Fixed: should be driver (singular) not drivers (plural)
    public function driver() {
        return $this->belongsTo(Driver::class);
    }

    public function payment() {
        return $this->hasOne(Payment::class);
    }

    public function returnlog() {
        return $this->hasOne(ReturnLog::class);
    }

    // Accessor untuk mendapatkan nama customer
   public function getCustomerNameAttribute()
{
    return optional($this->customer?->user)->name ?? 'Unknown Customer';
}

    // Fixed: using vehicle instead of vehicles
    public function getVehicleNameAttribute()
    {
        return $this->vehicle?->name;
    }

    // Accessor untuk mendapatkan nama driver
public function getDriverNameAttribute()
{
    return $this->driver?->user?->name ?? 'Not Assigned';
}
    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk order yang aktif (tidak cancelled atau completed)
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['cancelled', 'completed']);
    }
}