<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // Tampilkan form untuk membuat feedback baru
 public function create()
{
    $orders = Order::all();
    $customers = Customer::all();

    return view('feedback.create', compact('orders', 'customers'));
}


    // Simpan feedback baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'customer_id' => 'required|exists:customers,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'feedback_date' => 'required|date',
        ]);

        Feedback::create($request->all());

        return redirect()->back()->with('success', 'Feedback berhasil dikirim.');
    }
}
