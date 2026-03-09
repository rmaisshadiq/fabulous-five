{{-- resources/views/kendaraan/index.blade.php --}}
@extends('layouts.main')

@section('title', 'Kendaraan')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Pilihan Kendaraan Kami</h1>
        
        <div class="max-w-[1200px] mx-auto px-4 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100 flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="w-full md:w-1/3 relative">
                    <input type="text" id="vehicleSearchInput" 
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all font-medium text-gray-700" 
                        placeholder="Cari brand atau model mobil...">
                    <div class="absolute left-3 top-3.5 text-gray-400">
                        <i class="fa fa-search"></i>
                    </div>
                </div>

                <div class="w-full md:w-2/3 flex flex-wrap gap-2 justify-end" id="filterButtonsContainer">
                    <button class="filter-btn active bg-green-500 text-white px-5 py-2.5 rounded-xl font-semibold shadow-sm transition-all" data-filter="all">Semua</button>
                    <button class="filter-btn bg-gray-100 text-gray-600 hover:bg-gray-200 px-5 py-2.5 rounded-xl font-semibold shadow-sm transition-all" data-filter="reguler">Kendaraan Reguler</button>
                    <button class="filter-btn bg-gray-100 text-gray-600 hover:bg-orange-100 hover:text-orange-600 px-5 py-2.5 rounded-xl font-semibold shadow-sm transition-all" data-filter="best_deal">Paket Best Deal 🔥</button>
                    <button class="filter-btn bg-gray-100 text-gray-600 hover:bg-blue-100 hover:text-blue-600 px-5 py-2.5 rounded-xl font-semibold shadow-sm transition-all" data-filter="bus">Bus Pariwisata 🚌</button>
                </div>
            </div>
        </div>

        {{-- GRID KENDARAAN (FIX NEMBUS) --}}
        <div class="max-w-[1200px] mx-auto px-4">
            <div id="vehicleGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 py-4">
                @forelse($vehicles as $vehicle)
                    @include('kendaraan.car.vehicle-card', ['vehicle' => $vehicle])
                @empty
                    <div class="col-span-full text-center py-10 text-gray-500">Tidak ada kendaraan tersedia.</div>
                @endforelse
            </div>
            
            <div id="noResultMsg" class="hidden text-center py-10 text-gray-500 text-lg font-semibold w-full">
                Kendaraan tidak ditemukan.
            </div>
        </div>

    </div>

    {{-- Data Bus Routes as Global JS Variable (Hidden JSON) --}}
    <script>
        window.busRoutesData = @json($busRoutes ?? []);
    </script>

    {{-- MODAL BOOKING DI PINDAH KE SINI (CUMA ADA 1 DI HALAMAN INI) --}}
    {{-- Include styles & JS --}}
    @include('kendaraan.car.styles')

    <!-- Booking Modal -->
