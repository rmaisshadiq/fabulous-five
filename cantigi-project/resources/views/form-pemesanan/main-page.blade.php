@extends('layouts.main')

@section('title', 'Create New Order')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Create New Order</h1>

                <form action="{{ route('orders.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Display selected vehicle -->
                    @if(isset($vehicles))
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Selected Vehicle
                            </label>

                            <div class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 shadow-sm text-gray-700">
                                {{ $vehicles->brand }} - {{ $vehicles->model }} ({{ $vehicles->license_plate }})
                            </div>

                            <!-- Hidden input for vehicle_id -->
                            <input type="hidden" name="vehicle_id" value="{{ $vehicles->id }}">
                        </div>
                    @else
                        <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <p>No vehicle selected. Please <a href="{{ route('kendaraan') }}" class="underline">select a vehicle</a> first.</p>
                        </div>
                    @endif

                    <!-- Date Range -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="start_booking_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Start Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="start_booking_date" id="start_booking_date" required
                                min="{{ date('Y-m-d') }}" value="{{ old('start_booking_date') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('start_booking_date') border-red-500 @enderror">
                            @error('start_booking_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_booking_date" class="block text-sm font-medium text-gray-700 mb-2">
                                End Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="end_booking_date" id="end_booking_date" required
                                min="{{ date('Y-m-d') }}" value="{{ old('end_booking_date') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('end_booking_date') border-red-500 @enderror">
                            @error('end_booking_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Time Range -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="start_booking_time" class="block text-sm font-medium text-gray-700 mb-2">
                                Start Time <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="start_booking_time" id="start_booking_time" required
                                value="{{ old('start_booking_time') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('start_booking_time') border-red-500 @enderror">
                            @error('start_booking_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_booking_time" class="block text-sm font-medium text-gray-700 mb-2">
                                End Time <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="end_booking_time" id="end_booking_time" required
                                value="{{ old('end_booking_time') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('end_booking_time') border-red-500 @enderror">
                            @error('end_booking_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Drop Address -->
                    <div>
                        <label for="drop_address" class="block text-sm font-medium text-gray-700 mb-2">
                            Drop Address <span class="text-red-500">*</span>
                        </label>
                        <textarea name="drop_address" id="drop_address" rows="3" required
                            placeholder="Enter the complete address where you want to be dropped off"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('drop_address') border-red-500 @enderror">{{ old('drop_address') }}</textarea>
                        @error('drop_address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex space-x-4">
                        @if(isset($vehicles))
                            <button type="submit"
                                class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                                Submit Order
                            </button>
                        @endif
                        <a href="{{ route('kendaraan') }}"
                            class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-md text-center hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200">
                            {{ isset($vehicles) ? 'Change Vehicle' : 'Select Vehicle' }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Date validation
            const startDateInput = document.getElementById('start_booking_date');
            const endDateInput = document.getElementById('end_booking_date');

            if (startDateInput && endDateInput) {
                startDateInput.addEventListener('change', function () {
                    endDateInput.min = this.value;
                    if (endDateInput.value && endDateInput.value < this.value) {
                        endDateInput.value = this.value;
                    }
                });
            }

            // Form submission handling
            const form = document.querySelector('form[action*="orders"]');
            const submitButton = document.querySelector('button[type="submit"]');
            
            if (form && submitButton) {
                form.addEventListener('submit', function(e) {
                    // Disable submit button to prevent double submission
                    submitButton.disabled = true;
                    submitButton.textContent = 'Submitting...';
                    
                    // Re-enable button after 3 seconds in case of error
                    setTimeout(() => {
                        submitButton.disabled = false;
                        submitButton.textContent = 'Submit Order';
                    }, 3000);
                });
            }
        });
    </script>
@endsection