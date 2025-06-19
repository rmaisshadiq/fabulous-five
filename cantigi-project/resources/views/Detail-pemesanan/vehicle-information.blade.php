 <!-- Vehicle Information -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            Informasi Kendaraan
                        </h2>
                        <div class="bg-gray-50 rounded-xl p-5 space-y-4">
                            <div class="flex justify-between items-start">
                                <span class="text-sm font-medium text-gray-600">Jenis Kendaraan</span>
                                <span class="text-sm font-semibold text-gray-900 text-right">{{ $orders->vehicle_id }}</span>
                            </div>
                            <div class="flex justify-between items-start">
                                <span class="text-sm font-medium text-gray-600">Layanan</span>
                                <div class="text-right">
                                    <span class="text-sm font-semibold text-gray-900">Tanpa Driver</span>
                                    <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 ml-2">
                                        Self Drive
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between items-start">
                                <span class="text-sm font-medium text-gray-600">Lokasi Ambil Kendaraan</span>
                                <span class="text-sm font-semibold text-gray-900 text-right">{{ $orders->drop_address }}</span>
                            </div>
                        </div>
                    </div>
                </div>