@extends('layouts.main')

@section('title', 'Detail pemesanan')

@section('content')
    <section class="bg-gray-50 font-inter min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="flex items-start p-4 mb-4 text-green-800 bg-green-100 border border-green-300 rounded-lg shadow-md animate-fade-in"
                    role="alert">
                    <svg class="w-5 h-5 mr-3 mt-1 shrink-0 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10A8 8 0 11. . . (ikon path disingkat) . . ." clip-rule="evenodd" />
                    </svg>
                    <div>
                        <span class="font-semibold">Sukses!</span> {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- Header Content --}}
            @include('Detail-pemesanan.header-content')

            <!-- Main Content -->
            <div class="bg-white border-l border-r border-gray-200 px-8 py-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- customer information -->
                    @include('Detail-pemesanan.customer-information')
                    <!-- vehicle information -->
                    @include('Detail-pemesanan.vehicle-information')
                    <div class="space-y-6">
                        <!-- booking details -->
                        @include('Detail-pemesanan.booking-detail')
                        <!-- payment summary -->
                        @include('Detail-pemesanan.payment-summary')
                    </div>
                </div>
            </div>

            <!-- footer content -->
            @include('Detail-pemesanan.footer-content')
        </div>
    </section>
@endsection