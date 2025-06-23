    @extends('layouts.main')

@section('title', 'pusat-bantuan')

@section('content')
    <style>
        .faq-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-in-out, padding 0.4s ease-in-out;
        }
        .faq-content.active {
            max-height: 500px;
            padding-top: 1rem;
            padding-bottom: 0.5rem;
        }
        .faq-icon {
            transition: transform 0.3s ease-in-out;
        }
        .faq-icon.rotate {
            transform: rotate(180deg);
        }
        .faq-item {
            transition: all 0.3s ease-in-out;
        }
        .faq-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(19, 138, 64, 0.2);
        }
    </style>
    <!-- FAQ Section -->
    <section class="py-16 px-4 sm:py-20 lg:py-24">
        <!-- Title -->
        <div class="text-center mb-12 sm:mb-16 lg:mb-20">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold text-gray-900 leading-tight px-4">
                Pusat Bantuan
            </h1>
            <p class="text-gray-600 mt-4 text-sm sm:text-base lg:text-lg max-w-2xl mx-auto">
                Temukan jawaban untuk pertanyaan yang sering diajukan seputar layanan rental kami
            </p>
            <div class="w-24 h-1 bg-[#138A40] mx-auto mt-6 rounded-full"></div>
        </div>

        <!-- FAQ Container -->
        <div class="max-w-4xl mx-auto">
            <div class="space-y-4 sm:space-y-6">
                
                <!-- FAQ Item 1 -->
                <div class="faq-item bg-white rounded-xl sm:rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#138A40] to-[#0f7235] p-4 sm:p-6 lg:p-8">
                        <div class="flex items-center justify-between cursor-pointer" onclick="toggleFaq(1)">
                            <h3 class="text-white text-lg sm:text-xl lg:text-2xl font-semibold pr-4 leading-tight">
                                Mengapa Harus Memilih CantigiTours?
                            </h3>
                            <i id="icon-1" class="fa fa-chevron-down text-white text-lg sm:text-xl faq-icon flex-shrink-0"></i>
                        </div>
                        <div id="faq-1" class="faq-content text-white">
                            <div class="text-sm sm:text-base lg:text-lg leading-relaxed text-white/90">
                                <p class="mb-3">CantigiTours adalah pilihan terbaik untuk kebutuhan rental kendaraan Anda karena:</p>
                                <ul class="list-disc pl-6 space-y-2">
                                    <li>Layanan rental terpercaya dengan pengalaman bertahun-tahun</li>
                                    <li>Harga bersahabat dan kompetitif di pasaran</li>
                                    <li>Kendaraan terawat dan dalam kondisi prima</li>
                                    <li>Pelayanan ramah dan profesional 24/7</li>
                                    <li>Proses booking yang mudah dan cepat</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="faq-item bg-white rounded-xl sm:rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#138A40] to-[#0f7235] p-4 sm:p-6 lg:p-8">
                        <div class="flex items-center justify-between cursor-pointer" onclick="toggleFaq(2)">
                            <h3 class="text-white text-lg sm:text-xl lg:text-2xl font-semibold pr-4 leading-tight">
                                Bagaimana Cara Memesan Kendaraan?
                            </h3>
                            <i id="icon-2" class="fa fa-chevron-down text-white text-lg sm:text-xl faq-icon flex-shrink-0"></i>
                        </div>
                        <div id="faq-2" class="faq-content text-white">
                            <div class="text-sm sm:text-base lg:text-lg leading-relaxed text-white/90">
                                <p class="mb-4">Ikuti langkah-langkah berikut untuk memesan kendaraan:</p>
                                <ol class="list-decimal pl-6 space-y-2">
                                    <li>Buka website resmi CantigiTours atau hubungi customer service</li>
                                    <li>Masuk ke akun Anda atau buat akun baru jika belum memiliki</li>
                                    <li>Pilih jenis kendaraan yang sesuai kebutuhan Anda</li>
                                    <li>Tentukan lokasi pickup, tanggal mulai, dan durasi sewa</li>
                                    <li>Klik "Cari" untuk mengecek ketersediaan kendaraan</li>
                                    <li>Pilih kendaraan yang ingin disewa dari daftar yang tersedia</li>
                                    <li>Review dan konfirmasi detail pesanan Anda</li>
                                    <li>Lengkapi data pribadi dan dokumen yang diperlukan</li>
                                    <li>Lakukan pembayaran sesuai metode yang dipilih</li>
                                    <li>Cek status pesanan dan tunggu konfirmasi dari tim kami</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="faq-item bg-white rounded-xl sm:rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#138A40] to-[#0f7235] p-4 sm:p-6 lg:p-8">
                        <div class="flex items-center justify-between cursor-pointer" onclick="toggleFaq(3)">
                            <h3 class="text-white text-lg sm:text-xl lg:text-2xl font-semibold pr-4 leading-tight">
                                Metode Pembayaran Apa Saja yang Tersedia?
                            </h3>
                            <i id="icon-3" class="fa fa-chevron-down text-white text-lg sm:text-xl faq-icon flex-shrink-0"></i>
                        </div>
                        <div id="faq-3" class="faq-content text-white">
                            <div class="text-sm sm:text-base lg:text-lg leading-relaxed text-white/90">
                                <p class="mb-4">Kami menyediakan berbagai metode pembayaran untuk kemudahan Anda:</p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <h4 class="font-semibold mb-2">💳 Transfer Bank:</h4>
                                        <ul class="list-disc pl-4 space-y-1 text-sm">
                                            <li>BCA, BRI, BNI, Mandiri</li>
                                            <li>Bank daerah lainnya</li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold mb-2">📱 E-Wallet:</h4>
                                        <ul class="list-disc pl-4 space-y-1 text-sm">
                                            <li>OVO, DANA, GoPay</li>
                                            <li>ShopeePay, LinkAja</li>
                                        </ul>
                                    </div>
                                </div>
                                <p class="bg-white/10 p-3 rounded-lg">
                                    <strong>💡 Tips:</strong> Untuk kemudahan, Anda juga bisa membayar tunai langsung ke admin saat pengambilan kendaraan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 4 - Additional -->
                <div class="faq-item bg-white rounded-xl sm:rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#138A40] to-[#0f7235] p-4 sm:p-6 lg:p-8">
                        <div class="flex items-center justify-between cursor-pointer" onclick="toggleFaq(4)">
                            <h3 class="text-white text-lg sm:text-xl lg:text-2xl font-semibold pr-4 leading-tight">
                                Dokumen Apa Saja yang Diperlukan untuk Rental?
                            </h3>
                            <i id="icon-4" class="fa fa-chevron-down text-white text-lg sm:text-xl faq-icon flex-shrink-0"></i>
                        </div>
                        <div id="faq-4" class="faq-content text-white">
                            <div class="text-sm sm:text-base lg:text-lg leading-relaxed text-white/90">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <h4 class="font-semibold mb-3 text-yellow-200">📋 Rental Lepas Kunci:</h4>
                                        <ul class="list-disc pl-4 space-y-1">
                                            <li>KTP asli (sebagai jaminan)</li>
                                            <li>SIM A yang masih berlaku</li>
                                            <li>KTM (untuk diskon mahasiswa)</li>
                                            <li>Kartu keluarga (jika diperlukan)</li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold mb-3 text-yellow-200">🚗 Rental Dengan Sopir:</h4>
                                        <ul class="list-disc pl-4 space-y-1">
                                            <li>KTP asli penyewa</li>
                                            <li>Nomor telepon yang aktif</li>
                                            <li>Alamat lengkap dan jelas</li>
                                            <li>Contact person darurat</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 5 - Additional -->
                <div class="faq-item bg-white rounded-xl sm:rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#138A40] to-[#0f7235] p-4 sm:p-6 lg:p-8">
                        <div class="flex items-center justify-between cursor-pointer" onclick="toggleFaq(5)">
                            <h3 class="text-white text-lg sm:text-xl lg:text-2xl font-semibold pr-4 leading-tight">
                                Bagaimana Jika Terjadi Kerusakan atau Kecelakaan?
                            </h3>
                            <i id="icon-5" class="fa fa-chevron-down text-white text-lg sm:text-xl faq-icon flex-shrink-0"></i>
                        </div>
                        <div id="faq-5" class="faq-content text-white">
                            <div class="text-sm sm:text-base lg:text-lg leading-relaxed text-white/90">
                                <div class="space-y-4">
                                    <div class="bg-red-500/20 p-4 rounded-lg border-l-4 border-red-400">
                                        <h4 class="font-semibold mb-2 text-red-200">🚨 Langkah Darurat:</h4>
                                        <ol class="list-decimal pl-4 space-y-1">
                                            <li>Segera hubungi customer service kami 24/7</li>
                                            <li>Laporkan kondisi dan lokasi kejadian</li>
                                            <li>Ambil foto dokumentasi jika memungkinkan</li>
                                            <li>Jangan tinggalkan lokasi sebelum konfirmasi</li>
                                        </ol>
                                    </div>
                                    <div class="bg-blue-500/20 p-4 rounded-lg border-l-4 border-blue-400">
                                        <h4 class="font-semibold mb-2 text-blue-200">💼 Asuransi & Pertanggungan:</h4>
                                        <ul class="list-disc pl-4 space-y-1">
                                            <li>Semua kendaraan dilengkapi asuransi</li>
                                            <li>Kerusakan ringan akan ditangani cepat</li>
                                            <li>Biaya perbaikan sesuai kesepakatan kontrak</li>
                                            <li>Tim teknis siaga untuk bantuan darurat</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script>
        function toggleFaq(index) {
            const content = document.getElementById(`faq-${index}`);
            const icon = document.getElementById(`icon-${index}`);
            
            // Close all other FAQs
            for (let i = 1; i <= 5; i++) {
                if (i !== index) {
                    const otherContent = document.getElementById(`faq-${i}`);
                    const otherIcon = document.getElementById(`icon-${i}`);
                    if (otherContent && otherIcon) {
                        otherContent.classList.remove('active');
                        otherIcon.classList.remove('rotate');
                    }
                }
            }
            
            // Toggle current FAQ
            if (content && icon) {
                content.classList.toggle('active');
                icon.classList.toggle('rotate');
            }
        }

        // Close FAQ when clicking outside
        document.addEventListener('click', function(event) {
            const faqItems = document.querySelectorAll('.faq-item');
            let clickedInside = false;
            
            faqItems.forEach(item => {
                if (item.contains(event.target)) {
                    clickedInside = true;
                }
            });
            
            if (!clickedInside) {
                // Close all FAQs
                for (let i = 1; i <= 5; i++) {
                    const content = document.getElementById(`faq-${i}`);
                    const icon = document.getElementById(`icon-${i}`);
                    if (content && icon) {
                        content.classList.remove('active');
                        icon.classList.remove('rotate');
                    }
                }
            }
        });
    </script>
    @endsection