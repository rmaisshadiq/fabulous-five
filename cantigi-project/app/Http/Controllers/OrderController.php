<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Vehicle;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Halaman index orders customer
    public function index()
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        
        if (!$customer) {
            return redirect()->route('customer.profile')->with('error', 'Please complete your profile first.');
        }

        // Ambil semua order milik customer ini dengan eager loading
        $orders = Order::with(['vehicle', 'driver.user', 'customer.user'])
                      ->where('customer_id', $customer->id)
                      ->orderBy('created_at', 'desc')
                      ->get();

        return view('customer.orders.index', compact('orders'));
    }

    // Form create order
   public function create()
{
    $vehicles = Vehicle::all(); // Atau filter berdasarkan user
    return view('form-pemesanan.main-page', compact('vehicles'));
}


    // Simpan order baru
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_booking_date' => 'required|date|after_or_equal:today',
            'end_booking_date' => 'required|date|after_or_equal:start_booking_date',
            'start_booking_time' => 'required',
            'end_booking_time' => 'required',
            'drop_address' => 'required|string|min:10',
        ]);

        $customer = Customer::where('user_id', Auth::id())->first();
        
        if (!$customer) {
            return redirect()->route('customer.profile')->with('error', 'Please complete your profile first.');
        }

        // Cek apakah kendaraan tersedia dengan proper date/time checking
        $conflictingOrder = Order::where('vehicle_id', $request->vehicle_id)
            ->where(function ($query) use ($request) {
                // Check for date overlaps
                $query->where(function ($q) use ($request) {
                    $q->where('start_booking_date', '<=', $request->end_booking_date)
                      ->where('end_booking_date', '>=', $request->start_booking_date);
                });
            })
            ->whereIn('status', ['pending', 'confirmed', 'in_progress'])
            ->exists();

        if ($conflictingOrder) {
            return back()->withErrors(['vehicle_id' => 'Vehicle is not available for the selected dates.'])->withInput();
        }

        // Simpan order baru
        $order = Order::create([
            'customer_id' => $customer->id,
            'vehicle_id' => $request->vehicle_id,
            'start_booking_date' => $request->start_booking_date,
            'end_booking_date' => $request->end_booking_date,
            'start_booking_time' => $request->start_booking_time,
            'end_booking_time' => $request->end_booking_time,
            'drop_address' => $request->drop_address,
            'status' => 'pending',
        ]);

        return redirect()->route('customer.orders.index')->with('success', 'Order submitted successfully! Please wait for admin confirmation.');
    }

    // Menampilkan detail order
    public function show(Order $order)
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        
        if (!$customer || $order->customer_id !== $customer->id) {
            abort(403); // Forbidden jika bukan order milik customer ini
        }

        // Load relationships to prevent N+1 queries
        $order->load(['vehicle', 'driver.user', 'customer.user']);

        return view('customer.orders.show', compact('order'));
    }

    // Cancel order
    public function cancel(Order $order)
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        
        if (!$customer || $order->customer_id !== $customer->id) {
            abort(403);
        }

        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Cannot cancel this order.');
        }

        // Update status ke cancelled
        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Order cancelled successfully.');
    }
}