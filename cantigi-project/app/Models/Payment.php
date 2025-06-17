<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_date',
        'amount',
        'payment_method',
        'status'
    ];

    public function orders() {
        return $this->belongsTo(Order::class);
    }

    public function order_reports() {
        return $this->hasMany(OrderReport::class);
    }
}
