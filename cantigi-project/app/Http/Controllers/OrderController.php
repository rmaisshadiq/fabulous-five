<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Vehicle;
use App\Models\User; // Tambahkan import User
use Barryvdh\DomPDF\Facade\Pdf;
// use App\Models\Customer; // Hapus atau comment jika tidak digunakan lagi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

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
        try {
            // Validate the request
            $validatedData = $request->validate([
                'vehicle_id' => 'required|exists:vehicles,id',
                'start_booking_date' => 'required|date|after_or_equal:today',
                'end_booking_date' => 'required|date|after_or_equal:start_booking_date',
                'start_booking_time' => 'required|string',
                'end_booking_time' => 'required|string',
            ]);

            // Check if vehicle is available
            $vehicle = Vehicle::findOrFail($validatedData['vehicle_id']);

            if ($vehicle->status !== 'active') {
                return response()->json([
                    'success' => false,
                    'message' => 'Kendaraan tidak tersedia untuk dibooking'
                ], 400);
            }

            // Check for overlapping bookings
            $existingBooking = Order::where('vehicle_id', $validatedData['vehicle_id'])
                ->where('status', 'in_progress')
                ->where(function ($query) use ($validatedData) {
                    $query->whereBetween('start_booking_date', [
                        $validatedData['start_booking_date'],
                        $validatedData['end_booking_date']
                    ])
                        ->orWhereBetween('end_booking_date', [
                            $validatedData['start_booking_date'],
                            $validatedData['end_booking_date']
                        ])
                        ->orWhere(function ($q) use ($validatedData) {
                            $q->where('start_booking_date', '<=', $validatedData['start_booking_date'])
                                ->where('end_booking_date', '>=', $validatedData['end_booking_date']);
                        });
                })
                ->exists();

            if ($existingBooking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tanggal yang dipilih tidak tersedia'
                ], 400);
            }

            // Create the order
            DB::beginTransaction();

            $order = Order::create([
                'customer_id' => Auth::id(), // Make sure user is authenticated
                'vehicle_id' => $validatedData['vehicle_id'],
                'start_booking_date' => $validatedData['start_booking_date'],
                'end_booking_date' => $validatedData['end_booking_date'],
                'start_booking_time' => $validatedData['start_booking_time'],
                'end_booking_time' => $validatedData['end_booking_time'],
                'status' => 'confirmed', // or 'pending' based on your business logic
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();



            $redirectUrl = route('detail-pemesanan', [
                'id' => $order->id,
            ]);

            // Flash the success message to the session
            session()->flash('success', 'Order telah berhasil dikirim! Silahkan lanjut ke pembayaran.');

            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil dibuat',
                'redirect_url' => $redirectUrl
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollback();

            // Log the error
            Log::error('Order creation failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses booking'
            ], 500);
        }
    }

    public function show(Request $request, $id)
    {
        $orders = Order::where('id', $id)->firstOrFail();
        // Create unique transaction reference for Midtrans
        $midtransOrderId = 'TXN-' . $orders->id . '-' . time();

        // Set Midtrans configuration
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized  = config('services.midtrans.is_sanitized');
        Config::$is3ds        = config('services.midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id'     => $midtransOrderId,
                'gross_amount' => $orders->getFinalTotalAttribute(),
            ],
            'customer_details' => [
                'first_name' => $orders->customer->user->name,
                'email'      => $orders->customer->user->email,
            ],
        ];


        $snapToken = Snap::getSnapToken($params);
        // Generate the URL for the detail page

        return view('Detail-pemesanan.main-page', compact('orders', 'snapToken', 'midtransOrderId'));
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
            $userCount = Customer::count(); // Menggunakan User instead of Customer
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

    public function downloadInvoicePDF(Order $order)
    {
        // Data to pass to the view
        $data = ['order' => $order];

        // Load the view and pass in the data
        $pdf = Pdf::loadView('invoices.pdf_template', $data);

        // Set paper size and orientation
        $pdf->setPaper('a4', 'portrait');

        // Stream the PDF to the browser for download
        return $pdf->download('invoice-' . $order->id . '.pdf');
    }

    public function showPending(Order $order)
    {
        return view('pembayaran.pending', ['order' => $order]);
    }
}
