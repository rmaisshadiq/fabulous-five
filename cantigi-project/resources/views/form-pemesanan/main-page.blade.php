<!-- {{-- resources/views/kendaraan/index.blade.php --}}
@extends('layouts.main')

@section('title', 'pemesanan')

@section('content')
    <section class="w-[60rem] mx-auto glass-card mt-[100px] mb-[100px] rounded-3xl p-8 animate-slide-in">
        <form action="/order-submit" method="POST">
        @csrf

        {{-- nama harga rental --}}
        @include('form-pemesanan.nama-harga-rental')

        {{-- opsi rental --}}
        @include('form-pemesanan.opsi-rental')

        {{-- tanggal pesan --}}
        @include('form-pemesanan.tanggal-pesan')

        {{-- lokasi --}}
        @include('form-pemesanan.lokasi')

        {{-- buton booking --}}
        @include('form-pemesanan.buton-booking')

    </form>


    </section>

   <script>
    function selectOption(element) {
      // Remove selected class from all option cards in the same group
      const siblings = element.parentElement.children;
      for (let sibling of siblings) {
        sibling.classList.remove('ring-4', 'ring-gray-800');
      }
      
      // Add selected class to clicked element
      element.classList.add('ring-4', 'ring-gray-800');
      
      // Check the radio button
      const radio = element.querySelector('input[type="radio"]');
      if (radio) {
        radio.checked = true;
      }
    }

    function selectLocation(element) {
      // Remove selected class from all location cards
      const siblings = element.parentElement.children;
      for (let sibling of siblings) {
        sibling.classList.remove('ring-4', 'ring-gray-800');
      }
      
      // Add selected class to clicked element
      element.classList.add('ring-4', 'ring-gray-800');
      
      // Check the radio button
      const radio = element.querySelector('input[type="radio"]');
      if (radio) {
        radio.checked = true;
      }

      // Check if 'lokasi lainnya' is selected
      const isCustom = element.querySelector('input[type="radio"]').value === 'lainnya';
      const customInput = document.getElementById('custom-location-input');
      if (isCustom) {
        customInput.classList.remove('hidden');
        customInput.classList.add('animate-fade-in');
      } else {
        customInput.classList.add('hidden');
      }
    }

    // Add smooth entrance animation
    document.addEventListener('DOMContentLoaded', function() {
      const main = document.querySelector('section');
      main.style.opacity = '0';
      main.style.transform = 'translateY(30px)';
      
      setTimeout(() => {
        main.style.transition = 'all 0.6s ease-out';
        main.style.opacity = '1';
        main.style.transform = 'translateY(0)';
      }, 100);
    });
  </script>

  <style>
    @keyframes fade-in {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .animate-fade-in {
      animation: fade-in 0.5s ease-out forwards;
    }
  </style>
@endsection -->

@extends('layouts.main')

@section('title', 'Create New Order')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Create New Order</h1>

            <form action="{{ route('customer.orders.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Vehicle Selection -->
                <div>
                    <label for="vehicle_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Vehicle <span class="text-red-500">*</span>
                    </label>
                    <select name="vehicle_id" id="vehicle_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('vehicle_id') border-red-500 @enderror">
                        <option value="">Choose a vehicle</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->name }} - {{ $vehicle->type }} ({{ $vehicle->license_plate }})
                            </option>
                        @endforeach
                    </select>
                    @error('vehicle_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

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
                    <a href="{{ route('customer.orders.index') }}"
                       class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-md text-center hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_booking_date');
    const endDateInput = document.getElementById('end_booking_date');

    startDateInput.addEventListener('change', function() {
        endDateInput.min = this.value;
        if (endDateInput.value && endDateInput.value < this.value) {
            endDateInput.value = this.value;
        }
    });
});
</script>
@endsection