<style>
    .contact-button {
        transition: all 0.3s ease-in-out;
    }
    .contact-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    .map-container {
        position: relative;
        overflow: hidden;
        border-radius: 1rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    /* Hapus pseudo-element yang menyebabkan maps tidak tampil */
    .map-container::before {
        display: none;
    }

    .map-container iframe {
        width: 100%;
        height: 400px;
        border: 0;
        border-radius: 1rem;
    }

    .social-whatsapp:hover { background-color: #25D366 !important; }
    .social-instagram:hover { background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%) !important; }
    .social-email:hover { background-color: #ea4335 !important; }
    .social-facebook:hover { background-color: #1877f2 !important; }

    @media (max-width: 768px) {
        .map-container iframe {
            height: 300px !important;
        }
    }
</style>

<!-- Location Section -->
<section class="py-16 px-4 sm:py-20 lg:py-8">
    <!-- Title -->
    <div class="text-center mb-12 sm:mb-16 lg:mb-20">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold text-gray-900 leading-tight px-4">
            Lokasi Kami
        </h1>
        <div class="w-24 h-1 bg-[#138A40] mx-auto mt-6 rounded-full"></div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto">
        <!-- Business Info -->
        <div class="text-center mb-8 sm:mb-12 lg:mb-16">
            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl p-6 sm:p-8 lg:p-10 max-w-4xl mx-auto">
                <h2 class="text-xl sm:text-2xl lg:text-3xl xl:text-4xl font-bold text-gray-900 mb-4 sm:mb-6">
                    Cantigi Bus Pariwisata dan Rental Mobil
                </h2>
                <div class="flex items-start justify-center gap-3 text-gray-600">
                    <i class="fas fa-map-marker-alt text-[#138A40] text-xl mt-1 flex-shrink-0"></i>
                    <p class="text-base sm:text-lg lg:text-xl leading-relaxed text-left sm:text-center max-w-3xl">
                        Jalan Drs. Moh Hatta No.7, Binuang Kp. Dalam, Kec. Pauh, Kota Padang, Sumatera Barat 25161
                    </p>
                </div>
            </div>
        </div>

        <!-- Map and Contact Container -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 lg:gap-12 items-start">
            
            <!-- Map Section -->
            <div class="xl:col-span-2">
                <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl p-4 sm:p-6 lg:p-8">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6 text-center sm:text-left">
                        📍 Temukan Kami di Peta
                    </h3>
                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.2923887764405!2d100.42093447448089!3d-0.9303159353396498!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4b9c02cbf2e53%3A0x602c01e8a0488eee!2sCantigi%20Bus%20Pariwisata%20dan%20Rental%20Mobil!5e0!3m2!1sid!2sid!4v1744778219969!5m2!1sid!2sid"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                    <!-- Map Info -->
                    <div class="mt-4 sm:mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock text-[#138A40]"></i>
                            <span>Buka 24 Jam</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-car text-[#138A40]"></i>
                            <span>Parkir Tersedia</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="xl:col-span-1">
                <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl p-4 sm:p-6 lg:p-8 h-fit sticky top-6">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 text-center">
                        💬 Hubungi Kami
                    </h3>

                    <div class="space-y-4">
                        <!-- WhatsApp -->
                        <a href="https://wa.me/6285363483996" target="_blank" rel="noopener noreferrer"
                            class="contact-button social-whatsapp bg-green-500 hover:bg-green-600 text-white p-4 rounded-xl flex items-center gap-4 group w-full">
                            <div class="bg-white/20 p-3 rounded-lg group-hover:bg-white/30 transition-colors">
                                <i class="fa fa-whatsapp text-2xl"></i>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-lg">WhatsApp</p>
                                <p class="text-sm opacity-90">+62 8536 3483 996</p>
                            </div>
                            <i class="fa fa-arrow-right ml-auto group-hover:translate-x-1 transition-transform"></i>
                        </a>

                        <!-- Instagram -->
                        <a href="https://instagram.com/cantigitours_" target="_blank" rel="noopener noreferrer"
                            class="contact-button social-instagram bg-pink-500 hover:bg-pink-600 text-white p-4 rounded-xl flex items-center gap-4 group w-full">
                            <div class="bg-white/20 p-3 rounded-lg group-hover:bg-white/30 transition-colors">
                                <i class="fa fa-instagram text-2xl"></i>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-lg">Instagram</p>
                                <p class="text-sm opacity-90">@CantigiTours</p>
                            </div>
                            <i class="fa fa-arrow-right ml-auto group-hover:translate-x-1 transition-transform"></i>
                        </a>

                        <!-- Email -->
                        <a href="mailto:CantigiTours@gmail.com" target="_blank" rel="noopener noreferrer"
                            class="contact-button social-email bg-red-500 hover:bg-red-600 text-white p-4 rounded-xl flex items-center gap-4 group w-full">
                            <div class="bg-white/20 p-3 rounded-lg group-hover:bg-white/30 transition-colors">
                                <i class="fa fa-envelope text-2xl"></i>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-lg">Email</p>
                                <p class="text-sm opacity-90">CantigiTours@gmail.com</p>
                            </div>
                            <i class="fa fa-arrow-right ml-auto group-hover:translate-x-1 transition-transform"></i>
                        </a>

                        <!-- Facebook -->
                        <a href="https://facebook.com/Cantigi Tours" target="_blank" rel="noopener noreferrer"
                            class="contact-button social-facebook bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-xl flex items-center gap-4 group w-full">
                            <div class="bg-white/20 p-3 rounded-lg group-hover:bg-white/30 transition-colors">
                                <i class="fa fa-facebook-f text-2xl"></i>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-lg">Facebook</p>
                                <p class="text-sm opacity-90">CantigiTours</p>
                            </div>
                            <i class="fa fa-arrow-right ml-auto group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>

                    <!-- Business Hours -->
                    <div class="mt-8 p-4 bg-gray-50 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <i class="fa fa-clock text-[#138A40]"></i>
                            Jam Operasional
                        </h4>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>Senin - Jumat</span>
                                <span class="font-medium">08:00 - 17:00</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Sabtu - Minggu</span>
                                <span class="font-medium">09:00 - 16:00</span>
                            </div>
                            <div class="flex justify-between text-[#138A40] font-medium">
                                <span>Emergency</span>
                                <span>24 Jam</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
