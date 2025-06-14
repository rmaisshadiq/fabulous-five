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
        'purchase_date',
        'last_maintenance_date',
        'status'
    ];

    public function maintenances() {
        return $this->hasMany(Maintenance::class, 'vehicle_id');
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
