 <!-- Payment Summary -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-receipt text-blue-600 mr-2"></i>
                            Ringkasan Pembayaran
                        </h2>
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-5 border border-blue-100">
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Sewa Kendaraan ({{ $orders->duration_in_hours }} jam)</span>
                                    <span class="text-sm font-medium text-gray-900">Rp{{ number_format($orders->total_price, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Biaya Admin</span>
                                    <span class="text-sm font-medium text-gray-900">Rp 0</span>
                                </div>
                                <div class="border-t border-blue-200 pt-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-base font-semibold text-gray-900">Total Pembayaran</span>
                                        <span class="text-xl font-bold text-blue-600">Rp{{ number_format($orders->total_price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>