<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    //
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'car_type',
        'brand',
        'model',
        'vehicle_image',
        'license_plate',
        'price_per_day',
        'status',
        'is_best_deal',
        'harga_drop_bandara',
        'harga_city_tour',
        'harga_full_day',
        'harga_luar_kota'
    ];
}
