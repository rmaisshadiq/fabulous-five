@php
  $vehicleChunks = $vehicles->chunk(6); // 6 kendaraan per slide
@endphp

<div class="slides-container relative max-w-[1200px] mx-auto px-4">

  @foreach ($vehicleChunks as $index => $vehicleChunk)
    <div class="slide {{ $index == 0 ? 'block' : 'hidden' }}">
      <section class="grid grid-cols-1 md:grid-cols-2 gap-6 py-10">
        @foreach ($vehicleChunk as $vehicle)
          <div class="bg-white rounded-3xl p-6 shadow-2xl border border-gray-100 hover:shadow-3xl transition-all duration-300 transform hover:-translate-y-1 space-y-6">

            <!-- Header -->
            <div class="flex justify-between items-start">
              <div
                class="px-4 py-2 rounded-full shadow text-white text-sm font-semibold
                  @if($vehicle->status == 'active')
                    bg-gradient-to-r from-green-400 to-green-500
                  @elseif($vehicle->status == 'maintenance')
                    bg-gradient-to-r from-red-400 to-red-500
                  @else
                    bg-gradient-to-r from-yellow-400 to-yellow-500
                  @endif
                ">
                @if($vehicle->status == 'active')
                  <i class="fa fa-check-circle mr-2"></i> active
                @elseif($vehicle->status == 'maintenance')
                  <i class="fa fa-times-circle mr-2"></i> maintenance
                @else
                  <i class="fa fa-clock-o mr-2"></i> {{ ucfirst(str_replace('_', ' ', $vehicle->status)) }}
                @endif
              </div>

              <div class="text-right flex-1 ml-4">
                <h2 class="text-xl font-bold text-gray-800">{{ $vehicle->brand }} {{ $vehicle->model }}</h2>
                <p class="text-sm text-gray-500">{{ $vehicle->car_type }}</p>
                @if($vehicle->license_plate)
                  <p class="text-xs text-gray-400">{{ $vehicle->license_plate }}</p>
                @endif
              </div>
            </div>

            <!-- Gambar -->
            <div class="flex justify-center">
              <img
                src="{{ $vehicle->vehicle_image ? asset('storage/' . $vehicle->vehicle_image) : '/api/placeholder/300x200' }}"
                alt="{{ $vehicle->brand }} {{ $vehicle->model }}"
                class="w-[300px] h-[200px] object-cover rounded-xl border border-white {{ $vehicle->status == 'tidak_tersedia' ? 'opacity-60' : '' }}" />
            </div>

            <!-- Harga dan Tombol -->
            <div class="flex justify-between items-center">
              <div class="bg-gradient-to-r from-green-50 to-green-100 border-green-200 rounded-xl px-4 py-3 border">
                <span class="text-xl font-bold text-green-700">Rp{{ number_format($vehicle->price_per_day, 0, ',', '.') }}</span>
                <span class="text-sm text-gray-500">/hari</span>
              </div>

              <button
                class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-5 py-3 rounded-xl font-semibold shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center gap-2"
                onclick="pesanKendaraan({{ $vehicle->id }})">
                <i class="fa fa-calendar"></i>
                Pesan Sekarang
              </button>
            </div>

          </div>
        @endforeach
      </section>
    </div>
  @endforeach

</div>
