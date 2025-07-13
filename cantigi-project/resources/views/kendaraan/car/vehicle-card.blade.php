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

        <button
            class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-5 py-3 rounded-xl font-semibold shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center gap-2 booking-btn"
            data-vehicle-id="{{ $vehicle->id }}" data-vehicle-name="{{ $vehicle->brand }} {{ $vehicle->model }}"
            data-vehicle-image="{{ $vehicle->vehicle_image ? asset('storage/' . $vehicle->vehicle_image) : '/api/placeholder/300x200' }}"
            data-vehicle-price="{{ $vehicle->price_per_day }}"
            data-booking-url="{{ route('orders.store') }}"
            data-existing-bookings="{{ $vehicle->order && $vehicle->order->count() > 0 ? $vehicle->order->where('status', 'in_progress')->map(function ($order) {
    return ['start_date' => $order->start_booking_date, 'end_date' => $order->end_booking_date]; })->values()->toJson() : '[]' }}">
            <i class="fa fa-calendar"></i>
            Pesan Sekarang
        </button>
    </div>
</div>

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

            <!-- Time Selection -->
            <div class="mb-6">
                <h5 class="text-lg font-semibold text-gray-800 mb-3">Pilih Waktu Pemesanan</h5>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Mulai</label>
                        <select id="startTime"
                            class="w-full p-3 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Pilih waktu mulai</option>
                            <!-- Time options will be populated by JavaScript -->
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Selesai</label>
                        <select id="endTime"
                            class="w-full p-3 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Pilih waktu selesai</option>
                            <!-- Time options will be populated by JavaScript -->
                        </select>
                    </div>
                </div>

                <!-- Time Notes -->
                <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-start">
                        <i class="fa fa-info-circle text-blue-500 mr-2 mt-1"></i>
                        <div class="text-sm text-blue-700">
                            <p class="font-semibold mb-1">Catatan Waktu:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Jam operasional: 08:00 - 16:00</li>
                                <li>Minimal booking 2 jam</li>
                                <li>Untuk booking multi-hari, waktu mulai berlaku di hari pertama dan waktu selesai di
                                    hari terakhir</li>
                            </ul>
                        </div>
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
                    <div class="flex justify-between items-center border-t pt-2">
                        <span class="text-gray-700">Total Harga:</span>
                        <span id="totalPrice" class="font-bold text-green-600 text-lg">Rp0</span>
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

<!-- Auth Modal -->
<div id="authModal"
    class="fixed inset-0 hidden z-50 flex items-center justify-center p-4 transition-all duration-300 opacity-0"
    style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);">
    <div id="authModalContent"
        class="bg-white rounded-2xl max-w-md w-full shadow-2xl transform scale-95 transition-all duration-300 p-8 text-center"
        style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3);">

        <div class="space-y-4">
            <div class="text-yellow-500 text-5xl">
                <i class="fa fa-warning"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">Login Diperlukan</h3>
            <p class="text-gray-600">
                Kamu harus login terlebih dahulu sebelum memesan!
            </p>
        </div>

        <div class="flex gap-4 mt-8">
            <button onclick="closeAuthModal()"
                class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-3 rounded-xl font-semibold transition-colors">
                Batal
            </button>
            <button onclick="window.location.href='{{ route('login') }}'"
                class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-3 rounded-xl font-semibold transition-all">
                Oke, Login
            </button>
        </div>
    </div>
</div>

<!-- Verification Modal -->
<div id="verificationModal"
    class="fixed inset-0 hidden z-50 flex items-center justify-center p-4 transition-all duration-300 opacity-0"
    style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);">
    <div id="verificationModalContent"
        class="bg-white rounded-2xl max-w-md w-full shadow-2xl transform scale-95 transition-all duration-300 p-8 text-center"
        style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3);">

        <div class="space-y-4">
            <div class="text-blue-500 text-5xl">
                <i class="fa fa-envelope"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">Verifikasi Email Diperlukan</h3>
            <p class="text-gray-600">
                Akun Anda harus diverifikasi terlebih dahulu sebelum dapat melakukan pemesanan.
            </p>
        </div>

        <div class="flex gap-4 mt-8">
            <button onclick="closeVerificationModal()"
                class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-3 rounded-xl font-semibold transition-colors">
                Batal
            </button>
            <button onclick="window.location.href='{{ route('profile.edit') }}'"
                class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-3 rounded-xl font-semibold transition-all">
                Verifikasi Sekarang
            </button>
        </div>
    </div>
</div>

<!-- Customer Identity Verification Modal -->
<div id="customerVerificationModal"
    class="fixed inset-0 hidden z-50 flex items-center justify-center p-4 transition-all duration-300 opacity-0"
    style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);">
    <div id="customerVerificationModalContent"
        class="bg-white rounded-2xl max-w-md w-full shadow-2xl transform scale-95 transition-all duration-300 p-8 text-center"
        style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3);">

        <div class="space-y-4">
            <div class="text-yellow-500 text-5xl">
                <i class="fa fa-id-card"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">Verifikasi Identitas</h3>
            <p class="text-gray-600">
                Untuk melanjutkan pemesanan, Anda harus melengkapi verifikasi identitas di halaman profil Anda.
            </p>
        </div>

        <div class="flex gap-4 mt-8">
            <button onclick="closeCustomerVerificationModal()"
                class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-3 rounded-xl font-semibold transition-colors">
                Nanti Saja
            </button>
            <button onclick="window.location.href='{{ route('profile.edit') }}'"
                class="flex-1 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white py-3 rounded-xl font-semibold transition-all">
                Lengkapi Profil
            </button>
        </div>
    </div>
</div>

<script>
    window.App = {
        isUserLoggedIn: @auth true @else false @endauth,
        isUserVerified: @auth @if(Auth::user()->hasVerifiedEmail()) true @else false @endif @else false @endauth,
        isCustomerVerified: @auth @if(Auth::user()->customer?->verification_status === 'verified') true @else false @endif @else false @endauth,
        csrfToken: '{{ csrf_token() }}'
    };
</script>

<script src="{{ asset('js/booking/booking.js') }}" defer></script>