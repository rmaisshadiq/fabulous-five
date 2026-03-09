    <style>
        body {
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        /* Custom scrollbar for webkit browsers */
        .horizontal-scroll::-webkit-scrollbar {
            display: none;
        }
        
        .horizontal-scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        /* Smooth scroll behavior */
        .horizontal-scroll {
            scroll-behavior: smooth;
            scroll-snap-type: x mandatory;
        }
        
        .scroll-item {
            scroll-snap-align: start;
            scroll-snap-stop: always;
        }
        
        /* Apple-like card hover effects */
        .feature-card {
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .feature-card:hover {
            transform: translateY(-8px) scale(1.02);
        }
        
        .feature-icon-container {
            background: linear-gradient(135deg, #138A40 0%, #0f7a38 100%);
            position: relative;
            overflow: hidden;
        }
        
        .feature-icon-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0%, 100% { opacity: 0; }
            50% { opacity: 1; }
        }
        
        /* Scroll indicators */
        .scroll-indicator {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .scroll-indicator:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-50%) scale(1.1);
        }
        
        .scroll-indicator.left {
            left: 16px;
        }
        
        .scroll-indicator.right {
            right: 16px;
        }
        
        /* Mobile first responsive adjustments */
        @media (max-width: 768px) {
            .feature-card {
                min-width: 280px;
                max-width: 280px;
            }
        }
        
        @media (min-width: 375px) and (max-width: 768px) {
            .feature-card {
                min-width: 300px;
                max-width: 300px;
            }
        }
        
        @media (min-width: 768px) {
            .scroll-indicator {
                display: none;
            }
        }
    </style>

<div class="bg-gray-50">
    <!-- Unggulan Section -->
    <section class="py-16 px-4 sm:py-20 lg:py-24 bg-white">
        <!-- Title -->
        <div class="text-center mb-12 sm:mb-16 lg:mb-20">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-semibold text-gray-900 leading-tight px-4">
                Kenapa Harus Cantigi Tours?
            </h1>
            <!-- Mobile scroll hint -->
            <p class="text-gray-500 text-sm mt-4 md:hidden">Geser untuk melihat semua keunggulan</p>
        </div>

        <!-- Features Container -->
        <div class="max-w-7xl mx-auto relative">
            
            <!-- Mobile Horizontal Scroll (below md) -->
            <div class="md:hidden">
                <!-- Scroll Indicators -->
                <div class="scroll-indicator left" id="scrollLeft">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </div>
                <div class="scroll-indicator right" id="scrollRight">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>

                <!-- Horizontal Scrolling Container -->
                <div class="horizontal-scroll flex gap-6 overflow-x-auto pb-4 px-4" id="mobileScroll">
                    
                    <!-- Feature 1: Harga Termurah -->
                    <div class="feature-card scroll-item bg-white rounded-3xl shadow-xl hover:shadow-2xl flex-shrink-0">
                        <div class="feature-icon-container w-full aspect-square rounded-t-3xl flex items-center justify-center overflow-hidden relative">
                            <div class="absolute inset-4 bg-white/10 rounded-2xl"></div>
                            <!-- Placeholder icon since we don't have the actual image -->
                            <div class="w-32 h-32 relative z-10 rounded-2xl flex items-center justify-center">
                               <img src="{{ asset('images/unggulan/low-price.png') }}"  alt="low pirce">
                            </div>
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">
                                Harga Termurah
                            </h3>
                            <p class="text-gray-600 leading-relaxed text-sm">
                                Cantigi Tour menyediakan kendaraan berkualitas dan harga yang terjangkau sekota Padang
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2: Kendaraan Berkualitas -->
                    <div class="feature-card scroll-item bg-white rounded-3xl shadow-xl hover:shadow-2xl flex-shrink-0">
                        <div class="feature-icon-container w-full aspect-square rounded-t-3xl flex items-center justify-center overflow-hidden relative">
                            <div class="absolute inset-4 bg-white/10 rounded-2xl"></div>
                            <!-- Placeholder icon -->
                            <div class="w-32 h-32 relative z-10 rounded-2xl flex items-center justify-center">
                                <img src="{{ asset('images/unggulan/quality.png') }}"  alt="quality">
                            </div>
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">
                                Kendaraan Berkualitas
                            </h3>
                            <p class="text-gray-600 leading-relaxed text-sm">
                                Cantigi Tour menyediakan kendaraan berkualitas yang siap untuk dipakai tanpa kerusakan
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3: Pelayanan Ramah -->
                    <div class="feature-card scroll-item bg-white rounded-3xl shadow-xl hover:shadow-2xl flex-shrink-0">
                        <div class="feature-icon-container w-full aspect-square rounded-t-3xl flex items-center justify-center overflow-hidden relative">
                            <div class="absolute inset-4 bg-white/10 rounded-2xl"></div>
                            <!-- Placeholder icon -->
                            <div class="w-32 h-32 relative z-10 rounded-2xl flex items-center justify-center">
                                <img src="{{ asset('images/unggulan/tech-support.png') }}"  alt="tech support">
                            </div>
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">
                                Pelayanan Ramah
                            </h3>
                            <p class="text-gray-600 leading-relaxed text-sm">
                                Kami memberikan pelayanan sepenuh hati sehingga customer nyaman dalam perjalanan
                            </p>
                        </div>
                    </div>

                    <!-- Extra padding for better scrolling -->
                    <div class="w-4 flex-shrink-0"></div>
                </div>

                <!-- Scroll Progress Indicator -->
                <div class="flex justify-center mt-6 space-x-2">
                    <div class="scroll-dot w-2 h-2 rounded-full bg-gray-300 transition-all duration-300" data-index="0"></div>
                    <div class="scroll-dot w-2 h-2 rounded-full bg-gray-300 transition-all duration-300" data-index="1"></div>
                    <div class="scroll-dot w-2 h-2 rounded-full bg-gray-300 transition-all duration-300" data-index="2"></div>
                </div>
            </div>

            <!-- Desktop Grid Layout (md and above) -->
            <div class="hidden md:block">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 lg:gap-12 justify-items-center">
                    
                    <!-- Feature 1: Harga Termurah -->
                    <div class="feature-card bg-white rounded-3xl shadow-xl hover:shadow-2xl max-w-sm w-full">
                        <div class="feature-icon-container w-full aspect-square rounded-t-3xl flex items-center justify-center overflow-hidden relative">
                            <div class="absolute inset-4 bg-white/10 rounded-2xl"></div>
                            <div class="w-32 h-32 sm:w-40 sm:h-40 lg:w-48 lg:h-48 relative z-10 rounded-2xl flex items-center justify-center">
                                    <img src="{{ asset('images/unggulan/low-price.png') }}"  alt="">
                            </div>
                        </div>
                        <div class="p-6 sm:p-8 text-center">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4">
                                Harga Termurah
                            </h3>
                            <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
                                Cantigi Tour menyediakan kendaraan berkualitas dan harga yang terjangkau sekota Padang
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2: Kendaraan Berkualitas -->
                    <div class="feature-card bg-white rounded-3xl shadow-xl hover:shadow-2xl max-w-sm w-full">
                        <div class="feature-icon-container w-full aspect-square rounded-t-3xl flex items-center justify-center overflow-hidden relative">
                            <div class="absolute inset-4 bg-white/10 rounded-2xl"></div>
                            <div class="w-32 h-32 sm:w-40 sm:h-40 lg:w-48 lg:h-48 relative z-10  rounded-2xl flex items-center justify-center">
                                <img src="{{ asset('images/unggulan/quality.png') }}"  alt="quality">
                            </div>
                        </div>
                        <div class="p-6 sm:p-8 text-center">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4">
                                Kendaraan Berkualitas
                            </h3>
                            <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
                                Cantigi Tour menyediakan kendaraan berkualitas yang siap untuk dipakai tanpa kerusakan
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3: Pelayanan Ramah -->
                    <div class="feature-card bg-white rounded-3xl shadow-xl hover:shadow-2xl max-w-sm w-full md:col-span-2 xl:col-span-1">
                        <div class="feature-icon-container w-full aspect-square rounded-t-3xl flex items-center justify-center overflow-hidden relative">
                            <div class="absolute inset-4 bg-white/10 rounded-2xl"></div>
                            <div class="w-32 h-32 sm:w-40 sm:h-40 lg:w-48 lg:h-48 relative z-10 rounded-2xl flex items-center justify-center">
                                <img src="{{ asset('images/unggulan/tech-support.png') }}"  alt="tech support">
                            </div>
                        </div>
                        <div class="p-6 sm:p-8 text-center">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4">
                                Pelayanan Ramah
                            </h3>
                            <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
                                Kami memberikan pelayanan sepenuh hati sehingga customer nyaman dalam perjalanan
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Mobile scroll functionality
        const mobileScroll = document.getElementById('mobileScroll');
        const scrollLeft = document.getElementById('scrollLeft');
        const scrollRight = document.getElementById('scrollRight');
        const scrollDots = document.querySelectorAll('.scroll-dot');

        let currentIndex = 0;
        const cardWidth = 300; // Approximate card width including gap

        // Scroll left button
        scrollLeft.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                mobileScroll.scrollTo({
                    left: currentIndex * (cardWidth + 24), // 24px gap
                    behavior: 'smooth'
                });
                updateScrollIndicators();
            }
        });

        // Scroll right button
        scrollRight.addEventListener('click', () => {
            if (currentIndex < 2) { // 3 cards, so max index is 2
                currentIndex++;
                mobileScroll.scrollTo({
                    left: currentIndex * (cardWidth + 24),
                    behavior: 'smooth'
                });
                updateScrollIndicators();
            }
        });

        // Update scroll indicators
        function updateScrollIndicators() {
            // Update button visibility
            scrollLeft.style.opacity = currentIndex === 0 ? '0.5' : '1';
            scrollRight.style.opacity = currentIndex === 2 ? '0.5' : '1';
            
            // Update dots
            scrollDots.forEach((dot, index) => {
                if (index === currentIndex) {
                    dot.classList.add('bg-green-500');
                    dot.classList.remove('bg-gray-300');
                } else {
                    dot.classList.add('bg-gray-300');
                    dot.classList.remove('bg-green-500');
                }
            });
        }

        // Handle scroll events for automatic indicator updates
        mobileScroll.addEventListener('scroll', () => {
            const scrollPosition = mobileScroll.scrollLeft;
            const newIndex = Math.round(scrollPosition / (cardWidth + 24));
            
            if (newIndex !== currentIndex && newIndex >= 0 && newIndex <= 2) {
                currentIndex = newIndex;
                updateScrollIndicators();
            }
        });

        // Initialize indicators
        updateScrollIndicators();

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                currentIndex = 0;
                mobileScroll.scrollTo({ left: 0 });
            }
        });

        // Touch/swipe support for better mobile interaction
        let startX = 0;
        let scrollStart = 0;

        mobileScroll.addEventListener('touchstart', (e) => {
            startX = e.touches[0].pageX;
            scrollStart = mobileScroll.scrollLeft;
        });

        mobileScroll.addEventListener('touchmove', (e) => {
            if (!startX) return;
            
            const currentX = e.touches[0].pageX;
            const diff = startX - currentX;
            
            mobileScroll.scrollLeft = scrollStart + diff;
        });

        mobileScroll.addEventListener('touchend', () => {
            startX = 0;
            scrollStart = 0;
        });

        // Add parallax effect to icons on scroll
        window.addEventListener('scroll', () => {
            const cards = document.querySelectorAll('.feature-card');
            cards.forEach(card => {
                const rect = card.getBoundingClientRect();
                const windowHeight = window.innerHeight;
                
                if (rect.top < windowHeight && rect.bottom > 0) {
                    const progress = (windowHeight - rect.top) / (windowHeight + rect.height);
                    const icon = card.querySelector('.feature-icon-container > div:last-child');
                    if (icon) {
                        icon.style.transform = `translateY(${progress * -20}px) scale(${1 + progress * 0.1})`;
                    }
                }
            });
        });
    </script>
</body>