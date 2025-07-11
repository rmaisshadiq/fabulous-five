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

<script>
    const isUserLoggedIn = @auth true @else false @endauth;

    function openAuthModal() {
        const modal = document.getElementById('authModal');
        const modalContent = document.getElementById('authModalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
        }, 10);
    }

    function closeAuthModal() {
        const modal = document.getElementById('authModal');
        const modalContent = document.getElementById('authModalContent');
        modal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }
    
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.booking-btn').forEach(button => {
            button.addEventListener('click', function () {

                // ✅ Replace the original logic with this new check
                if (isUserLoggedIn) {
                    // --- User is logged in, proceed as normal ---
                    const vehicleId = this.dataset.vehicleId;
                    const vehicleName = this.dataset.vehicleName;
                    const vehicleImage = this.dataset.vehicleImage;
                    const vehiclePrice = parseInt(this.dataset.vehiclePrice);

                    let existingBookings = [];
                    try {
                        existingBookings = JSON.parse(this.dataset.existingBookings || '[]');
                    } catch (e) {
                        console.error('Error parsing existing bookings:', e);
                        existingBookings = [];
                    }

                    openBookingModal(vehicleId, vehicleName, vehicleImage, vehiclePrice, existingBookings);
                    // --- End of original logic ---
                } else {
                    // --- User is NOT logged in, show the auth modal ---
                    openAuthModal();
                }

            });
        });
    });

    let currentVehicleId = null;
    let currentVehiclePrice = 0;
    let selectedStartDate = null;
    let selectedEndDate = null;
    let selectedStartTime = null;
    let selectedEndTime = null;
    let currentDate = new Date();
    let selectionMode = 'start';
    let bookedDates = [];

    const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    // Time options from 07:00 to 16:00
    const timeOptions = [
        '08:00', '08:30', '09:00', '09:30',
        '10:00', '10:30', '11:00', '11:30', '12:00', '12:30',
        '13:00', '13:30', '14:00', '14:30', '15:00', '15:30',
        '16:00'
    ];

    function populateTimeOptions() {
        const startTimeSelect = document.getElementById('startTime');
        const endTimeSelect = document.getElementById('endTime');

        // Clear existing options except the first one
        startTimeSelect.innerHTML = '<option value="">Pilih waktu mulai</option>';
        endTimeSelect.innerHTML = '<option value="">Pilih waktu selesai</option>';

        // Add time options
        timeOptions.forEach(time => {
            const startOption = document.createElement('option');
            startOption.value = time;
            startOption.textContent = time;
            startTimeSelect.appendChild(startOption);

            const endOption = document.createElement('option');
            endOption.value = time;
            endOption.textContent = time;
            endTimeSelect.appendChild(endOption);
        });
    }

    function validateTimeSelection() {
        const startTime = document.getElementById('startTime').value;
        const endTime = document.getElementById('endTime').value;

        if (!startTime || !endTime) {
            return true; // Skip validation if times not selected
        }

        // Convert time to minutes for comparison
        const startMinutes = timeToMinutes(startTime);
        const endMinutes = timeToMinutes(endTime);

        // Check if it's same day booking
        const isSameDay = selectedStartDate && selectedEndDate &&
            selectedStartDate.getTime() === selectedEndDate.getTime();

        if (isSameDay) {
            // For same day booking, end time must be at least 2 hours after start time
            const minEndMinutes = startMinutes + 120; // 2 hours = 120 minutes

            if (endMinutes <= startMinutes) {
                showError('Waktu selesai harus lebih dari waktu mulai');
                return false;
            }

            if (endMinutes < minEndMinutes) {
                showError('Minimal booking 2 jam');
                return false;
            }
        }

        return true;
    }

    function timeToMinutes(time) {
        const [hours, minutes] = time.split(':').map(Number);
        return hours * 60 + minutes;
    }

    function minutesToTime(minutes) {
        const hours = Math.floor(minutes / 60);
        const mins = minutes % 60;
        return `${hours.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}`;
    }

    function openBookingModal(vehicleId, vehicleName, vehicleImage, pricePerDay, existingBookings) {
        currentVehicleId = vehicleId;
        currentVehiclePrice = pricePerDay;
        bookedDates = existingBookings || [];

        // Set vehicle info
        document.getElementById('modalVehicleName').textContent = vehicleName;
        document.getElementById('modalVehicleImage').src = vehicleImage;
        document.getElementById('modalVehiclePrice').textContent = `Rp${pricePerDay.toLocaleString('id-ID')}/hari`;

        // Reset selections
        selectedStartDate = null;
        selectedEndDate = null;
        selectedStartTime = null;
        selectedEndTime = null;
        selectionMode = 'start';

        // Clear form inputs
        document.getElementById('startDate').value = '';
        document.getElementById('endDate').value = '';
        document.getElementById('startTime').value = '';
        document.getElementById('endTime').value = '';

        // Hide sections
        document.getElementById('totalSection').classList.add('hidden');
        document.getElementById('errorMessage').classList.add('hidden');

        // Populate time options
        populateTimeOptions();

        // Show modal with animation
        const modal = document.getElementById('bookingModal');
        const modalContent = document.getElementById('modalContent');

        modal.classList.remove('hidden');

        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }, 10);

        // Generate calendar
        generateCalendar();
    }

    function closeBookingModal() {
        const modal = document.getElementById('bookingModal');
        const modalContent = document.getElementById('modalContent');

        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function generateCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        document.getElementById('currentMonth').textContent = `${monthNames[month]} ${year}`;

        const calendarGrid = document.getElementById('calendarGrid');
        calendarGrid.innerHTML = '';

        const dayHeaders = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        dayHeaders.forEach(day => {
            const dayHeader = document.createElement('div');
            dayHeader.className = 'text-center text-sm font-medium text-gray-500 p-2';
            dayHeader.textContent = day;
            calendarGrid.appendChild(dayHeader);
        });

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        for (let i = 0; i < firstDay; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.className = 'p-2';
            calendarGrid.appendChild(emptyCell);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dayCell = document.createElement('div');
            const cellDate = new Date(year, month, day);

            const isPast = cellDate < today;
            const isBooked = isDateBooked(cellDate);
            const isSelected = isDateSelected(cellDate);
            const isInRange = isDateInRange(cellDate);

            dayCell.className = `p-2 text-center cursor-pointer rounded-lg transition-all`;

            if (isBooked) {
                dayCell.className += ' bg-red-500 text-white cursor-not-allowed';
                dayCell.title = 'Tanggal sudah dibooking';
            } else if (isPast) {
                dayCell.className += ' text-gray-300 cursor-not-allowed';
            } else if (isSelected) {
                dayCell.className += ' bg-blue-500 text-white';
            } else if (isInRange) {
                dayCell.className += ' bg-blue-200 text-blue-800';
            } else {
                dayCell.className += ' hover:bg-blue-100';
            }

            dayCell.textContent = day;

            if (!isPast && !isBooked) {
                dayCell.addEventListener('click', () => selectDate(cellDate));
            }

            calendarGrid.appendChild(dayCell);
        }
    }

    function isDateBooked(date) {
        const checkDate = new Date(date);
        checkDate.setHours(0, 0, 0, 0);

        return bookedDates.some(booking => {
            const startDate = new Date(booking.start_date);
            const endDate = new Date(booking.end_date);

            startDate.setHours(0, 0, 0, 0);
            endDate.setHours(0, 0, 0, 0);

            return checkDate >= startDate && checkDate <= endDate;
        });
    }

    function isDateSelected(date) {
        return (selectedStartDate && date.getTime() === selectedStartDate.getTime()) ||
            (selectedEndDate && date.getTime() === selectedEndDate.getTime());
    }

    function isDateInRange(date) {
        if (!selectedStartDate || !selectedEndDate) return false;
        return date > selectedStartDate && date < selectedEndDate;
    }

    function selectDate(date) {
        hideError();

        if (selectionMode === 'start') {
            selectedStartDate = date;
            selectedEndDate = null;
            selectionMode = 'end';
            document.getElementById('startDate').value = formatDate(date);
            document.getElementById('endDate').value = '';
            document.getElementById('totalSection').classList.add('hidden');

            // Clear time selections when date changes
            document.getElementById('startTime').value = '';
            document.getElementById('endTime').value = '';
        } else {
            if (date <= selectedStartDate) {
                selectedEndDate = selectedStartDate;
                selectedStartDate = date;
            } else {
                selectedEndDate = date;
            }

            if (checkDateOverlap(selectedStartDate, selectedEndDate)) {
                showError('Tanggal yang dipilih tidak tersedia karena bertabrakan dengan booking yang sudah ada. Silakan pilih tanggal lain.');
                selectedStartDate = null;
                selectedEndDate = null;
                selectionMode = 'start';
                document.getElementById('startDate').value = '';
                document.getElementById('endDate').value = '';
            } else {
                selectionMode = 'start';
                document.getElementById('startDate').value = formatDate(selectedStartDate);
                document.getElementById('endDate').value = formatDate(selectedEndDate);
                calculateTotal();
            }
        }

        generateCalendar();
    }

    function checkDateOverlap(startDate, endDate) {
        return bookedDates.some(booking => {
            const bookedStart = new Date(booking.start_date);
            const bookedEnd = new Date(booking.end_date);

            return (startDate <= bookedEnd && endDate >= bookedStart);
        });
    }

    function formatDate(date) {
        const day = date.getDate().toString().padStart(2, '0');
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
    }

    function calculateTotal() {
        if (selectedStartDate && selectedEndDate) {
            const timeDiff = selectedEndDate.getTime() - selectedStartDate.getTime();
            const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
            const totalPrice = dayDiff * currentVehiclePrice;

            document.getElementById('totalDays').textContent = `${dayDiff} hari`;
            document.getElementById('totalPrice').textContent = `Rp${totalPrice.toLocaleString('id-ID')}`;

            // Update time display
            updateTimeDisplay();

            document.getElementById('totalSection').classList.remove('hidden');
        }
    }

    function updateTimeDisplay() {
        const startTime = document.getElementById('startTime').value;
        const endTime = document.getElementById('endTime').value;
        const timeDisplay = document.getElementById('totalTime');

        if (startTime && endTime) {
            const isSameDay = selectedStartDate && selectedEndDate &&
                selectedStartDate.getTime() === selectedEndDate.getTime();

            if (isSameDay) {
                timeDisplay.textContent = `${startTime} - ${endTime}`;
            } else {
                timeDisplay.textContent = `${startTime} (mulai) - ${endTime} (selesai)`;
            }
        } else {
            timeDisplay.textContent = '-';
        }
    }

    function showError(message) {
        document.getElementById('errorText').textContent = message;
        document.getElementById('errorMessage').classList.remove('hidden');
        document.getElementById('totalSection').classList.add('hidden');
    }

    function hideError() {
        document.getElementById('errorMessage').classList.add('hidden');
    }

    function submitBooking() {
        if (!selectedStartDate || !selectedEndDate) {
            showError('Silakan pilih tanggal mulai dan selesai');
            return;
        }

        const startTime = document.getElementById('startTime').value;
        const endTime = document.getElementById('endTime').value;

        if (!startTime || !endTime) {
            showError('Silakan pilih waktu mulai dan selesai');
            return;
        }

        if (!validateTimeSelection()) {
            return;
        }

        // --- VALIDATION ADDED HERE ---

        // 1. Prevent booking on the same day as today
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Reset time for accurate date comparison

        if (selectedStartDate.getTime() === today.getTime()) {
            showError('Pemesanan tidak bisa dimulai pada hari ini. Silakan pilih tanggal lain.');
            return;
        }

        // 2. Prevent same-day booking (minimum 1 day rental)
        if (selectedEndDate.getTime() === selectedStartDate.getTime()) {
            showError('Minimal durasi pemesanan adalah 1 hari. Tanggal selesai tidak boleh sama dengan tanggal mulai.');
            return;
        }

        // --- END OF VALIDATION ---

        // Show loading state
        const submitButton = document.querySelector('button[onclick="submitBooking()"]');
        const originalText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.textContent = 'Memproses...';

        const formData = new FormData();
        formData.append('vehicle_id', currentVehicleId);
        formData.append('start_booking_date', selectedStartDate.toISOString().split('T')[0]);
        formData.append('end_booking_date', selectedEndDate.toISOString().split('T')[0]);
        formData.append('start_booking_time', startTime);
        formData.append('end_booking_time', endTime);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        // Option 1: Using the exact route URL
        fetch('/orders', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest', // Important for Laravel to detect AJAX
                'Accept': 'application/json', // Ensure JSON response
            }
        })
            .then(response => {
                // Check if response is ok
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.redirect_url) {
                    window.location.href = data.redirect_url;
                } else {
                    showError(data.message || 'An unknown error occurred.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses booking: ' + error.message);
            })
            .finally(() => {
                // Reset button state
                submitButton.disabled = false;
                submitButton.textContent = originalText;
            });
    }

    // Event listeners for time selection
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('startTime').addEventListener('change', function () {
            selectedStartTime = this.value;
            updateTimeDisplay();
            if (!validateTimeSelection()) {
                this.value = '';
                selectedStartTime = null;
            }
        });

        document.getElementById('endTime').addEventListener('change', function () {
            selectedEndTime = this.value;
            updateTimeDisplay();
            if (!validateTimeSelection()) {
                this.value = '';
                selectedEndTime = null;
            }
        });
    });

    // Navigation buttons
    document.getElementById('prevMonth').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        generateCalendar();
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        generateCalendar();
    });

    // Close modal when clicking outside
    document.getElementById('bookingModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('bookingModal')) {
            closeBookingModal();
        }
    });

    // Keyboard support
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !document.getElementById('bookingModal').classList.contains('hidden')) {
            closeBookingModal();
        }
    });
</script>