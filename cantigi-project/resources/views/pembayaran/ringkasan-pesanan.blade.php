<!-- Ringkasan Pesanan -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Ringkasan Pesanan</h2>
                
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">Rp 150.000</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Biaya Admin</span>
                        <span class="font-medium">Rp 2.500</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">PPN (11%)</span>
                        <span class="font-medium">Rp 16.500</span>
                    </div>
                    <hr class="my-4">
                    <div class="flex justify-between items-center py-2">
                        <span class="text-lg font-semibold text-gray-800">Total</span>
                        <span class="text-xl font-bold text-blue-600">Rp 169.000</span>
                    </div>
                </div>

                <!-- Keamanan -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-shield-alt text-green-600 mr-3"></i>
                        <div>
                            <h3 class="font-medium text-green-800">Pembayaran Aman</h3>
                            <p class="text-sm text-green-600">Data Anda dienkripsi dengan SSL 256-bit</p>
                        </div>
                    </div>
                </div>

                <!-- Tombol Bayar -->
                <button class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-4 px-6 rounded-lg hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition-all duration-200 shadow-lg">
                    <i class="fas fa-lock mr-2"></i>
                    Bayar Sekarang
                </button>

                <!-- Metode Pembayaran Lain -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 mb-3">Atau bayar dengan</p>
                    <div class="flex justify-center space-x-4">
                        <div class="w-12 h-8 bg-gradient-to-r from-blue-600 to-blue-700 rounded flex items-center justify-center">
                            <span class="text-white text-xs font-bold"><a href="{{ route('qris') }}">QRIS</a></span>
                        </div>
                    </div>
                </div>
            </div>