@extends('layouts.main')

@section('title', 'QRIS Payment')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl">
        <div class="p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Pembayaran QRIS</h1>
                <p class="mt-2 text-gray-600">Total Pembayaran: Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
            </div>
            
            <div class="flex flex-col items-center">
                <!-- QR Code Container -->
                <div class="mb-6 p-4 bg-white rounded-lg border-2 border-dashed border-gray-300">
                    <img src="{{ asset('images/banking/qris1.jpg') }}" alt="QRIS Payment Code" class="w-64 h-64 mx-auto">
                </div>
                
                <!-- Payment Instructions -->
                <div class="w-full bg-blue-50 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-blue-800 mb-2">Cara Pembayaran:</h3>
                    <ol class="list-decimal list-inside text-sm text-gray-700 space-y-1">
                        <li>Buka aplikasi e-wallet atau mobile banking Anda</li>
                        <li>Pilih menu 'Scan QR' atau 'QRIS'</li>
                        <li>Arahkan kamera ke kode QR di atas</li>
                        <li>Konfirmasi jumlah pembayaran</li>
                        <li>Selesaikan transaksi</li>
                    </ol>
                </div>
                
                <!-- Payment Form -->
                <button id="pay-button" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                    Selesaikan Pembayaran
                </button>
                
                <div class="text-center text-sm text-gray-500 mt-4">
                    <p>Pembayaran akan diverifikasi secara otomatis</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection