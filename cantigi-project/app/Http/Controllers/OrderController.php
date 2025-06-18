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
            return redirect()->route('kendaraan')->with('error', 'Silakan pilih kendaraan terlebih dahulu.');
        }

        $vehicle = Vehicle::find($vehicle_id);

        if (!$vehicle) {
            return redirect()->route('kendaraan')->with('error', 'Kendaraan yang dipilih tidak ditemukan.');
        }

        // Hanya tampilkan form order jika kendaraan status-nya available
        if ($vehicle->status !== 'available') {
            return redirect()->route('kendaraan')->with('error', 'Kendaraan ini sedang tidak tersedia untuk disewa.');
        }

        return view('orders.create', compact('vehicle'));
    }

    // Simpan order baru
  

public function store(Request $request)
{
    $request->validate([
        'vehicle_id' => 'required|exists:vehicles,id',
        'start_booking_date' => 'required|date',
        'end_booking_date' => 'required|date|after_or_equal:start_booking_date',
        'start_booking_time' => 'required',
        'end_booking_time' => 'required',
        'drop_address' => 'required|string|max:255',
    ]);

    Order::create([
        'customer_id' => Auth::id(),
        'vehicle_id' => $request->vehicle_id,
        'start_booking_date' => $request->start_booking_date,
        'end_booking_date' => $request->end_booking_date,
        'start_booking_time' => $request->start_booking_time,
        'end_booking_time' => $request->end_booking_time,
        'drop_address' => $request->drop_address,
        'status' => 'pending',
    ]);

    return redirect()->route('detail-pemesanan')->with('success', 'Order berhasil dibuat!');
}
}