<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'maintenance_date',
        'description',
        'cost'
    ];

    // Perbaiki relasi, cukup satu kendaraan
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function financial_report()
    {
        return $this->hasMany(FinancialReport::class, 'maintenance_id');
    }

    protected static function booted()
{
    // Saat maintenance dibuat
    static::created(function ($maintenance) {
        $vehicle = Vehicle::find($maintenance->vehicle_id);
        $systemUserId = Employee::where('position', 'System')->first()->id;
        if ($vehicle) {
            $vehicle->status = 'maintenance';
            $vehicle->save();
        }
        
        // Buat FinancialReport
        FinancialReport::create([
            'maintenance_id' => $maintenance->id,
            'transaction_date' => $maintenance->maintenance_date,
            'description' => $maintenance->description,
            'amount' => $maintenance->cost,
            'type' => 'expense',
            'category' => 'maintenance',
            'created_by' => $systemUserId,
            'notes' => 'Dihasilkan otomatis oleh Sistem'
        ]);
    });
}
}
