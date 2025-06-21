<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * Display payment form
     */
    public function create(Request $request)
    {
        $order_id = $request->get('order_id', 1); // Default order_id jika tidak ada
        return view('main-page', compact('order_id'));
    }

    /**
     * Store payment data to database
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'order_id' => 'required|integer', // Hapus exists jika tidak ada tabel orders
                'payment_method' => 'required|string|in:bca,mandiri,bni,bri,qris',
                'payment_date' => 'required|date',
                'status' => 'required|string|in:paid,pending,failed',
                'transaction_id' => 'required|string|max:255',
                'bank' => 'required|string|in:bca,mandiri,bni,bri',
                'card_number' => 'required|string|min:16|max:19',
                'card_holder_name' => 'required|string|max:255',
                'expiry_date' => 'required|string|regex:/^(0[1-9]|1[0-2])\/\d{2}$/',
                'cvv' => 'required|string|min:3|max:4',
                'amount' => 'required|numeric|min:0',
                'save_card' => 'nullable|boolean'
            ], [
                'bank.required' => 'Silakan pilih bank terlebih dahulu',
                'bank.in' => 'Bank yang dipilih tidak valid',
                'card_number.required' => 'Nomor kartu wajib diisi',
                'card_number.min' => 'Nomor kartu minimal 16 digit',
                'card_holder_name.required' => 'Nama pemegang kartu wajib diisi',
                'expiry_date.required' => 'Tanggal kadaluarsa wajib diisi',
                'expiry_date.regex' => 'Format tanggal kadaluarsa harus MM/YY',
                'cvv.required' => 'CVV wajib diisi',
                'cvv.min' => 'CVV minimal 3 digit',
                'amount.required' => 'Jumlah pembayaran wajib diisi'
            ]);

            // Bersihkan nomor kartu dari spasi
            $cardNumber = str_replace(' ', '', $validated['card_number']);
            
            // Enkripsi atau hash nomor kartu untuk keamanan (opsional)
            // $cardNumber = substr($cardNumber, 0, 4) . str_repeat('*', strlen($cardNumber) - 8) . substr($cardNumber, -4);

            // Simpan ke database
            $payment = Payment::create([
                'order_id' => $validated['order_id'],
                'payment_method' => $validated['bank'],
                'payment_date' => Carbon::now(),
                'amount' => $validated['amount'],
                'status' => 'paid',
                // Tambahan field jika diperlukan
                'card_number' => $cardNumber, // Pertimbangkan keamanan
                'card_holder_name' => $validated['card_holder_name'],
                'transaction_id' => 'TXN-' . time() . '-' . $validated['order_id'],
            ]);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Pembayaran berhasil! ID Transaksi: ' . $payment->transaction_id);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Redirect kembali dengan error validasi
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();

        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Payment Error: ' . $e->getMessage());
            
            // Redirect dengan pesan error
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.')
                ->withInput();
        }
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
public function qrisPayment(Request $request)
{
    // Validasi parameter wajib
    $request->validate([
        'order_id' => 'required|integer|min:1',
        'amount' => 'required|numeric|min:1000' // Minimal Rp 10.000
    ]);

    // Pastikan amount selalu ada
    $amount = $request->amount;
    $order_id = $request->order_id;

    // Debugging (opsional)
    \Log::info("QRIS Payment Initiated", [
        'order_id' => $order_id,
        'amount' => $amount
    ]);

    return view('payment.qris', compact('order_id', 'amount'));
}

public function completeQrisPayment(Request $request)
{
    try {
        // Validasi input dengan pesan error yang jelas
        $validated = $request->validate([
            'order_id' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:1000', // Minimum Rp 10.000
        ], [
            'order_id.required' => 'Order ID harus diisi',
            'amount.required' => 'Jumlah pembayaran harus diisi',
            'amount.min' => 'Minimum pembayaran adalah Rp 1.000'
        ]);

        // Pastikan amount tidak null
        $amount = $validated['amount'] ?? 0;
        
        // Simpan ke database
        $payment = Payment::create([
            'order_id' => $validated['order_id'],
            'payment_method' => 'qris',
            'payment_date' => now(),
            'amount' => $amount,
            'status' => 'paid',
            'transaction_id' => 'QRIS-' . time() . '-' . $validated['order_id'],
        ]);

        return redirect()->route('payment.success', [
            'transaction_id' => $payment->transaction_id
        ])->with('success', 'Pembayaran QRIS berhasil!');

    } catch (\Exception $e) {
        \Log::error('QRIS Payment Error: ' . $e->getMessage());
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
}