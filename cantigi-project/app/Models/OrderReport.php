<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderReport extends Model
{
    protected $fillable = [
        'customer_id',
        'vehicle_id',
        'driver_id',
        'payment_id',
        'order_id'
    ];

    public function customers() {
        return $this->belongsTo(User::class);
    }
    
    public function vehicles() {
        return $this->belongsTo(Vehicle::class);
    }
    
    public function drivers() {
        return $this->belongsTo(Driver::class);
    }

    public function payments() {
        return $this->belongsTo(Payment::class);
    }

    public function orders() {
        return $this->belongsTo(Order::class);
    }


}
