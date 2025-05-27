{{-- resources/views/kendaraan/car/vehicle-card.blade.php --}}
{{-- Template untuk single vehicle card, akan dipanggil di dalam loop --}}

<div
    class="vehicle-card bg-white rounded-3xl p-6 shadow-2xl border border-gray-100 hover:shadow-3xl transition-all duration-300 transform hover:-translate-y-1 space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div class="px-4 py-2 rounded-full shadow text-white text-sm font-semibold
            @if($vehicle->status == 'active')
                bg-gradient-to-r from-green-400 to-green-500
            @elseif($vehicle->status == 'maintenance')
                bg-gradient-to-r from-red-400 to-red-500
            @else
                bg-gradient-to-r from-yellow-400 to-yellow-500
            @endif
        ">
            @if($vehicle->status == 'active')
                <i class="fa fa-check-circle mr-2"></i> Active
            @elseif($vehicle->status == 'maintenance')
                <i class="fa fa-times-circle mr-2"></i> Maintenance
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
        <img src="{{ $vehicle->vehicle_image ? asset('storage/' . $vehicle->vehicle_image) : '/api/placeholder/300x200' }}"
            alt="{{ $vehicle->brand }} {{ $vehicle->model }}"
            class="w-[300px] h-[200px] object-cover rounded-xl border border-white {{ $vehicle->status == 'tidak_tersedia' ? 'opacity-60' : '' }}"
            loading="lazy" />
    </div>

    <!-- Harga dan Tombol -->
    <div class="flex justify-between items-center">
        <div class="bg-gradient-to-r from-green-50 to-green-100 border-green-200 rounded-xl px-4 py-3 border">
            <span
                class="text-xl font-bold text-green-700">Rp{{ number_format($vehicle->price_per_day, 0, ',', '.') }}</span>
            <span class="text-sm text-gray-500">/hari</span>
        </div>

        <a href="/form-pemesanan/main-page/{{ $vehicle->id }}"
            class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-5 py-3 rounded-xl font-semibold shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center gap-2">
            <i class="fa fa-calendar"></i>
            Pesan Sekarang
        </a>

    </div>
</div>