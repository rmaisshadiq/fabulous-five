<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'employees_id',
        'license_number',
        'available_status'
    ];

    public function employees()
    {
        return $this->belongsTo(Employee::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function order_reports()
    {
        return $this->hasMany(Order::class);
    }
}
