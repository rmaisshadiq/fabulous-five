@extends('layouts.main')


@section('content')
<div class="min-h-screen bg-green-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
 <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-8 text-center">
   <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
   </svg>
   <h2 class="mt-4 text-3xl font-extrabold text-gray-900">Pembayaran Berhasil!</h2>
   <p class="mt-2 text-gray-600">Terima kasih, pembayaran Anda telah kami terima.</p>


   <div class="mt-6 text-left space-y-3">
     <div class="flex justify-between">
       <span class="font-medium">Order ID:</span>
       <span class="text-gray-700">{{ $order->order_id }}</span>
     </div>
     <div class="flex justify-between">
       <span class="font-medium">Status:</span>
       <span class="capitalize text-green-600">{{ $order->status }}</span>
     </div>
     <div class="flex justify-between">
       <span class="font-medium">Jumlah:</span>
       <span class="text-gray-700">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
     </div>
   </div>


   <div class="mt-8">
     <a href="{{ route('home') }}"
        class="inline-block bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-lg shadow transition">
       Kembali ke Beranda
     </a>
   </div>
   <div class="mt-4">
     <a href="{{ route('detail-pemesanan', ['id' => $order->order->id]) }}"
        class="inline-block bg-green-100 hover:bg-green-200 text-green-700 font-semibold px-6 py-3 rounded-lg shadow transition">
       Lihat Pesanan
     </a>
   </div>
 </div>
</div>
@endsection
