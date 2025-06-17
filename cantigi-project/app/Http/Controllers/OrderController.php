<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Vehicle;
use App\Models\User; // Tambahkan import User
// use App\Models\Customer; // Hapus atau comment jika tidak digunakan lagi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    // Method untuk menampilkan form create dengan kendaraan yang dipilih
    public function create(Request $request)
    {
        $vehicle_id = $request->get('vehicle_id');
        
        if (!$vehicle_id) {
            return redirect()->route('kendaraan')->with('error', 'Please select a vehicle first.');
        }

        $vehicle = Vehicle::find($vehicle_id);
        
        if (!$vehicle) {
            return redirect()->route('kendaraan')->with('error', 'Selected vehicle not found.');
        }

        return view('orders.create', compact('vehicle'));
    }

    // Method untuk menampilkan halaman kendaraan
    public function selectVehicle()
    {
        $vehicles = Vehicle::where('status', 'available')->get();
        return view('kendaraan', compact('vehicles'));
    }

    // Simpan order baru
    public function store(Request $request)
    {
        // Debug log incoming request
        Log::info('Order store attempt', [
            'user_id' => Auth::id(),
            'request_data' => $request->all(),
            'request_method' => $request->method(),
            'request_url' => $request->url()
        ]);

        // Validate input
        try {
            $validated = $request->validate([
                'vehicle_id' => 'required|exists:vehicles,id',
                'start_booking_date' => 'required|date|after_or_equal:today',
                'end_booking_date' => 'required|date|after_or_equal:start_booking_date',
                'start_booking_time' => 'required',
                'end_booking_time' => 'required',
                'drop_address' => 'required|string|min:10',
            ]);

            Log::info('Validation passed', ['validated_data' => $validated]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return back()->withErrors($e->errors())->withInput();
        }

        // Get current authenticated user
        $user = Auth::user();
        
        if (!$user) {
            Log::warning('User not authenticated');
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // Optional: Check if user profile is complete (if needed)
        // if (!$user->name || !$user->email || !$user->phone) {
        //     Log::warning('User profile incomplete', ['user_id' => $user->id]);
        //     return redirect()->route('profile.edit')->with('error', 'Please complete your profile first.');
        // }

        // Check if vehicle exists and is available
        $vehicle = Vehicle::find($validated['vehicle_id']);
        if (!$vehicle) {
            Log::error('Vehicle not found', ['vehicle_id' => $validated['vehicle_id']]);
            return back()->with('error', 'Selected vehicle not found.')->withInput();
        }

        // Check vehicle availability
        $conflictingOrder = Order::where('vehicle_id', $validated['vehicle_id'])
            ->where(function ($query) use ($validated) {
                $query->where(function ($q) use ($validated) {
                    $q->where('start_booking_date', '<=', $validated['end_booking_date'])
                      ->where('end_booking_date', '>=', $validated['start_booking_date']);
                });
            })
            ->whereIn('status', ['pending', 'confirmed', 'in_progress'])
            ->exists();

        if ($conflictingOrder) {
            Log::warning('Vehicle conflict found', [
                'vehicle_id' => $validated['vehicle_id'],
                'dates' => $validated['start_booking_date'] . ' to ' . $validated['end_booking_date']
            ]);
            
            return back()
                ->withErrors(['vehicle_id' => 'Vehicle is not available for the selected dates.'])
                ->withInput();
        }

        try {
            // Use database transaction for safety
            DB::beginTransaction();

            // Create order - langsung menggunakan user_id dari Auth
            $order = Order::create([
                'user_id' => $user->id, // Langsung menggunakan ID dari user yang login
                'vehicle_id' => $validated['vehicle_id'],
                'driver_id' => null, // Will be assigned later by admin
                'start_booking_date' => $validated['start_booking_date'],
                'end_booking_date' => $validated['end_booking_date'],
                'start_booking_time' => $validated['start_booking_time'],
                'end_booking_time' => $validated['end_booking_time'],
                'drop_address' => $validated['drop_address'],
                'status' => 'pending',
            ]);

            Log::info('Order created successfully', [
                'order_id' => $order->id,
                'user_id' => $user->id,
                'order_data' => $order->toArray()
            ]);

            DB::commit();

            return redirect()->route('detail-pemesanan')->with('success', 'Order submitted successfully! Please wait for admin confirmation.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to create order', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'validated_data' => $validated,
                'user_id' => $user->id ?? null
            ]);

            return back()
                ->with('error', 'Failed to create order. Please try again.')
                ->withInput();
        }
    }

    // Method untuk debug database
    public function testDatabase()
    {
        try {
            // Test basic connection
            DB::select('SELECT 1 as test');
            
            // Test orders table structure
            $columns = DB::select('DESCRIBE orders');
            
            // Test orders count
            $orderCount = Order::count();
            
            // Test user and vehicle relationships
            $userCount = User::count(); // Menggunakan User instead of Customer
            $vehicleCount = Vehicle::count();
            
            return response()->json([
                'status' => 'OK',
                'orders_table_columns' => $columns,
                'orders_count' => $orderCount,
                'users_count' => $userCount,
                'vehicles_count' => $vehicleCount,
                'current_user' => Auth::user() // Langsung menggunakan Auth::user()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}