<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\BusRoute;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Menampilkan halaman utama dengan semua kendaraan dan filter.
     */
    public function index()
    {
        // 1. Ambil semua kendaraan (opsional: filter yang active aja)
        $vehicles = Vehicle::where('status', 'active')->latest()->get();

        // 2. THE ULTIMATE FIX: Ambil data rute bus BESERTA relasi harganya
        $busRoutes = BusRoute::with('prices')->get();

        // 3. Kirim data ke view
        return view('kendaraan.car.mainPageMobil', [
            'vehicles' => $vehicles,
            'busRoutes' => $busRoutes, // Berasnya kita kirim ke mari!
        ]);
    }
}