<div id="bookingModal"
    class="fixed inset-0 hidden z-50 flex items-center justify-center p-4 transition-all duration-300 opacity-0"
    style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);">
    <div id="modalContent"
        class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl transform scale-95 transition-all duration-300"
        style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3);">
        <div class="p-6">
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Booking Kendaraan</h3>
                <button onclick="closeBookingModal()" class="text-gray-500 hover:text-gray-700 text-2xl">
                    <i class="fa fa-times"></i>
                </button>
            </div>

            <!-- Vehicle Info -->
            <div class="flex items-center mb-6 p-4 bg-gray-50 rounded-xl">
                <img id="modalVehicleImage" src="" alt="" class="w-20 h-16 object-cover rounded-lg mr-4">
                <div>
                    <h4 id="modalVehicleName" class="text-lg font-semibold text-gray-800"></h4>
                    <p id="modalVehiclePrice" class="text-green-600 font-bold"></p>
                </div>
            </div>

            <!-- Error Message -->
            <div id="errorMessage" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl hidden">
                <div class="flex items-center">
                    <i class="fa fa-exclamation-triangle mr-2"></i>
                    <span id="errorText"></span>
                </div>
            </div>

            <!-- Date Selection -->
            <div class="mb-6">
                <h5 class="text-lg font-semibold text-gray-800 mb-3">Pilih Tanggal Pemesanan</h5>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="text" id="startDate"
                            class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50" readonly
                            placeholder="Pilih tanggal mulai">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <input type="text" id="endDate" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50"
                            readonly placeholder="Pilih tanggal selesai">
                    </div>
                </div>

                <!-- Calendar -->
                <div id="calendar" class="bg-white border border-gray-200 rounded-xl p-4">
                    <div class="flex justify-between items-center mb-4">
                        <button id="prevMonth" class="p-2 hover:bg-gray-100 rounded-lg">
                            <i class="fa fa-chevron-left text-gray-600"></i>
                        </button>
                        <h6 id="currentMonth" class="text-lg font-semibold text-gray-800"></h6>
                        <button id="nextMonth" class="p-2 hover:bg-gray-100 rounded-lg">
                            <i class="fa fa-chevron-right text-gray-600"></i>
                        </button>
                    </div>
                    <div id="calendarGrid" class="grid grid-cols-7 gap-1"></div>
                </div>
            </div>

            <!-- Container Reguler -->
            <div id="regularServiceContainer">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Layanan</label>
                    <select id="serviceType" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all cursor-pointer">
                        <option value="lepas_kunci">Lepas Kunci</option>
                        <option value="sewa_driver">Sewa + Driver</option>
                        <option value="dropping">Dropping</option>
                    </select>

                    <div id="driverAreaSection" class="hidden mt-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Area Layanan (Dengan Driver)</label>
                        <select id="driverArea" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all cursor-pointer">
                            <option value="150000">Dalam Kota (+ Rp 150.000/hari)</option>
                            <option value="165000">Luar Kota (+ Rp 165.000/hari)</option>
                            <option value="200000">Luar Provinsi (+ Rp 200.000/hari)</option>
                        </select>
                    </div>

                    <div id="droppingRouteSection" class="hidden mt-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rute Dropping</label>
                        <select id="droppingRoute" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all cursor-pointer">
                            <option value="100000">Antar Bandara (+ Rp 100.000)</option>
                            <option value="100000">Jemput Bandara (+ Rp 100.000)</option>
                            <option value="75000">Transfer Dalam Kota (+ Rp 75.000)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Container Best Deal -->
            <div id="bestDealContainer" class="hidden mb-6">
                <div class="bg-gradient-to-r from-orange-100 to-red-100 rounded-xl p-4 border border-orange-200 mb-4">
                    <p class="text-orange-800 font-semibold"><i class="fa fa-fire mr-1"></i> Kendaraan ini memiliki Paket Best Deal!</p>
                    <p class="text-sm text-orange-700 mt-1">Pilih salah satu paket All-In di bawah ini untuk penawaran terbaik (Sudah termasuk driver).</p>
                </div>
                
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan Paket All-In</label>
                <select id="bestDealPackage" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all cursor-pointer">
                    <option value="drop_bandara" id="opt_drop_bandara">-</option>
                    <option value="city_tour" id="opt_city_tour">-</option>
                    <option value="full_day" id="opt_full_day">-</option>
                    <option value="luar_kota" id="opt_luar_kota">-</option>
                </select>
            </div>

            <!-- Container Bus Pariwisata -->
            <div id="busServiceContainer" class="hidden mb-6">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-100 rounded-xl p-4 border border-blue-200 mb-4">
                    <p class="text-blue-800 font-semibold"><i class="fa fa-info-circle mr-1"></i> Tarif Bus Pariwisata</p>
                    <p class="text-sm text-blue-700 mt-1" id="busMinHariInfo">Sewa bus akan mengikuti ketentuan minimum hari berdasarkan rute yang dipilih.</p>
                </div>
                
                <div class="space-y-4">
                    <!-- Dropdown 1: Kategori Rute Bus -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Rute</label>
                        <select id="kategoriRute" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all cursor-pointer">
                            <option value="" disabled selected>Pilih Kategori Perjalanan...</option>
                            <option value="transfer">Transfer BIM & Dalam Kota (1x Jalan)</option>
                            <option value="dalam_propinsi">Dalam Propinsi Sumatera Barat</option>
                            <option value="overland">Overland (Luar Propinsi)</option>
                        </select>
                    </div>

                    <!-- Dropdown 2: Cascading Pilihan Rute Bus -->
                    <div id="pilihanRuteContainer" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan Rute</label>
                        <select id="pilihanRute" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all cursor-pointer">
                            <option value="" disabled selected>Pilih Rute spesifik...</option>
                            <!-- Diisi logic Javascript -->
                        </select>
                    </div>
                </div>
            </div>

            <!-- Total Calculation -->
            <div id="totalSection" class="mb-6 p-4 bg-green-50 rounded-xl hidden">
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700">Total Hari:</span>
                        <span id="totalDays" class="font-semibold">0 hari</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700">Waktu:</span>
                        <span id="totalTime" class="font-semibold">-</span>
                    </div>
                    <hr class="my-2 border-gray-300">
    
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-800">Total Harga:</span>
                        <span id="totalPrice" class="font-bold text-xl text-blue-600">-</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <button onclick="closeBookingModal()"
                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-3 rounded-xl font-semibold transition-colors">
                    Batal
                </button>
                <button onclick="submitBooking()"
                    class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-3 rounded-xl font-semibold transition-all">
                    Konfirmasi Booking
                </button>
            </div>
        </div>
    </div>
