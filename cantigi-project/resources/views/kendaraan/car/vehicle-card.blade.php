{{-- resources/views/kendaraan/car/vehicle-card.blade.php --}}
{{-- Template untuk single vehicle card, akan dipanggil di dalam loop --}}

<div class="vehicle-card bg-white rounded-3xl p-6 shadow-2xl border border-gray-100 hover:shadow-3xl transition-all duration-300 transform hover:-translate-y-1 space-y-6" data-car-type="{{ $vehicle->car_type }}" data-is-best-deal="{{ $vehicle->is_best_deal ? 'true' : 'false' }}" data-name="{{ strtolower($vehicle->brand . ' ' . $vehicle->model) }}">
    <div class="flex justify-between items-start">
        <div class="flex flex-col gap-2">
            <div class="px-4 py-2 rounded-full shadow text-white text-sm font-semibold inline-block text-center
                @if($vehicle->status == 'active') bg-gradient-to-r from-green-400 to-green-500
                @elseif($vehicle->status == 'maintenance') bg-gradient-to-r from-red-400 to-red-500
                @else bg-gradient-to-r from-yellow-400 to-yellow-500 @endif">
                @if($vehicle->status == 'active') <i class="fa fa-check-circle mr-2"></i> Active
                @elseif($vehicle->status == 'maintenance') <i class="fa fa-times-circle mr-2"></i> Maintenance
                @else <i class="fa fa-clock-o mr-2"></i> {{ ucfirst(str_replace('_', ' ', $vehicle->status)) }} @endif
            </div>

            @if($vehicle->is_best_deal)
            <div class="px-4 py-2 rounded-full shadow bg-gradient-to-r from-orange-500 to-red-500 text-white text-sm font-bold flex items-center justify-center shadow-lg animate-pulse">
                <i class="fa fa-fire mr-1"></i> BEST OFFER
            </div>
            @endif
        </div>

        <div class="text-right flex-1 ml-4">
            <h2 class="text-xl font-bold text-gray-800">{{ $vehicle->brand }} {{ $vehicle->model }}</h2>
            <p class="text-sm text-gray-500">{{ str_replace('_', ' ', strtoupper($vehicle->car_type)) }}</p>
        </div>
    </div>

    <div class="flex justify-center w-full">
        <img src="{{ $vehicle->vehicle_image ? asset('storage/' . $vehicle->vehicle_image) : 'https://placehold.co/600x400/eeeeee/999999?text=No+Image+Available' }}"
            alt="{{ $vehicle->brand }} {{ $vehicle->model }}"
            class="w-full h-[200px] object-cover rounded-xl border border-white {{ $vehicle->status == 'tidak_tersedia' ? 'opacity-60' : '' }}"
            loading="lazy" />
    </div>

    <div class="flex justify-between items-center">
        <div class="bg-gradient-to-r from-green-50 to-green-100 border-green-200 rounded-xl px-4 py-3 border">
            @if(in_array($vehicle->car_type, ['hiace_elf', 'medium', 'of', 'oh']))
                <span class="text-md font-bold text-green-700">Tarif Sesuai Rute</span>
            @else
                <span class="text-xl font-bold text-green-700">Rp{{ number_format($vehicle->price_per_day, 0, ',', '.') }}</span>
                <span class="text-sm text-gray-500">/hari</span>
            @endif
        </div>

        <button
            class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-5 py-3 rounded-xl font-semibold shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center gap-2 booking-btn"
            data-vehicle-id="{{ $vehicle->id }}" 
            data-vehicle-name="{{ $vehicle->brand }} {{ $vehicle->model }}"
            data-vehicle-image="{{ $vehicle->vehicle_image ? asset('storage/' . $vehicle->vehicle_image) : 'https://placehold.co/600x400/eeeeee/999999?text=No+Image+Available' }}"
            data-vehicle-price="{{ $vehicle->price_per_day }}"
            data-is-best-deal="{{ $vehicle->is_best_deal ? 'true' : 'false' }}"
            data-car-type="{{ $vehicle->car_type }}"
            data-harga-drop="{{ $vehicle->harga_drop_bandara ?? 0 }}"
            data-harga-city="{{ $vehicle->harga_city_tour ?? 0 }}"
            data-harga-full="{{ $vehicle->harga_full_day ?? 0 }}"
            data-harga-luar-kota="{{ $vehicle->harga_luar_kota ?? 0 }}">
            <i class="fa fa-calendar"></i>
            Pesan
        </button>
    </div>
</div>