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
}
