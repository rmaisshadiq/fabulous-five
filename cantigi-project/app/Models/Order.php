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

    // Ganti relationship customer dengan user
    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    // Jika masih ingin menggunakan customer() method untuk backward compatibility
    // public function customer() {
    //     return $this->belongsTo(Customer::class, 'user_id', 'user_id');
    // }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver() {
        return $this->belongsTo(Driver::class);
    }

    public function payment() {
        return $this->hasOne(Payment::class);
    }

    public function return_log() {
        return $this->hasOne(ReturnLog::class);
    }

    // // Updated accessor untuk menggunakan user langsung
    // public function getCustomerNameAttribute()
    // {
    //     if (!$this->relationLoaded('users')) {
    //         $this->load('users');
    //     }
        
    //     return $this->user?->name ?? 'Unknown Customer';
    // }

    // // Atau bisa rename jadi getUserNameAttribute untuk lebih konsisten
    // public function getUserNameAttribute()
    // {
    //     if (!$this->relationLoaded('users')) {
    //         $this->load('users');
    //     }
        
    //     return $this->user?->name ?? 'Unknown User';
    // }

    // public function getVehicleNameAttribute()
    // {
    //     if (!$this->relationLoaded('vehicles')) {
    //         $this->load('vehicles');
    //     }
        
    //     return $this->vehicle?->name ?? 'Unknown Vehicle';
    // }

    // public function getDriverNameAttribute()
    // {
    //     if (!$this->relationLoaded('drivers')) {
    //         $this->load('drivers.employees');
    //     }
        
    //     return $this->driver?->user?->name ?? 'Not Assigned';
    // }

    // // Scope untuk filter berdasarkan status
    // public function scopeByStatus($query, $status)
    // {
    //     return $query->where('status', $status);
    // }

    // // Scope untuk order yang aktif (tidak cancelled atau completed)
    // public function scopeActive($query)
    // {
    //     return $query->whereNotIn('status', ['cancelled', 'completed']);
    // }

    // // Scope untuk order berdasarkan user
    // public function scopeByUser($query, $customerId)
    // {
    //     return $query->where('customer_id', $customerId);
    // }

    
}