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
    public function vehicles()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    protected static function booted()
    {
        // Saat dibuat
        static::created(function ($maintenance) {
            $vehicle = $maintenance->vehicle;

            if ($vehicle) {
                $vehicle->status = 'maintenance';
                $vehicle->last_maintenance_date = $maintenance->maintenance_date;
                $vehicle->save();
            }
        });

        // Saat dihapus
        static::deleted(function ($maintenance) {
            $vehicle = $maintenance->vehicle;

            if ($vehicle) {
                $remainingMaintenances = $vehicle->maintenances()
                    ->where('id', '!=', $maintenance->id)
                    ->count();

                if ($remainingMaintenances === 0) {
                    $vehicle->status = 'active';
                    $vehicle->last_maintenance_date = $vehicle->purchase_date; // fallback
                } else {
                    $last = $vehicle->maintenances()
                        ->where('id', '!=', $maintenance->id)
                        ->latest('maintenance_date')
                        ->first();

                    $vehicle->last_maintenance_date = $last?->maintenance_date;
                }

                $vehicle->save();
            }
        });
    }
}
