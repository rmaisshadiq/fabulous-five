<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Vehicle;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function create()
    {
        $vehicles = Vehicle::where('status', 'available')->get();
        return view('orders.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_booking_date' => 'required|date|after_or_equal:today',
            'end_booking_date' => 'required|date|after_or_equal:start_booking_date',
            'start_booking_time' => 'required',
            'end_booking_time' => 'required',
            'drop_address' => 'required|string|max:255',
        ]);

        // Dapatkan customer_id dari user yang login
        $customer = Customer::where('user_id', Auth::id())->first();
        
        if (!$customer) {
            return redirect()->back()->with('error', 'Customer profile not found.');
        }

        $order = Order::create([
            'customer_id' => $customer->id,
            'vehicle_id' => $validated['vehicle_id'],
            'start_booking_date' => $validated['start_booking_date'],
            'end_booking_date' => $validated['end_booking_date'],
            'start_booking_time' => $validated['start_booking_time'],
            'end_booking_time' => $validated['end_booking_time'],
            'drop_address' => $validated['drop_address'],
            'status' => 'pending', // Status default
        ]);

        return redirect()->route('orders.show', $order)
                        ->with('success', 'Order berhasil dibuat! Menunggu konfirmasi admin.');
    }

    public function show(Order $order)
    {
        // Pastikan customer hanya bisa melihat order mereka sendiri
        $customer = Customer::where('user_id', Auth::id())->first();
        
        if ($order->customer_id !== $customer->id) {
            abort(403, 'Unauthorized access.');
        }

        return view('orders.show', compact('order'));
    }

    public function index()
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        $orders = Order::where('customer_id', $customer->id)
                      ->with(['vehicles', 'payments'])
                      ->orderBy('created_at', 'desc')
                      ->get();

        return view('orders.index', compact('orders'));
    }
}