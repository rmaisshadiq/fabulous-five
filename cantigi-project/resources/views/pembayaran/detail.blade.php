@extends('layouts.main')


@section('content')
<div class="container mx-auto py-8">
 <h1 class="text-2xl font-bold mb-4">Detail Pembayaran</h1>


 <div class="bg-white shadow rounded p-6 space-y-3">
   <p><strong>Order ID:</strong> {{ $payment->order_id }}</p>
   <p><strong>Tanggal:</strong> {{ $payment->created_at->format('d M Y H:i') }}</p>
   <p><strong>Nama:</strong> {{ $payment->order->customer->user->name }}</p>
   <p><strong>Email:</strong> {{ $payment->order->customer->user->email }}</p>
   <p><strong>Jumlah:</strong> Rp {{ number_format($payment->amount) }}</p>
   <p><strong>Status:</strong> <span class="capitalize">{{ $payment->status }}</span></p>
   <p><strong>Metode:</strong> {{ $payment->payment_method ?? '-' }}</p>
   <p><strong>Transaction ID:</strong> {{ $payment->transaction_id ?? '-' }}</p>


   <div>
     <a href="{{ route('payment.history') }}" class="text-blue-600 hover:underline">
       &larr; Kembali ke Riwayat
     </a>
   </div>
 </div>
</div>
@endsection
