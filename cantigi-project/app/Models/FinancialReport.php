<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'maintenance_id',
        'vehicle_id',
        'order_id',
        'transaction_date',
        'description',
        'amount',
        'type',
        'category',
        'created_by',
        'notes'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class, 'maintenance_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 0, ',', '.');
    }
}
