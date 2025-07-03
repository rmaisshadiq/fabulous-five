<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnLog extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'order_id',
        'vehicle_id',
        'handler_id',
        'returned_at',
        'fuel_level_on_rent',
        'fuel_level_on_return',
        'notes',
        'status'
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    public function employee() {
        return $this->belongsTo(Employee::class, 'handler_id');
    }
}
