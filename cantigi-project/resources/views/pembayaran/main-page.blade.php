@extends('layouts.main')

@section('title', 'Create New Order')

@section('content')
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Checkout Pembayaran</h1>
            <p class="text-gray-600">Lengkapi data pembayaran Anda dengan aman</p>
        </div>

        <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-8">
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
                            <span class="text-white text-xs font-bold">VISA</span>
                        </div>
                        <div class="w-12 h-8 bg-gradient-to-r from-red-600 to-red-700 rounded flex items-center justify-center">
                            <span class="text-white text-xs font-bold">MC</span>
                        </div>
                        <div class="w-12 h-8 bg-gradient-to-r from-blue-800 to-blue-900 rounded flex items-center justify-center">
                            <span class="text-white text-xs font-bold">AMEX</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="max-w-4xl mx-auto mt-8 text-center">
            <p class="text-sm text-gray-600">
                <i class="fas fa-info-circle mr-1"></i>
                Transaksi Anda akan muncul sebagai "MERCHANT NAME" di rekening bank Anda
            </p>
        </div>
    </div>

    <script>
        // Format nomor kartu
        document.getElementById('cardNumber').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            this.value = formattedValue;
        });

        // Format tanggal expired
        document.querySelector('input[placeholder="MM/YY"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            this.value = value;
        });

        // Animasi hover untuk bank options
        document.querySelectorAll('.bank-option').forEach(option => {
            option.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            option.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Validasi form
        document.querySelector('button').addEventListener('click', function(e) {
            e.preventDefault();
            
            const cardNumber = document.getElementById('cardNumber').value;
            const selectedBank = document.querySelector('input[name="bank"]:checked');
            
            if (!selectedBank) {
                alert('Silakan pilih bank terlebih dahulu');
                return;
            }
            
            if (cardNumber.replace(/\s/g, '').length < 16) {
                alert('Nomor kartu tidak valid');
                return;
            }
            
            // Simulasi proses pembayaran
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            this.disabled = true;
            
            setTimeout(() => {
                alert('Pembayaran berhasil! Terima kasih.');
                this.innerHTML = '<i class="fas fa-check mr-2"></i>Pembayaran Berhasil';
                this.classList.remove('from-blue-600', 'to-blue-700');
                this.classList.add('from-green-600', 'to-green-700');
            }, 2000);
        });
    </script>
</body>
@endsection