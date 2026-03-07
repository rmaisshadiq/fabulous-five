<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Menampilkan halaman utama dengan semua kendaraan dan filter.
     */
    public function index()
    {
        // Ambil semua kendaraan untuk tampilan awal
        $vehicles = Vehicle::where('status', 'active')->latest()->get();

        // Ambil semua tipe mobil yang unik dan tidak null untuk dropdown filter
        $carTypes = Vehicle::query()
            ->whereNotNull('car_type')
            ->pluck('car_type')
            ->unique()
            ->sort();

        // Kirim data ke view
        return view('kendaraan.car.mainPageMobil', [
            'vehicles' => $vehicles,
            'carTypes' => $carTypes,
        ]);
    }

    /**
     * Menangani permintaan filter via AJAX.
     */
    public function filter(Request $request)
    {
        // Mulai query builder
        $query = Vehicle::query();

        // Jika ada car_type yang dipilih dan bukan "semua"
        if ($request->filled('car_type') && $request->car_type !== 'all') {
            $query->where('car_type', $request->car_type);
        }

        // Ambil data kendaraan yang sudah difilter
        $vehicles = $query->latest()->get();

        // Kembalikan hanya bagian view slider-nya saja (partial view)
        // Ini akan menggantikan konten lama dengan yang baru secara dinamis
        return view('kendaraan.car.vehicle-slider-container', compact('vehicles'))->render();
    }
}
