<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/vehicles
     */
    public function index()
    {
        $vehicles = Vehicle::all();
        
        if ($vehicles->count() > 0) {
            return VehicleResource::collection($vehicles);
        } else {
            return response()->json([
                'message' => 'Tidak ada record yang tersedia'
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/vehicles
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_type' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'vehicle_image' => 'nullable|string|max:500',
            'license_plate' => 'required|string|max:20|unique:vehicles,license_plate',
            'price_per_day' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'last_maintenance_date' => 'nullable|date',
            'status' => 'required|in:active,retired,maintenance'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $vehicle = Vehicle::create($request->all());
            
            return response()->json([
                'message' => 'Vehicle berhasil dibuat',
                'data' => new VehicleResource($vehicle)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membuat vehicle',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     * GET /api/vehicles/{id}
     */
    public function show($id)
    {
        $vehicle = Vehicle::find($id);
        
        if (!$vehicle) {
            return response()->json([
                'message' => 'Vehicle tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Vehicle ditemukan',
            'data' => new VehicleResource($vehicle)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /api/vehicles/{id}
     */
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::find($id);
        
        if (!$vehicle) {
            return response()->json([
                'message' => 'Vehicle tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'car_type' => 'sometimes|required|string|max:255',
            'brand' => 'sometimes|required|string|max:255',
            'model' => 'sometimes|required|string|max:255',
            'vehicle_image' => 'sometimes|nullable|string|max:500',
            'license_plate' => 'sometimes|required|string|max:20|unique:vehicles,license_plate,' . $id,
            'price_per_day' => 'sometimes|required|numeric|min:0',
            'purchase_date' => 'sometimes|required|date',
            'last_maintenance_date' => 'sometimes|nullable|date',
            'status' => 'sometimes|required|in:active,retired,maintenance'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $vehicle->update($request->all());
            
            return response()->json([
                'message' => 'Vehicle berhasil diupdate',
                'data' => new VehicleResource($vehicle)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengupdate vehicle',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/vehicles/{id}
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);
        
        if (!$vehicle) {
            return response()->json([
                'message' => 'Vehicle tidak ditemukan'
            ], 404);
        }

        try {
            $vehicle->delete();
            
            return response()->json([
                'message' => 'Vehicle berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus vehicle',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search vehicles by criteria
     * GET /api/vehicles/search
     */
    public function search(Request $request)
    {
        $query = Vehicle::query();

        // Search by car type
        if ($request->has('car_type')) {
            $query->where('car_type', 'like', '%' . $request->car_type . '%');
        }

        // Search by brand
        if ($request->has('brand')) {
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }

        // Search by model
        if ($request->has('model')) {
            $query->where('model', 'like', '%' . $request->model . '%');
        }

        // Search by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by price range (per day)
        if ($request->has('min_price_per_day')) {
            $query->where('price_per_day', '>=', $request->min_price_per_day);
        }

        if ($request->has('max_price_per_day')) {
            $query->where('price_per_day', '<=', $request->max_price_per_day);
        }

        // Filter by purchase date range
        if ($request->has('purchase_date_from')) {
            $query->where('purchase_date', '>=', $request->purchase_date_from);
        }

        if ($request->has('purchase_date_to')) {
            $query->where('purchase_date', '<=', $request->purchase_date_to);
        }

        // Filter by maintenance date
        if ($request->has('maintenance_date_from')) {
            $query->where('last_maintenance_date', '>=', $request->maintenance_date_from);
        }

        if ($request->has('maintenance_date_to')) {
            $query->where('last_maintenance_date', '<=', $request->maintenance_date_to);
        }

        $vehicles = $query->get();

        if ($vehicles->count() > 0) {
            return VehicleResource::collection($vehicles);
        } else {
            return response()->json([
                'message' => 'Tidak ada vehicle yang sesuai dengan kriteria pencarian'
            ], 200);
        }
    }
}