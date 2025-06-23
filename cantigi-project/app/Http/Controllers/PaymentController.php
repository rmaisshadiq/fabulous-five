<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Display payment form
     */
    public function create(Request $request, $id)
    {
        $orders = Order::find($id);
        if ($orders->customer_id != Auth::user()->id) {
            return redirect()->route('home');
        }
        if (!$orders) {
            return redirect()->route('home');
        }
        if ($orders->status != 'confirmed') {
            return redirect()->back()->with('error', 'Pemesanan anda belum dikonfirmasi!');
        }
        // Check if payment already exists for this order
        $existingPayment = Payment::where('order_id', $orders->id)->first();

        if ($existingPayment) {
            return redirect()->route('payment.qris', $existingPayment->id);
        }
        
        return view('pembayaran.main-page', compact('orders'));
    }

    /**
     * Store payment information
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:1000' // Minimal Rp 10.000
        ]);

        $order = Order::find($request->order_id);

        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $request->amount,
            'status' => 'processing', // or 'processing'
            'payment_date' => now(),
            // Add other fields as needed
        ]);

        return redirect()->route('payment.qris', $payment->id);
    }

    /**
     * Show payment success page
     */
    public function success(Request $request)
    {
        $transaction_id = $request->get('transaction_id');
        $payment = Payment::where('transaction_id', $transaction_id)->first();

        return view('payment.success', compact('payment'));
    }

    // Tambahkan method baru di PaymentController
    public function qrisPayment($id)
    {
        $payment = Payment::with('order')->findOrFail($id);
        if ($payment->order->customer_id != Auth::user()->id) {
            return redirect()->route('home');
        }

        return view('pembayaran.qris', compact('payment'));
    }

    public function completeQrisPayment($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update([
            'status' => 'paid',
            'completed_at' => now(),
            'transaction_id' => $payment->getTransactionId()
        ]);

        if ($payment->order && $payment->order->vehicle) {
            $payment->order->vehicle->update([
                'status' => 'rented',
            ]); 
        }

        if ($payment->order) {
            $payment->order->update([
                'status' => 'in_progress',
            ]);
        }

        // return redirect()->route('payment.success', ['transaction_id' => $payment->transaction_id]);
        return redirect()->route('order-history');
    }
}
