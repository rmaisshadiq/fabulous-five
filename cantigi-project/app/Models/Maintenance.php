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

    protected static function booted()
{
    // Saat maintenance dibuat
    static::created(function ($maintenance) {
        $vehicle = Vehicle::find($maintenance->vehicle_id);
        if ($vehicle) {
            $vehicle->status = 'maintenance';
            $vehicle->save();
        }
    });

    // Saat maintenance dihapus
    static::deleted(function ($maintenance) {
        $vehicle = Vehicle::find($maintenance->vehicle_id);
        if ($vehicle) {
            // Ambil maintenance terakhir yang masih ada
            $lastMaintenance = Maintenance::where('vehicle_id', $vehicle->id)
                ->orderBy('maintenance_date', 'desc')
                ->first();

            $vehicle->status = 'active';
            $vehicle->last_maintenance_date = $lastMaintenance?->maintenance_date;
            $vehicle->save();
        }
    });
}
}
