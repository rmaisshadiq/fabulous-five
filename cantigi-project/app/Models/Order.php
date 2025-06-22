<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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

    public function feedback() {
        return $this->hasMany(Feedback::class);
    }

    // Ganti relationship customer dengan user
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

    public function return_log() {
        return $this->hasOne(ReturnLog::class);
    }

    public function getAdminFeeAttribute()
    {
        return 2500;
    }

    public function getTaxAttribute()
    {
        return $this->total_price * 0.11; // 11%
    }

    public function getFinalTotalAttribute()
    {
        return $this->total_price + $this->admin_fee + $this->tax;
    }

    // Format currency for display
    public function getFormattedTotalPriceAttribute()
    {
        return number_format($this->total_price, 0, ',', '.');
    }

    public function getFormattedAdminFeeAttribute()
    {
        return number_format($this->admin_fee, 0, ',', '.');
    }

    public function getFormattedTaxAttribute()
    {
        return number_format($this->tax, 0, ',', '.');
    }

    public function getFormattedFinalTotalAttribute()
    {
        return number_format($this->final_total, 0, ',', '.');
    }

    public function getDurationAttribute()
    {
        if (!$this->start_booking_date || !$this->end_booking_date || 
            !$this->start_booking_time || !$this->end_booking_time) {
            return 'Data tidak lengkap';
        }

        try {
            // Gabungkan date dan time dengan format yang benar
            $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', 
                $this->start_booking_date . ' ' . $this->start_booking_time);
            $endDateTime = Carbon::createFromFormat('Y-m-d H:i:s', 
                $this->end_booking_date . ' ' . $this->end_booking_time);
            
            $diffInHours = $startDateTime->diffInHours($endDateTime);
            $diffInDays = $startDateTime->diffInDays($endDateTime);
            
            // Format output berdasarkan durasi
            if ($diffInHours < 24) {
                return $diffInHours . ' Jam';
            } elseif ($diffInDays == 1) {
                return '1 Hari (' . $diffInHours . ' Jam)';
            } else {
                return $diffInDays . ' Hari (' . $diffInHours . ' Jam)';
            }
        } catch (\Exception $e) {
            // Debug: Log error untuk melihat data sebenarnya
            Log::error('Duration calculation error: ' . $e->getMessage(), [
                'start_booking_date' => $this->start_booking_date,
                'end_booking_date' => $this->end_booking_date,
                'start_booking_time' => $this->start_booking_time,
                'end_booking_time' => $this->end_booking_time,
                'concatenated_start' => $this->start_booking_date . ' ' . $this->start_booking_time,
                'concatenated_end' => $this->end_booking_date . ' ' . $this->end_booking_time
            ]);
            
            return 'Error menghitung durasi';
        }
    }

    // Accessor untuk mendapatkan durasi dalam jam
    public function getDurationInHoursAttribute()
    {
        if (!$this->start_booking_date || !$this->end_booking_date) {
            return 0;
        }

        $startDateTime = Carbon::parse($this->start_booking_date . ' ' . $this->start_booking_time);
        $endDateTime = Carbon::parse($this->end_booking_date . ' ' . $this->end_booking_time);
        
        return $startDateTime->diffInHours($endDateTime);
    }

    // Accessor untuk mendapatkan durasi dalam hari
    public function getDurationInDaysAttribute()
    {
        if (!$this->start_booking_date || !$this->end_booking_date) {
            return 0;
        }

        $startDateTime = Carbon::parse($this->start_booking_date . ' ' . $this->start_booking_time);
        $endDateTime = Carbon::parse($this->end_booking_date . ' ' . $this->end_booking_time);
        
        return $startDateTime->diffInDays($endDateTime);
    }

    public function getTotalPriceAttribute()
    {
        if (!$this->vehicle_id || !$this->duration_in_days) {
            return 0;
        }

        $vehicle = Vehicle::find($this->vehicle_id);
        return $vehicle->price_per_day * $this->duration_in_days;
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