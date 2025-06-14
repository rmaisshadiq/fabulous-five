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
        'driver_id',
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

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver() {
        return $this->belongsTo(Driver::class);
    }

    public function payment() {
        return $this->hasOne(Payment::class);
    }

    public function returnlog() {
        return $this->hasOne(ReturnLog::class);
    }

    // Fixed accessor with proper null checking
    public function getCustomerNameAttribute()
    {
        // Load the relationship if not already loaded
        if (!$this->relationLoaded('customer')) {
            $this->load('customer.user');
        }
        
        return $this->customer?->user?->name ?? 'Unknown Customer';
    }

    // Fixed accessor with proper null checking
    public function getVehicleNameAttribute()
    {
        // Load the relationship if not already loaded
        if (!$this->relationLoaded('vehicle')) {
            $this->load('vehicle');
        }
        
        return $this->vehicle?->name ?? 'Unknown Vehicle';
    }

    // Fixed accessor with proper null checking
    public function getDriverNameAttribute()
    {
        // Load the relationship if not already loaded
        if (!$this->relationLoaded('driver')) {
            $this->load('driver.user');
        }
        
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