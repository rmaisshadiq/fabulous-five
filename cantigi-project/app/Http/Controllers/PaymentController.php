<?php

namespace App\Http\Controllers;

use App\Events\PaymentSuccessful;
use App\Models\Employee;
use App\Models\FinancialReport;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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


        // $payment = Payment::create([
        //     'order_id'              => $order->id, // Your internal foreign key
        //     'midtrans_order_id'     => $midtransOrderId, // The ID you send to Midtrans
        //     'status'                => 'pending',
        //     'amount'                => $order->final_total,
        // ]);

        // Set Midtrans configuration
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
        // $payment->save();


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

    public function callback(Request $request)
    {
        // // ✅ 1. ENABLE SIGNATURE VALIDATION
        // $serverKey = config('services.midtrans.server_key');
        // $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        // if ($hashed != $request->signature_key) {
        //     Log::warning('Invalid Midtrans signature key.', ['request' => $request->all()]);
        //     return response()->json(['message' => 'Invalid signature key'], 403);
        // }

        // Extract data from the request
        $midtransOrderId = $request->order_id;
        $midtransTransactionId = $request->transaction_id;
        $transactionStatus = $request->transaction_status;

        // Use a database transaction to ensure data integrity
        DB::beginTransaction();
        try {
            // Find the associated order
            preg_match('/TXN-(\d+)-(\d+)/', $midtransOrderId, $matches);
            $internalOrderId = $matches[1] ?? null;
            if (!$internalOrderId) {
                throw new \Exception('Failed to parse internal order ID from: ' . $midtransOrderId);
            }

            $order = Order::find($internalOrderId);
            if (!$order) {
                throw new \Exception('Order not found for Midtrans notification. Order ID: ' . $internalOrderId);
            }

            // Check if payment already exists to handle duplicate notifications
            $payment = Payment::where('midtrans_transaction_id', $midtransTransactionId)->first();

            // Define a reusable function for successful payment logic
            $handleSuccess = function ($order, $request) {
                // Check if already processed to avoid duplicate financial reports/vehicle updates
                if ($order->status !== 'in_progress') {
                    $order->status = 'in_progress';
                    $order->save();

                    $systemUserId = Employee::where('position', 'System')->value('id');
                    FinancialReport::create([
                        'vehicle_id' => $order->vehicle_id,
                        'order_id' => $order->id,
                        'transaction_date' => $request->transaction_time,
                        'amount' => $request->gross_amount,
                        'description' => 'Pembayaran untuk pemesanan dengan ID: #' . $request->order_id,
                        'type' => 'income',
                        'category' => 'rental',
                        'created_by' => $systemUserId,
                        'notes' => 'Dihasilkan otomatis oleh Sistem'
                    ]);
                }
            };

            $isSuccess = ($transactionStatus == 'settlement' || $transactionStatus == 'capture');
            $isFailed = ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel');
            $isPending = ($transactionStatus == 'pending');

            if ($payment) { // Payment record exists, update it
                if ($isSuccess && $payment->status !== 'success') {
                    $payment->status = 'success';
                    $handleSuccess($order, $request); // ✅ 3. Handle success logic here too
                } elseif ($isFailed && $payment->status !== 'success') {
                    $payment->status = 'failed';
                    $order->status = 'cancelled';
                    $order->save();
                } elseif ($isPending && $payment->status !== 'success' && $payment->status !== 'pending') {
                    $payment->status = 'pending';
                }
                $payment->save();
            } else { // No payment record, create a new one
                $paymentStatus = 'pending';
                if ($isSuccess) {
                    $paymentStatus = 'success';
                    $handleSuccess($order, $request);
                } elseif ($isFailed) {
                    $paymentStatus = 'failed';
                    $order->status = 'cancelled';
                    $order->save();
                }

                Payment::create([
                    'order_id' => $internalOrderId,
                    'midtrans_transaction_id' => $midtransTransactionId,
                    'midtrans_order_id' => $midtransOrderId,
                    'amount' => $request->gross_amount,
                    'status' => $paymentStatus,
                    'payment_type' => $request->payment_type,
                    'transaction_time' => $request->transaction_time,
                    'raw_response' => json_encode($request->all()),
                ]);
            }

            // ✅ 4. Commit the transaction if everything is successful
            DB::commit();
            return response()->json(['message' => 'Payment notification processed successfully'], 200);
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();

            // Log the error for debugging
            Log::error('Midtrans callback processing failed: ' . $e->getMessage(), [
                'request' => $request->all()
            ]);

            // Return an error response but not 200 OK, so Midtrans might retry
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
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
