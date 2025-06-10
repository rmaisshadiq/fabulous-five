{{-- resources/views/kendaraan/index.blade.php --}}
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
@endsection

{{-- @extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Create New Order</h2>
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('orders.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="vehicle_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Vehicle *
                    </label>
                    <select name="vehicle_id" id="vehicle_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            required>
                        <option value="">Choose a vehicle</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->name }} - {{ $vehicle->type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_booking_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Start Date *
                        </label>
                        <input type="date" name="start_booking_date" id="start_booking_date" 
                               value="{{ old('start_booking_date') }}"
                               min="{{ date('Y-m-d') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                               required>
                    </div>

                    <div>
                        <label for="end_booking_date" class="block text-sm font-medium text-gray-700 mb-2">
                            End Date *
                        </label>
                        <input type="date" name="end_booking_date" id="end_booking_date" 
                               value="{{ old('end_booking_date') }}"
                               min="{{ date('Y-m-d') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                               required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_booking_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Start Time *
                        </label>
                        <input type="time" name="start_booking_time" id="start_booking_time" 
                               value="{{ old('start_booking_time') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                               required>
                    </div>

                    <div>
                        <label for="end_booking_time" class="block text-sm font-medium text-gray-700 mb-2">
                            End Time *
                        </label>
                        <input type="time" name="end_booking_time" id="end_booking_time" 
                               value="{{ old('end_booking_time') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                               required>
                    </div>
                </div>

                <div>
                    <label for="drop_address" class="block text-sm font-medium text-gray-700 mb-2">
                        Drop Address *
                    </label>
                    <textarea name="drop_address" id="drop_address" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                              placeholder="Enter the complete drop address..." 
                              required>{{ old('drop_address') }}</textarea>
                </div>

                <div class="flex justify-between items-center pt-4">
                    <a href="{{ route('orders.index') }}" 
                       class="px-4 py-2 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300 transition duration-200">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                        Create Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Auto-update end date when start date changes
    document.getElementById('start_booking_date').addEventListener('change', function() {
        const startDate = this.value;
        const endDateInput = document.getElementById('end_booking_date');
        
        if (startDate) {
            endDateInput.min = startDate;
            if (endDateInput.value && endDateInput.value < startDate) {
                endDateInput.value = startDate;
            }
        }
    });
</script>
@endsection --}}