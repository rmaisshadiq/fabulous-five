<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'license_number',
        'available_status'
    ];

    public function employees() {
        return $this->belongsTo(Employee::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
