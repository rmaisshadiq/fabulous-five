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
        'return_date',
        'return_time'
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