</div>
    <script src="{{ asset('js/booking/booking.js') }}" defer></script>

    <script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('vehicleSearchInput');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.vehicle-card');
    const noResultMsg = document.getElementById('noResultMsg');

    let currentFilter = 'all';
    let searchQuery = '';

    // Fungsi Utama buat nge-filter Card
    function filterCards() {
        let visibleCount = 0;

        cards.forEach(card => {
            // Ambil data dari atribut HTML card
            const name = card.dataset.name || '';
            const isBestDeal = card.dataset.isBestDeal === 'true';
            const carType = card.dataset.carType || '';
            
            // Definisikan mana yang termasuk "Bus"
            const isBus = ['hiace_elf', 'medium', 'of', 'oh'].includes(carType);

            // Cek apakah nama cocok dengan inputan search
            const matchesSearch = name.includes(searchQuery);

            // Cek logic tombol filter
            let matchesFilter = false;
            if (currentFilter === 'all') {
                matchesFilter = true;
            } else if (currentFilter === 'best_deal') {
                matchesFilter = isBestDeal;
            } else if (currentFilter === 'bus') {
                matchesFilter = isBus;
            } else if (currentFilter === 'reguler') {
                matchesFilter = !isBus && !isBestDeal;
            }

            // Tampilkan atau Sembunyikan Card
            if (matchesSearch && matchesFilter) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Munculin teks "Kendaraan tidak ditemukan" kalau ga ada hasil
        if (visibleCount === 0) {
            noResultMsg.classList.remove('hidden');
        } else {
            noResultMsg.classList.add('hidden');
        }
    }

    // Event Listener buat Search Bar (Real-time ngetik)
    if(searchInput) {
        searchInput.addEventListener('input', (e) => {
            searchQuery = e.target.value.toLowerCase();
            filterCards();
        });
    }

    // Event Listener buat Tombol Filter
    filterBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            // Reset styling semua tombol jadi abu-abu
            filterBtns.forEach(b => {
                b.classList.remove('bg-green-500', 'text-white');
                b.classList.add('bg-gray-100', 'text-gray-600');
            });
            
            // Bikin tombol yang diklik jadi ijo
            const target = e.currentTarget;
            target.classList.remove('bg-gray-100', 'text-gray-600');
            target.classList.add('bg-green-500', 'text-white');

            // Set filter aktif dan jalankan ulang
            currentFilter = target.dataset.filter;
            filterCards();
        });
    });
});
</script>
@endsection