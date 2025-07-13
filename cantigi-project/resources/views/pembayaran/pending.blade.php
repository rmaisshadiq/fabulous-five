@extends('layouts.main') {{-- Use your main application layout --}}

@section('content')
<div class="container" style="text-align: center; padding: 50px 20px;">
    
    <div style="font-size: 60px; color: #ffc107;">
        {{-- You can use a library like Font Awesome for icons --}}
        {{-- <i class="fas fa-clock"></i> --}}
        ⏳
    </div>

    <h1 style="margin-top: 20px; font-size: 2em;">Order Placed, Awaiting Payment</h1>
    
    <p style="font-size: 1.2em; color: #6c757d; margin-top: 10px;">
        Thank you! Your order has been successfully placed. Please complete the payment.
    </p>

    <div style="border: 1px solid #e9ecef; border-radius: 8px; padding: 25px; margin: 30px auto; max-width: 550px; background-color: #f8f9fa;">
        <h3 style="margin-bottom: 20px;">Order Summary</h3>
        <p><strong>Order ID:</strong> #{{ $order->id }}</p>
        <p><strong>Total Amount:</strong> Rp {{ number_format($order->final_total, 0, ',', '.') }}</p>
        
        <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #dee2e6;">
            <h4 style="margin-bottom: 10px;">Payment Instructions</h4>
            {{--
                The best practice is to save the payment instructions (like the VA number)
                from the Midtrans callback to your `payments` table. Then display it here.
            --}}
            <p>Please complete your payment using the Virtual Account number or payment code provided by Midtrans.</p>
            <p><strong>Payment Code / VA Number:</strong> {{ $order->payment->virtual_account ?? 'Check payment details from Midtrans.' }}</p>
        </div>
    </div>

    <a href="{{ route('home') }}" style="display: inline-block; padding: 12px 25px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
        Back to Home
    </a>
</div>
@endsection