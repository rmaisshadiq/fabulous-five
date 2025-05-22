<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'order_id',
        'customer_id',
        'rating',
        'comment',
        'feedback_date'
    ];

    public function orders() {
        return $this->belongsTo(Order::class);
    }

    public function customers() {
        return $this->belongsTo(Customer::class);
    }
}
