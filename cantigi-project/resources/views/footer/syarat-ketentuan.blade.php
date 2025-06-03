    @extends('layouts.main')

@section('title', 'syarat-ketentuan')

@section('content')
    <style>
        /* Custom scrollbar untuk konten yang panjang */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
            border-radius: 2px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 2px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }
    </style>

    <!-- Syarat Dan Ketentuan Section -->
    <section class="py-16 px-4 sm:py-20 lg:py-24">
        <!-- Title -->
        <div class="text-center mb-12 sm:mb-16 lg:mb-20">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-semibold text-gray-900 leading-tight px-4">
                Syarat dan Ketentuan
            </h1>
            <div class="w-24 h-1 bg-[#138A40] mx-auto mt-4 rounded-full"></div>
        </div>

        <!-- Terms Container -->
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-10">
                
                <!-- Syarat & Ketentuan Umum -->
                <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-4 sm:p-6 lg:p-8 h-full">
                        <div class="bg-gradient-to-br from-[#138A40] to-[#0f7235] rounded-xl sm:rounded-2xl p-4 sm:p-6 lg:p-8 h-full flex flex-col shadow-lg">
                            <h2 class="font-bold text-white text-xl sm:text-2xl lg:text-3xl text-center mb-4 sm:mb-6">
                                Syarat & Ketentuan
                            </h2>
                            <div class="flex-1 overflow-y-auto custom-scrollbar">
                                <ol class="text-white list-decimal pl-4 sm:pl-6 space-y-2 sm:space-y-3 text-sm sm:text-base lg:text-lg leading-relaxed">
                                    <li>KTP menjadi dokumen utama yang harus diserahkan sebagai jaminan identitas penyewa</li>
                                    <li>Surat Izin Mengemudi (SIM A) wajib dimiliki dan masih berlaku untuk rental lepas kunci</li>
                                    <li>KTM diperlukan sebagai bukti status mahasiswa untuk mendapatkan diskon khusus</li>
                                    <li>Jaminan motor dan STNK 2016 keatas atau deposit sebesar Rp2.000.000</li>
                                    <li>Memiliki Akun media sosial yang aktif(Instagram & Facebook)</li>
                                    <li>Penyewa telah menandatangani surat perjanjian rental yang telah disepakati bersama</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cara Rental -->
                <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-4 sm:p-6 lg:p-8 h-full">
                        <div class="bg-gradient-to-br from-[#138A40] to-[#0f7235] rounded-xl sm:rounded-2xl p-4 sm:p-6 lg:p-8 h-full flex flex-col shadow-lg">
                            <h2 class="font-bold text-white text-xl sm:text-2xl lg:text-3xl text-center mb-4 sm:mb-6">
                                Cara Rental
                            </h2>
                            <div class="flex-1 overflow-y-auto custom-scrollbar">
                                <ol class="text-white list-decimal pl-4 sm:pl-6 space-y-2 sm:space-y-3 text-sm sm:text-base lg:text-lg leading-relaxed">
                                    <li>Cari mobil yang ingin anda rental melalui website atau aplikasi kami</li>
                                    <li>Pilih lokasi pickup, tanggal mulai, dan durasi sewa yang diinginkan</li>
                                    <li>Pilih jenis mobil yang diinginkan (dengan atau tanpa sopir, jenis kendaraan, dll)</li>
                                    <li>Cek ketersediaan mobil dan konfirmasi harga total yang harus dibayar</li>
                                    <li>Isi detail kontak lengkap dan informasi penyewa dengan benar</li>
                                    <li>Pilih metode pembayaran yang diinginkan (transfer bank, e-wallet, dll)</li>
                                    <li>Lakukan pembayaran DP dan tunggu konfirmasi dari tim kami</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Syarat Lepas Kunci -->
                <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-4 sm:p-6 lg:p-8 h-full">
                        <div class="bg-gradient-to-br from-[#138A40] to-[#0f7235] rounded-xl sm:rounded-2xl p-4 sm:p-6 lg:p-8 h-full flex flex-col shadow-lg">
                            <h2 class="font-bold text-white text-xl sm:text-2xl lg:text-3xl text-center mb-4 sm:mb-6">
                                Syarat Lepas Kunci
                            </h2>
                            <div class="flex-1 overflow-y-auto custom-scrollbar">
                                <ol class="text-white list-decimal pl-4 sm:pl-6 space-y-2 sm:space-y-3 text-sm sm:text-base lg:text-lg leading-relaxed">
                                    <li>Setiap pemesanan akan kami minta kelengkapan data KTP, SIM, dan dokumen pendukung lainnya</li>
                                    <li>Pemesanan dianggap valid setelah pembayaran DP minimal 30% dari total biaya</li>
                                    <li>Konfirmasi pembayaran DP ke pihak Cantigi Tours melalui WhatsApp atau telepon</li>
                                    <li>Jika dalam 3 jam tidak ada pengiriman data, pemesanan akan batal otomatis</li>
                                    <li>Jika dalam 6 jam belum melakukan pembayaran DP, pemesanan batal otomatis</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Syarat Dengan Sopir -->
                <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-4 sm:p-6 lg:p-8 h-full">
                        <div class="bg-gradient-to-br from-[#138A40] to-[#0f7235] rounded-xl sm:rounded-2xl p-4 sm:p-6 lg:p-8 h-full flex flex-col shadow-lg">
                            <h2 class="font-bold text-white text-xl sm:text-2xl lg:text-3xl text-center mb-4 sm:mb-6">
                                Syarat Dengan Sopir
                            </h2>
                            <div class="flex-1 overflow-y-auto custom-scrollbar">
                                <ol class="text-white list-decimal pl-4 sm:pl-6 space-y-2 sm:space-y-3 text-sm sm:text-base lg:text-lg leading-relaxed">
                                    <li>Setiap pemesanan akan kami minta kelengkapan data identitas dan kontak yang dapat dihubungi</li>
                                    <li>Pemesanan dianggap valid setelah pembayaran DP minimal 30% dari total biaya rental</li>
                                    <li>Konfirmasi pembayaran DP ke pihak Cantigi Tours untuk memastikan ketersediaan unit</li>
                                    <li>Jika dalam 3 jam tidak ada pengiriman data lengkap, pemesanan batal otomatis</li>
                                    <li>Jika dalam 6 jam belum melakukan pembayaran DP, pemesanan akan dibatalkan sistem</li>
                                    <li>Biaya makan dan penginapan sopir ditanggung oleh penyewa untuk perjalanan luar kota</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           
        </div>
    </section>
    @endsection
