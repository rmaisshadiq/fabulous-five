    <style>
        /* Animasi dan efek hover untuk artikel */
        .blog-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .blog-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .blog-image-container {
            overflow: hidden;
            position: relative;
        }
        
        .blog-image {
            transition: transform 0.6s ease;
        }
        
        .blog-card:hover .blog-image {
            transform: scale(1.08);
        }
        
        .blog-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0) 60%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        
        .blog-card:hover .blog-overlay {
            opacity: 1;
        }
        
        .read-more {
            position: relative;
            display: inline-block;
        }
        
        .read-more::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: currentColor;
            transition: width 0.3s ease;
        }
        
        .blog-card:hover .read-more::after {
            width: 100%;
        }
        
        /* Efek shine pada hover */
        .shine-effect {
            position: relative;
            overflow: hidden;
        }
        
        .shine-effect::before {
            content: '';
            position: absolute;
            top: 0;
            left: -75%;
            z-index: 2;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.3) 100%);
            transform: skewX(-25deg);
            transition: all 0.75s;
        }
        
        .blog-card:hover .shine-effect::before {
            animation: shine 0.85s;
        }
        
        @keyframes shine {
            100% {
                left: 125%;
            }
        }
        
        /* Animasi judul artikel */
        .blog-title {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .blog-card:hover .blog-title {
            color: #34D399; /* green-400 */
        }
        
        /* Animasi untuk header */
        .article-header {
            position: relative;
        }
        
        .article-header::after {
            content: '';
            position: absolute;
            width: 0;
            height: 4px;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #34D399; /* green-400 */
            transition: width 0.4s ease;
        }
        
        .article-header:hover::after {
            width: 100px;
        }
        
        /* Responsivitas tambahan */
        @media (max-width: 640px) {
            .blog-card {
                margin-bottom: 2rem;
            }
        }
        
        /* Fitur lazy load dengan placeholder */
        .lazy-image {
            filter: blur(5px);
            transition: filter 0.5s ease;
        }
        
        .lazy-loaded {
            filter: blur(0);
        }
    </style>

    <!-- BLOG HEADER -->
    <div class="flex justify-center items-center mt-24 sm:mt-28 md:mt-32 lg:mt-36">
        <h1 class="article-header text-center font-semibold text-2xl sm:text-3xl md:text-4xl lg:text-5xl tracking-tight">Article</h1>
    </div>

    <div class="max-w-7xl mx-auto p-4 sm:p-5 md:p-6 lg:p-8 space-y-8 lg:space-y-12">
        <!-- Baris pertama: 3 blog -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
            <!-- BLOG 1 -->
            <div class="blog-card bg-white overflow-hidden rounded-xl">
                <div class="blog-image-container w-full h-48 sm:h-56 md:h-64 lg:h-72 overflow-hidden p-2 shine-effect">
                    <div class="blog-overlay"></div>
                    <img class="blog-image w-full h-full object-cover rounded-lg" src="{{ asset('images/artikel/List harga.png') }}" alt="List Harga">
                </div>
                <div class="px-4 sm:px-5 py-4 sm:py-5 space-y-2 sm:space-y-3">
                    <p class="blog-title font-bold text-lg sm:text-xl md:text-2xl">List Harga di CantigiTours</p>
                    <p class="text-xs sm:text-sm text-gray-600 line-clamp-2">Lihat Lihat List Harga Rental Kendaraan di Cantigi Tours</p>
                    <a href="#" class="read-more text-green-500 hover:text-green-600 text-xs sm:text-sm font-medium flex items-center">
                        Baca Selengkapnya
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transition-transform transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- BLOG 2 -->
            <div class="blog-card bg-white overflow-hidden rounded-xl">
                <div class="blog-image-container w-full h-48 sm:h-56 md:h-64 lg:h-72 overflow-hidden p-2 shine-effect">
                    <div class="blog-overlay"></div>
                    <img class="blog-image w-full h-full object-cover rounded-lg" src="{{ asset('images/artikel/Tentang Cantigi.png') }}" alt="Tentang CantigiTours">
                </div>
                <div class="px-4 sm:px-5 py-4 sm:py-5 space-y-2 sm:space-y-3">
                    <p class="blog-title font-bold text-lg sm:text-xl md:text-2xl">Tentang Cantigi Tours</p>
                    <p class="text-xs sm:text-sm text-gray-600 line-clamp-2">Cari tahu bagaimana cara rental mobil di Cantigi Rent Car dan lihat-lihat harga!</p>
                    <a href="#" class="read-more text-green-500 hover:text-green-600 text-xs sm:text-sm font-medium flex items-center">
                        Baca Selengkapnya
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transition-transform transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- BLOG 3 -->
            <div class="blog-card bg-white overflow-hidden rounded-xl">
                <div class="blog-image-container w-full h-48 sm:h-56 md:h-64 lg:h-72 overflow-hidden p-2 shine-effect">
                    <div class="blog-overlay"></div>
                    <img class="blog-image w-full h-full object-cover rounded-lg" src="{{ asset('images/artikel/Lalu Lintas.jpg') }}" alt="Rambu Lalu Lintas">
                </div>
                <div class="px-4 sm:px-5 py-4 sm:py-5 space-y-2 sm:space-y-3">
                    <p class="blog-title font-bold text-lg sm:text-xl md:text-2xl">Lalu Lintas Padang</p>
                    <p class="text-xs sm:text-sm text-gray-600 line-clamp-2">Info Lalu Lintas Padang Terkini</p>
                    <a href="#" class="read-more text-green-500 hover:text-green-600 text-xs sm:text-sm font-medium flex items-center">
                        Baca Selengkapnya
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transition-transform transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Baris kedua: 2 blog -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 md:gap-8">
            <!-- BLOG 4 -->
            <div class="blog-card bg-white overflow-hidden rounded-xl">
                <div class="blog-image-container w-full h-48 sm:h-56 md:h-64 lg:h-72 overflow-hidden p-2 shine-effect">
                    <div class="blog-overlay"></div>
                    <img class="blog-image w-full h-full object-cover rounded-lg" src="{{ asset('images/artikel/kalender.png') }}" alt="Jadwal Libur">
                </div>
                <div class="px-4 sm:px-5 py-4 sm:py-5 space-y-2 sm:space-y-3">
                    <p class="blog-title font-bold text-lg sm:text-xl md:text-2xl">Jadwal Libur 2025</p>
                    <p class="text-xs sm:text-sm text-gray-600 line-clamp-3">Lihat Jadwal Libur Tahun 2025 siapkan uang anda</p>
                    <a href="#" class="read-more text-green-500 hover:text-green-600 text-xs sm:text-sm font-medium flex items-center">
                        Baca Selengkapnya
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transition-transform transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- BLOG 5 -->
            <div class="blog-card bg-white overflow-hidden rounded-xl">
                <div class="blog-image-container w-full h-48 sm:h-56 md:h-64 lg:h-72 overflow-hidden p-2 shine-effect">
                    <div class="blog-overlay"></div>
                    <img class="blog-image w-full h-full object-cover rounded-lg" src="{{ asset('images/artikel/Avanza terbaru.png') }}" alt="Toyota Avanza">
                </div>
                <div class="px-4 sm:px-5 py-4 sm:py-5 space-y-2 sm:space-y-3">
                    <p class="blog-title font-bold text-lg sm:text-xl md:text-2xl">Toyota Avanza Terbaru 2025</p>
                    <p class="text-xs sm:text-sm text-gray-600 line-clamp-3 md:line-clamp-4">Toyota Avanza baru, yang juga dikenal sebagai All New Avanza, adalah MPV 7-seater yang populer di Indonesia. Avanza ini memiliki berbagai pilihan varian dan mesin, serta tersedia dengan transmisi manual dan otomatis (CVT).</p>
                    <a href="#" class="read-more text-green-500 hover:text-green-600 text-xs sm:text-sm font-medium flex items-center">
                        Baca Selengkapnya
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transition-transform transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

