<!-- Form Pembayaran -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Pembayaran</h2>
                    
                    <!-- Pilihan Bank -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Bank</label>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bank-option relative">
                                <input type="radio" id="bca" name="bank" value="bca" class="peer sr-only">
                                <label for="bca" class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-blue-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                                    <img src="https://via.placeholder.com/40x25/0066CC/FFFFFF?text=BCA" alt="BCA" class="w-10 h-6 mr-3 rounded">
                                    <span class="font-medium">BCA</span>
                                </label>
                            </div>
                            <div class="bank-option relative">
                                <input type="radio" id="mandiri" name="bank" value="mandiri" class="peer sr-only">
                                <label for="mandiri" class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-blue-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                                    <img src="https://via.placeholder.com/40x25/FFD700/000000?text=MDR" alt="Mandiri" class="w-10 h-6 mr-3 rounded">
                                    <span class="font-medium">Mandiri</span>
                                </label>
                            </div>
                            <div class="bank-option relative">
                                <input type="radio" id="bni" name="bank" value="bni" class="peer sr-only">
                                <label for="bni" class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-blue-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                                    <img src="https://via.placeholder.com/40x25/FF6600/FFFFFF?text=BNI" alt="BNI" class="w-10 h-6 mr-3 rounded">
                                    <span class="font-medium">BNI</span>
                                </label>
                            </div>
                            <div class="bank-option relative">
                                <input type="radio" id="bri" name="bank" value="bri" class="peer sr-only">
                                <label for="bri" class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-blue-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                                    <img src="https://via.placeholder.com/40x25/003366/FFFFFF?text=BRI" alt="BRI" class="w-10 h-6 mr-3 rounded">
                                    <span class="font-medium">BRI</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Kartu -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Kartu</label>
                            <div class="relative">
                                <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                       maxlength="19">
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                    <i class="fas fa-credit-card text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pemegang Kartu</label>
                            <input type="text" placeholder="Nama Lengkap" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Expired</label>
                                <input type="text" placeholder="MM/YY" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                       maxlength="5">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">CVV</label>
                                <div class="relative">
                                    <input type="password" placeholder="123" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                           maxlength="3">
                                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Checkbox -->
                    <div class="mt-6">
                        <label class="flex items-center">
                            <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-600">Simpan informasi kartu untuk pembelian selanjutnya</span>
                        </label>
                    </div>
                </div>
            </div>