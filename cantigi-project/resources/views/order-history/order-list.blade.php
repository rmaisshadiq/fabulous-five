<!-- Orders List -->
<div class="space-y-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Daftar Pesanan</h2>
    @foreach($orders as $order)
        <div class="bg-gradient-to-r from-white to-gray-50 border border-gray-200 rounded-xl p-6 hover:shadow-lg hover:border-blue-300 transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex flex-col lg:flex-row lg:items-start justify-between">
                <!-- Order Info -->
                <div class="flex-1">
                    <!-- Order Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="bg-blue-100 rounded-full p-2 mr-3">
                                <i class="fas fa-receipt text-blue-600"></i>
                            </div>
                            <div>
                                <span class="text-xl font-bold text-gray-800">Order #{{ $order->id }}</span>
                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="px-4 py-2 rounded-full text-sm font-semibold
                                @if($order->status == 'pending') bg-gradient-to-r from-yellow-100 to-yellow-50 text-yellow-800 border border-yellow-200
                                @elseif($order->status == 'confirmed') bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800 border border-blue-200
                                @elseif($order->status == 'in_progress') bg-gradient-to-r from-purple-100 to-purple-50 text-purple-800 border border-purple-200
                                @elseif($order->status == 'completed') bg-gradient-to-r from-green-100 to-green-50 text-green-800 border border-green-200
                                @elseif($order->status == 'cancelled') bg-gradient-to-r from-red-100 to-red-50 text-red-800 border border-red-200
                                @endif">
                                <i class="fas fa-circle text-xs mr-1
                                    @if($order->status == 'pending') text-yellow-500
                                    @elseif($order->status == 'confirmed') text-blue-500
                                    @elseif($order->status == 'in_progress') text-purple-500
                                    @elseif($order->status == 'completed') text-green-500
                                    @elseif($order->status == 'cancelled') text-red-500
                                    @endif"></i>
                                {{ ucfirst($order->status) }}
                            </span>
                            <!-- Dropdown Toggle Button -->
                            <button onclick="toggleOrderDetails({{ $order->id }})" class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-full transition-colors duration-200">
                                <i class="fas fa-chevron-down text-gray-600 transition-transform duration-300" id="arrow-{{ $order->id }}"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Quick Summary (Always Visible) -->
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                            <span>{{ \Carbon\Carbon::parse($order->start_booking_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($order->end_booking_date)->format('d M Y') }}</span>
                        </div>
                        @if($order->vehicle)
                            <div class="flex items-center">
                                <i class="fa fa-car text-purple-500 mr-2"></i>
                                <span>{{ $order->vehicle->brand . ' ' . $order->vehicle->model ?? 'tidak ditemukan' }}</span>
                            </div>
                        @endif
                        @if($order->driver)
                            <div class="flex items-center">
                                <i class="fas fa-user text-orange-500 mr-2"></i>
                                <span>{{ $order->driver->name ?? 'N/A' }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Order Details (Collapsible) -->
                    <div class="order-details hidden" id="details-{{ $order->id }}">
                        <div class="bg-white rounded-lg p-4 border border-gray-100">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <div class="bg-blue-100 rounded-full p-2 mr-3">
                                            <i class="fas fa-calendar-alt text-blue-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Tanggal Booking</p>
                                            <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="bg-green-100 rounded-full p-2 mr-3">
                                            <i class="fas fa-clock text-green-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Tanggal Rental</p>
                                            <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($order->start_booking_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($order->end_booking_date)->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    @if($order->vehicle)
                                        <div class="flex items-center">
                                            <div class="bg-purple-100 rounded-full p-2 mr-3">
                                                <i class="fa fa-car text-purple-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">Kendaraan</p>
                                                <p class="font-semibold text-gray-800">{{ $order->vehicle->model ?? 'tidak ditemukan' }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if($order->driver)
                                        <div class="flex items-center">
                                            <div class="bg-orange-100 rounded-full p-2 mr-3">
                                                <i class="fas fa-user text-orange-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">Driver</p>
                                                <p class="font-semibold text-gray-800">{{ $order->driver->name ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Rental Time Information Section -->
                            @php
                                $timeInfo = $order->getRentalTimeInfo();
                            @endphp
                            
                            @if(in_array($order->status, ['confirmed', 'in_progress', 'completed']))
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            @if($timeInfo['status'] === 'not_started')
                                                <div class="bg-yellow-100 rounded-full p-2 mr-3">
                                                    <i class="fas fa-hourglass-start text-yellow-600 text-sm"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Status Rental</p>
                                                    <p class="font-semibold text-yellow-600">{{ $timeInfo['message'] }}</p>
                                                    <p class="text-sm text-gray-600">Dimulai dalam: <span class="font-mono">{{ $timeInfo['time_until_start'] }}</span></p>
                                                </div>
                                            @elseif($timeInfo['status'] === 'active')
                                                <div class="bg-blue-100 rounded-full p-2 mr-3">
                                                    <i class="fas fa-hourglass-half text-blue-600 text-sm"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Sisa Waktu Rental</p>
                                                    <p class="font-semibold text-blue-600 text-lg font-mono" id="rental-timer">{{ $timeInfo['duration_left'] }}</p>
                                                    <p class="text-sm text-gray-600">{{ $timeInfo['message'] }}</p>
                                                </div>
                                            @elseif($timeInfo['status'] === 'ended')
                                                <div class="bg-red-100 rounded-full p-2 mr-3">
                                                    <i class="fas fa-hourglass-end text-red-600 text-sm"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Status Rental</p>
                                                    <p class="font-semibold text-red-600">{{ $timeInfo['message'] }}</p>
                                                    <p class="text-sm text-gray-600">Terlambat: <span class="font-mono">{{ $timeInfo['overdue_time'] }}</span></p>
                                                </div>
                                            @else
                                                <div class="bg-gray-100 rounded-full p-2 mr-3">
                                                    <i class="fas fa-exclamation-triangle text-gray-600 text-sm"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Status Rental</p>
                                                    <p class="font-semibold text-gray-600">{{ $timeInfo['message'] }}</p>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        @if($timeInfo['status'] === 'active')
                                            <div class="text-right">
                                                <div class="bg-blue-50 rounded-lg px-3 py-2">
                                                    <p class="text-xs text-blue-600 font-medium">RENTAL AKTIF</p>
                                                    <div class="flex items-center mt-1">
                                                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse mr-2"></div>
                                                        <span class="text-xs text-blue-700">Sedang Berlangsung</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($timeInfo['status'] === 'ended')
                                            <div class="text-right">
                                                <div class="bg-red-50 rounded-lg px-3 py-2">
                                                    <p class="text-xs text-red-600 font-medium">RENTAL BERAKHIR</p>
                                                    <div class="flex items-center mt-1">
                                                        <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                                        <span class="text-xs text-red-700">Perlu Pengembalian</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
                            @if($order->drop_address)
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <div class="flex items-start">
                                        <div class="bg-red-100 rounded-full p-2 mr-3 mt-1">
                                            <i class="fas fa-map-marker-alt text-red-600 text-sm"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-500 mb-1">Alamat</p>
                                            <p class="font-medium text-gray-800 leading-relaxed">{{ $order->drop_address }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @if($order->status == 'pending')
                                <div class="mt-4 text-right">
                                    <a href="{{ route('detail-pemesanan', $order->id) }}" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors duration-200">
                                        Lanjutkan Pemesanan
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            @elseif($order->status == 'confirmed')
                                <div class="mt-4 text-right">
                                    <a href="{{ route('detail-pemesanan', $order->id) }}" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors duration-200">
                                        Lanjutkan Pembayaran
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            @elseif($order->status == 'completed')
                                <div class="mt-4 text-right">
                                    <a href="{{ route('detail-pemesanan', $order->id) }}" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors duration-200">
                                        Lihat Pesanan
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script>
function toggleOrderDetails(orderId) {
    const detailsElement = document.getElementById(`details-${orderId}`);
    const arrowElement = document.getElementById(`arrow-${orderId}`);
    
    if (detailsElement.classList.contains('hidden')) {
        // Show details
        detailsElement.classList.remove('hidden');
        detailsElement.style.maxHeight = '0px';
        detailsElement.style.opacity = '0';
        detailsElement.style.transform = 'translateY(-10px)';
        detailsElement.style.transition = 'all 0.3s ease-in-out';
        
        // Force reflow
        detailsElement.offsetHeight;
        
        // Animate in
        detailsElement.style.maxHeight = detailsElement.scrollHeight + 'px';
        detailsElement.style.opacity = '1';
        detailsElement.style.transform = 'translateY(0)';
        
        // Rotate arrow
        arrowElement.style.transform = 'rotate(180deg)';
        
        // Clean up after animation
        setTimeout(() => {
            detailsElement.style.maxHeight = 'none';
        }, 300);
    } else {
        // Hide details
        detailsElement.style.maxHeight = detailsElement.scrollHeight + 'px';
        detailsElement.style.opacity = '1';
        detailsElement.style.transform = 'translateY(0)';
        
        // Force reflow
        detailsElement.offsetHeight;
        
        // Animate out
        detailsElement.style.maxHeight = '0px';
        detailsElement.style.opacity = '0';
        detailsElement.style.transform = 'translateY(-10px)';
        
        // Rotate arrow back
        arrowElement.style.transform = 'rotate(0deg)';
        
        // Hide element after animation
        setTimeout(() => {
            detailsElement.classList.add('hidden');
            detailsElement.style.maxHeight = '';
            detailsElement.style.opacity = '';
            detailsElement.style.transform = '';
            detailsElement.style.transition = '';
        }, 300);
    }
}

// Optional: Add keyboard support
document.addEventListener('keydown', function(e) {
    if (e.target.tagName === 'BUTTON' && e.key === 'Enter') {
        e.target.click();
    }
});
</script>

<style>
.order-details {
    overflow: hidden;
}

.order-details.hidden {
    display: none;
}

/* Smooth transitions for all interactive elements */
button {
    transition: all 0.2s ease-in-out;
}

button:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}

/* Ensure proper spacing and alignment */
.space-y-6 > * + * {
    margin-top: 1.5rem;
}
</style>