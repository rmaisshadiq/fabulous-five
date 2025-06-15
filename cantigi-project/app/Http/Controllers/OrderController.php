<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Vehicle;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
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
            throw $e;
        }

        // Get customer
        $customer = Customer::where('user_id', Auth::id())->first();
        
        if (!$customer) {
            Log::warning('Customer not found for user', ['user_id' => Auth::id()]);
            return redirect()->route('detail-pemesanan')->with('error', 'Please complete your profile first.');
        }

        Log::info('Customer found', [
            'customer_id' => $customer->id,
            'customer_data' => $customer->toArray()
        ]);

        // Check if vehicle exists
        $vehicle = Vehicle::find($request->vehicle_id);
        if (!$vehicle) {
            Log::error('Vehicle not found', ['vehicle_id' => $request->vehicle_id]);
            return back()->with('error', 'Selected vehicle not found.');
        }

        Log::info('Vehicle found', [
            'vehicle_id' => $vehicle->id,
            'vehicle_data' => $vehicle->toArray()
        ]);

        // Check vehicle availability
        $conflictingOrder = Order::where('vehicle_id', $request->vehicle_id)
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('start_booking_date', '<=', $request->end_booking_date)
                      ->where('end_booking_date', '>=', $request->start_booking_date);
                });
            })
            ->whereIn('status', ['pending', 'confirmed', 'in_progress'])
            ->exists();

        if ($conflictingOrder) {
            Log::warning('Vehicle conflict found', [
                'vehicle_id' => $request->vehicle_id,
                'dates' => $request->start_booking_date . ' to ' . $request->end_booking_date
            ]);
            
            $vehicles = Vehicle::select('id', 'brand', 'model', 'license_plate')->get();
            
            return back()
                ->withErrors(['vehicle_id' => 'Vehicle is not available for the selected dates.'])
                ->withInput()
                ->with('vehicles', $vehicles);
        }

        try {
            // Use database transaction for safety
            DB::beginTransaction();

            // Prepare order data
            $orderData = [
                'customer_id' => $customer->id,
                'vehicle_id' => $request->vehicle_id,
                'start_booking_date' => $request->start_booking_date,
                'end_booking_date' => $request->end_booking_date,
                'start_booking_time' => $request->start_booking_time,
                'end_booking_time' => $request->end_booking_time,
                'drop_address' => $request->drop_address,
                'status' => 'pending',
            ];

            Log::info('Creating order with data', $orderData);

            // Check if Order model fillable is set correctly
            $orderModel = new Order();
            Log::info('Order model fillable', [
                'fillable' => $orderModel->getFillable(),
                'guarded' => $orderModel->getGuarded()
            ]);

            // Try to create order
            $order = Order::create($orderData);

            if (!$order) {
                throw new \Exception('Order::create() returned false/null');
            }

            // Verify order was actually saved
            $savedOrder = Order::find($order->id);
            if (!$savedOrder) {
                throw new \Exception('Order was not saved to database');
            }

            Log::info('Order created and verified successfully', [
                'order_id' => $order->id,
                'saved_order_data' => $savedOrder->toArray()
            ]);

            // Check if order exists in database with raw query
            $rawCheck = DB::select('SELECT * FROM orders WHERE id = ?', [$order->id]);
            Log::info('Raw database check', [
                'raw_result' => $rawCheck
            ]);

            DB::commit();

            Log::info('Transaction committed successfully');

            return redirect()->route('detail-pemesanan')->with('success', 'Order submitted successfully! Please wait for admin confirmation.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to create order', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'order_data' => $orderData ?? null
            ]);

            // Check database connection
            try {
                DB::select('SELECT 1');
                Log::info('Database connection is working');
            } catch (\Exception $dbError) {
                Log::error('Database connection failed', [
                    'db_error' => $dbError->getMessage()
                ]);
            }

            $vehicles = Vehicle::select('id', 'brand', 'model', 'license_plate')->get();

            return back()
                ->with('error', 'Failed to create order: ' . $e->getMessage())
                ->withInput()
                ->with('vehicles', $vehicles);
        }
    }

    // Method untuk test database connection
    public function testDatabase()
    {
        try {
            // Test basic connection
            $test = DB::select('SELECT 1 as test');
            
            // Test orders table
            $orderCount = DB::table('orders')->count();
            
            // Test create operation
            $testData = [
                'customer_id' => 1, // adjust as needed
                'vehicle_id' => 1,  // adjust as needed
                'start_booking_date' => now()->toDateString(),
                'end_booking_date' => now()->addDay()->toDateString(),
                'start_booking_time' => '09:00:00',
                'end_booking_time' => '17:00:00',
                'drop_address' => 'Test Address',
                'status' => 'pending'
            ];
            
            $testOrder = DB::table('orders')->insert($testData);
            
            return response()->json([
                'connection' => 'OK',
                'order_count' => $orderCount,
                'test_insert' => $testOrder ? 'Success' : 'Failed'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}