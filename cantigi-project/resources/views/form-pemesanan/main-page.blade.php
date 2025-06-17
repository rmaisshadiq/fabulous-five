@extends('layouts.main')

@section('title', 'Create New Order')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Create New Order</h1>

            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('orders.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Selected Vehicle --}}
                @if(isset($vehicles))
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Selected Vehicle</label>
                        <div class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 shadow-sm text-gray-700">
                            {{ $vehicles->brand }} - {{ $vehicles->model }} ({{ $vehicles->license_plate }})
                        </div>
                        <input type="hidden" name="vehicle_id" value="{{ $vehicles->id }}">
                    </div>
                @else
                    <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <p>No vehicle selected. Please <a href="{{ route('kendaraan') }}" class="underline">select a vehicle</a> first.</p>
                    </div>
                @endif

                {{-- Booking Dates --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_booking_date" class="block text-sm font-medium text-gray-700 mb-2">Start Date <span class="text-red-500">*</span></label>
                        <input type="date" name="start_booking_date" id="start_booking_date" required min="{{ date('Y-m-d') }}" value="{{ old('start_booking_date') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md @error('start_booking_date') border-red-500 @enderror">
                        @error('start_booking_date')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="end_booking_date" class="block text-sm font-medium text-gray-700 mb-2">End Date <span class="text-red-500">*</span></label>
                        <input type="date" name="end_booking_date" id="end_booking_date" required min="{{ date('Y-m-d') }}" value="{{ old('end_booking_date') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md @error('end_booking_date') border-red-500 @enderror">
                        @error('end_booking_date')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Booking Times --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_booking_time" class="block text-sm font-medium text-gray-700 mb-2">Start Time <span class="text-red-500">*</span></label>
                        <input type="time" name="start_booking_time" id="start_booking_time" required value="{{ old('start_booking_time') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md @error('start_booking_time') border-red-500 @enderror">
                        @error('start_booking_time')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="end_booking_time" class="block text-sm font-medium text-gray-700 mb-2">End Time <span class="text-red-500">*</span></label>
                        <input type="time" name="end_booking_time" id="end_booking_time" required value="{{ old('end_booking_time') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md @error('end_booking_time') border-red-500 @enderror">
                        @error('end_booking_time')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Drop Address --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Alamat Pengantaran</h3>
                    <div>
                        <label for="drop_address" class="block text-gray-800 font-semibold mb-2">Masukkan Alamat Anda <span class="text-red-500">*</span></label>
                        <input type="text" name="drop_address" id="drop_address" placeholder="Contoh: Jl. By Pass" required
                            value="{{ old('drop_address') }}"
                            class="w-full p-3 rounded-lg border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 focus:outline-none @error('drop_address') border-red-500 @enderror">
                        @error('drop_address')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="flex space-x-4">
                    @if(isset($vehicles))
                        <button type="submit" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Submit Order</button>
                    @endif
                    <a href="{{ route('kendaraan') }}" class="flex-1 text-center bg-gray-300 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-400">
                        {{ isset($vehicle) ? 'Change Vehicle' : 'Select Vehicle' }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection