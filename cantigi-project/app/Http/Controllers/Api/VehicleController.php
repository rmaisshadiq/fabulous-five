<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::get();
        if ($vehicles) {
            return VehicleResource::collection($vehicles);
        }
        else {
            return response()->json(['message' => 'Tidak ada record yang tersedia'], 200);
        }
    }

    public function show()
    {
        
    }
}
