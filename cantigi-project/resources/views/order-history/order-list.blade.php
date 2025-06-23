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
                                            </div>
                                            
                                            <!-- Order Details -->
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
                                                        <a href="{{ route('payment.create', $order->id) }}" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors duration-200">
                                                            Lanjutkan Pembayaran
                                                            <i class="fas fa-arrow-right ml-2"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        
                                    </div>
                                </div>
                            @endforeach
                        </div>