<!-- Booking Details -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                            Detail Waktu
                        </h2>
                        <div class="bg-gray-50 rounded-xl p-5 space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Mulai</span>
                                    <div class="mt-1">
                                        <p class="text-sm font-semibold text-gray-900">{{ $orders->start_booking_date }}</p>
                                        <p class="text-sm text-gray-600">{{ $orders->start_booking_time }}</p>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Selesai</span>
                                    <div class="mt-1">
                                        <p class="text-sm font-semibold text-gray-900">{{ $orders->end_booking_date }}</p>
                                        <p class="text-sm text-gray-600">{{ $orders->end_booking_time }}</p>
                                    </div>
                                </div>
                            </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <span>Durasi: {{ $orders->duration ?? 'Tidak dapat dihitung' }}</span>
                            </div>
                        </div>
                    </div>