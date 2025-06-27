<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    /**
     * Display payment form
     */
    public function create(Request $request, $id)
    {
        // $orders = Order::find($id);
        // if ($orders->customer_id != Auth::user()->id) {
        //     return redirect()->route('home');
        // }
        // if (!$orders) {
        //     return redirect()->route('home');
        // }
        // if ($orders->status != 'confirmed') {
        //     return redirect()->back()->with('error', 'Pemesanan anda belum dikonfirmasi!');
        // }
        // // Check if payment already exists for this order
        // $existingPayment = Payment::where('order_id', $orders->id)->first();

        // if ($existingPayment) {
        //     return redirect()->route('payment.qris', $existingPayment->id);
        // }
        $orders = Order::find($id);
        return view('pembayaran.main-page', compact('orders'));
    }

    /**
     * Store payment information
     */
    public function store(Request $request)
    {
        $order = Order::find($request->order_id);
        if (!$order) {
            // Handle order not found error
            abort(404, 'Order not found');
        }

        // Create unique transaction reference for Midtrans
        $midtransOrderId = 'TXN-' . $order->id . '-' . time();


        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized  = config('services.midtrans.is_sanitized');
        Config::$is3ds        = config('services.midtrans.is_3ds');



        $params = [
            'transaction_details' => [
                'order_id'     => $midtransOrderId,
                'gross_amount' => $order->final_total,
            ],
            'customer_details' => [
                'first_name' => $order->customer->user->name,
                'email'      => $order->customer->user->email,
            ],
        ];


        $snapToken = Snap::getSnapToken($params);


        return view('pembayaran.snap', compact('snapToken', 'order', 'midtransOrderId'));
    }

    /**
     * Show payment success page
     */
    public function success($orderId)
    {
        $order = Payment::where('order_id', $orderId)->firstOrFail();
        return view('pembayaran.success', compact('order'));
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

    public function callback(Request $request)
    {
        // $serverKey = config('services.midtrans.server_key');
        // $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        // if ($hashed != $request->signature_key) {
        //     return response()->json(['message' => 'Invalid signature key'], 403);
        // }

        $transactionStatus = $request->transaction_status;
        $midtransOrderId   = $request->order_id;    // This is your TXN-order_id-timestamp
        $midtransTransactionId = $request->transaction_id; // Midtrans' unique payment ID
        $paymentType       = $request->payment_type;
        $grossAmount       = $request->gross_amount;
        $transactionTime   = $request->transaction_time;

        // Extract your internal order_id from the midtransOrderId
        // Assuming your format is 'TXN-{internal_order_id}-{timestamp}'
        preg_match('/TXN-(\d+)-(\d+)/', $midtransOrderId, $matches);
        $internalOrderId = $matches[1] ?? null;

        if (!$internalOrderId) {
            return response()->json(['message' => 'Failed to parse internal order ID from Midtrans order_id'], 400);
        }

        // Find the associated order (optional, but good for validation/context)
        $order = Order::find($internalOrderId);
        if (!$order) {
            // Log this error: Notification for non-existent order.
            return response()->json(['message' => 'Order not found for notification'], 404);
        }

        // CRITICAL: Check if a payment record for this Midtrans transaction_id already exists
        // This handles duplicate notifications from Midtrans (which can happen).
        $payment = Payment::where('midtrans_transaction_id', $midtransTransactionId)->first();

        if ($payment) {
            // Payment record already exists. Update its status if it's a more final status.
            // Example: If current status is 'pending' and new is 'settlement', update.
            // Avoid overwriting a 'success' with a 'pending' from a delayed notification.
            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                if ($payment->status !== 'success') { // Only update if not already successful
                    $payment->status = 'success';
                    $payment->save();
                    // You might also want to update the order status here
                    $order->status = 'completed'; // Or 'paid'
                    $order->save();
                }
            } elseif ($transactionStatus == 'pending') {
                if ($payment->status !== 'success' && $payment->status !== 'pending') {
                    $payment->status = 'pending';
                    $payment->save();
                }
            } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                if ($payment->status !== 'failed' && $payment->status !== 'success') { // Don't revert success
                    $payment->status = 'failed';
                    $payment->save();
                    $order->status = 'cancelled'; // Or 'payment_failed'
                    $order->save();
                }
            }
            // Always return 200 OK to Midtrans to acknowledge receipt.
            return response()->json(['message' => 'Payment record already exists and updated if necessary'], 200);
        }

        // If no existing payment record, create a new one
        $paymentStatus = 'pending'; // Default
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $paymentStatus = 'success';
            $order->status = 'completed'; // Update order status
            $order->save();
        } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $paymentStatus = 'failed';
            $order->status = 'cancelled'; // Update order status
            $order->save();
        }
        // 'pending' is the default if no match above

        Payment::create([
            'order_id' => $internalOrderId,
            'midtrans_transaction_id' => $midtransTransactionId,
            'midtrans_order_id' => $midtransOrderId, // Your generated TXN-ID
            'amount' => $grossAmount,
            'status' => $paymentStatus,
            'payment_type' => $paymentType,
            'transaction_time' => $transactionTime,
            'raw_response' => json_encode($request->all()), // Store the full response
            // Add other fields you deem necessary from the Midtrans payload
        ]);

        return response()->json(['message' => 'Payment processed successfully'], 200);
    }
    public function history()
    {
        $payments = Payment::orderBy('created_at', 'desc')->paginate(10);


        return view('payment.history', compact('payments'));
    }



    public function detail($orderId)
    {
        $payments = Payment::where('order_id', $orderId)->firstOrFail();
        return view('payment.detail', compact('payment'));
    }
}
