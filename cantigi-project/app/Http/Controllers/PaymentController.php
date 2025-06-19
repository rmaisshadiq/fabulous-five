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
}