@extends('layouts.main')

@section('title', 'Create New Order')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Create New Order</h1>

                <!-- Debug info - remove in production -->
                @if(env('APP_DEBUG'))
                    <div class="mb-4 p-3 bg-yellow-100 rounded">
                        <p><strong>Debug Info:</strong></p>
                        <p>Vehicles exists: {{ isset($vehicles) ? 'Yes' : 'No' }}</p>
                        <p>Vehicles type: {{ isset($vehicles) ? gettype($vehicles) : 'Not set' }}</p>
                        <p>Vehicles count: {{ isset($vehicles) && is_object($vehicles) && method_exists($vehicles, 'count') ? $vehicles->count() : 'N/A' }}</p>
                        <p>User ID: {{ Auth::id() }}</p>
                        <p>Old vehicle_id: {{ old('vehicle_id') }}</p>
                        @if(isset($vehicles) && $vehicles->count() > 0)
                            <p>First vehicle: {{ $vehicles->first()->brand ?? 'N/A' }} - {{ $vehicles->first()->model ?? 'N/A' }}</p>
                        @endif
                    </div>
                @endif

                <form action="{{ route('orders.store') }}" method="POST" class="space-y-6">
                    @csrf

                <!-- Read-only display of selected vehicle -->
<!-- Tampilkan informasi kendaraan yang sudah dipilih -->
@if(isset($vehicles) && $vehicles->count() > 0)
    @php $vehicle = $vehicles->first(); @endphp

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Selected Vehicle
        </label>

        <div class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 shadow-sm text-gray-700">
            {{ $vehicle->brand }} - {{ $vehicle->model }} ({{ $vehicle->license_plate }})
        </div>

        <!-- Simpan vehicle_id sebagai hidden input -->
        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
    </div>
@else
    <p class="text-red-500">No vehicle selected.</p>
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
                        <button type="submit"
                            class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                            Submit Order
                        </button>
                        <a href="{{ route('kendaraan') }}"
                            class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-md text-center hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const startDateInput = document.getElementById('start_booking_date');
            const endDateInput = document.getElementById('end_booking_date');

            startDateInput.addEventListener('change', function () {
                endDateInput.min = this.value;
                if (endDateInput.value && endDateInput.value < this.value) {
                    endDateInput.value = this.value;
                }
            });
        });
   
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form[action*="orders"]');
    const submitButton = document.querySelector('button[type="submit"]');
    
    // Debug form elements
    console.log('Form found:', !!form);
    console.log('Form action:', form ? form.action : 'No form');
    console.log('Form method:', form ? form.method : 'No form');
    
    // Debug CSRF token
    const csrfToken = document.querySelector('input[name="_token"]');
    console.log('CSRF token found:', !!csrfToken);
    console.log('CSRF token value:', csrfToken ? csrfToken.value.substring(0, 10) + '...' : 'No token');
    
    // Add form submission handler
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form submission triggered');
            
            // Log all form data
            const formData = new FormData(form);
            console.log('Form data being submitted:');
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }
            
            // Check if all required fields are filled
            const requiredFields = ['vehicle_id', 'start_booking_date', 'end_booking_date', 'start_booking_time', 'end_booking_time', 'drop_address'];
            const missingFields = [];
            
            requiredFields.forEach(field => {
                const input = form.querySelector(`[name="${field}"]`);
                if (!input || !input.value) {
                    missingFields.push(field);
                }
            });
            
            if (missingFields.length > 0) {
                console.error('Missing required fields:', missingFields);
                alert('Missing required fields: ' + missingFields.join(', '));
                e.preventDefault();
                return false;
            }
            
            // Disable submit button to prevent double submission
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Submitting...';
            }
            
            console.log('Form validation passed, submitting...');
        });
    }
    
    // Date validation script (existing)
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
});

// Debug page load
window.addEventListener('load', function() {
    console.log('Page loaded completely');
    console.log('Current URL:', window.location.href);
    console.log('Referrer:', document.referrer);
});
</script>
@endsection