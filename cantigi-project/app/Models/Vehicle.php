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
        'vehicle_name',
        'vehicle_image',
        'license_plate',
        'purchase_date',
        'last_maintenance_date',
        'status'
    ];
}
