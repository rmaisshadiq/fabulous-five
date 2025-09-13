
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    screens: {
                        'xs': '475px',
                    },
                    fontFamily: {
                        'sans': ['SF Pro Display', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <!-- CSS -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@300;400;500;600;700&display=swap');
        
        .logo {
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        /* Smooth transitions */
        * {
            transition: all 0.2s ease;
        }
        
        /* Mobile-first approach dengan collapsible sections */
        .footer-section {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .footer-section:last-child {
            border-bottom: none;
        }
        
        .section-toggle {
            cursor: pointer;
            user-select: none;
        }
        
        .section-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
        }
        
        .section-content.open {
            max-height: 300px;
            padding-top: 1rem;
            padding-bottom: 1.5rem;
        }
        
        .chevron {
            transition: transform 0.3s ease;
        }
        
        .chevron.open {
            transform: rotate(180deg);
        }
        
        @media (min-width: 768px) {
            .footer-section {
                border-bottom: none;
            }
            
            .section-content {
                max-height: none;
                padding-top: 0;
                padding-bottom: 0;
            }
            
            .section-toggle {
                cursor: default;
            }
        }
        
        /* Apple-like hover effects */
        .social-link {
            transition: transform 0.2s ease, color 0.2s ease;
        }
        
        .social-link:hover {
            transform: translateY(-2px);
        }
        
        .footer-link {
            position: relative;
            transition: color 0.2s ease;
        }
        
        .footer-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 1px;
            bottom: -2px;
            left: 0;
            background-color: currentColor;
            transition: width 0.2s ease;
        }
        
        .footer-link:hover::after {
            width: 100%;
        }
    </style>


<!-- CONTAINER -->
<div class="bg-gray-100">
    <!-- Responsive Footer -->
    <footer class="bg-[#0e0e0e] text-white">
        <!-- Desktop Layout (md and above) -->
        <div class="hidden md:block">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                    <!-- Brand Section -->
                    <div class="md:col-span-4 lg:col-span-3">
                        <a href="#" class="inline-block">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                                  <img src="{{ asset('images/logo/logo.png') }}" alt="CantigiTours Logo" class="w-10 md:w-12 lg:w-16">
                                </div>
                                <h1 class="logo font-bold text-2xl lg:text-3xl">Cantigi Tours</h1>
                            </div>
                        </a>
                        <p class="text-gray-400 text-sm max-w-sm">
                            Menjelajahi keindahan Indonesia bersama kami. Pengalaman wisata terbaik untuk petualangan tak terlupakan.
                        </p>
                    </div>

                    <!-- Navigation Sections -->
                    <div class="md:col-span-8 lg:col-span-9">
                        <div class="grid grid-cols-2 lg:grid-cols-3 gap-8">
                            <!-- Informasi -->
                            <div>
                                <h3 class="font-semibold text-lg mb-4 text-white">Informasi</h3>
                                <ul class="space-y-2">
                                    <li><a href="#" class="footer-link text-gray-300 hover:text-white text-sm">Tentang Kami</a></li>
                                    <li><a href="#" class="footer-link text-gray-300 hover:text-white text-sm">Hubungi Kami</a></li>
                                    <li><a href="#" class="footer-link text-gray-300 hover:text-white text-sm">Kebijakan Privasi</a></li>
                                    <li><a href="#" class="footer-link text-gray-300 hover:text-white text-sm">Ketentuan Pengguna</a></li>
                                    <li><a href="#" class="footer-link text-gray-300 hover:text-white text-sm">Pusat Bantuan</a></li>
                                </ul>
                            </div>

                            <!-- Contact Us -->
                            <div>
                                <h3 class="font-semibold text-lg mb-4 text-white">Contact Us</h3>
                                <ul class="space-y-2">
                                    <li><a href="https://wa.me/6285363483996" target="_blank" class="footer-link text-gray-300 hover:text-white text-sm">WhatsApp</a></li>
                                    <li><a href="https://instagram.com/cantigitours_" target="_blank" class="footer-link text-gray-300 hover:text-white text-sm">Instagram</a></li>
                                    <li><a href="https://facebook.com/Cantigi Tours" target="_blank" class="footer-link text-gray-300 hover:text-white text-sm">Facebook</a></li>
                                    <li><a href="https://www.tiktok.com/@putra_putt_" target="_blank" class="footer-link text-gray-300 hover:text-white text-sm">TikTok</a></li>
                                </ul>
                            </div>

                            <!-- Lainnya -->
                            <div>
                                <h3 class="font-semibold text-lg mb-4 text-white">Lainnya</h3>
                                <ul class="space-y-2">
                                    <li><a href="#" class="footer-link text-gray-300 hover:text-white text-sm">Syarat & Ketentuan</a></li>
                                    <li><a href="#" class="footer-link text-gray-300 hover:text-white text-sm">Rating & Ulasan</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-800 my-8"></div>

                <!-- Bottom Section -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <p class="text-gray-400 text-sm">
                        &copy; 2025 PT. Cantigi Tours International. Semua hak cipta dilindungi.
                    </p>
                    
                    <div class="flex items-center space-x-6">
                        <a href="https://wa.me/6285363483996" target="_blank" class="social-link text-gray-400 hover:text-green-400 text-xl">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://instagram.com/cantigitours_" target="_blank" class="social-link text-gray-400 hover:text-pink-400 text-xl">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://facebook.com/Cantigi Tours" target="_blank" class="social-link text-gray-400 hover:text-blue-400 text-xl">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="https://www.tiktok.com/@putra_putt_" target="_blank" class="social-link text-gray-400 hover:text-gray-200 text-xl">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Layout (below md) - Apple Style Collapsible -->
        <div class="md:hidden">
            <div class="px-4 py-6">
                <!-- Brand Section - Always Visible -->
                <div class="text-center mb-6">
                    <a href="#" class="inline-block">
                        <div class="flex items-center justify-center space-x-3 mb-3">
                            <div class="flex items-center space-x-2 mb-4 md:mb-0">
                                  <img src="{{ asset('images/logo/logo.png') }}" alt="CantigiTours Logo" class="w-10 md:w-12 lg:w-16">
                                </div>
                            <h1 class="logo font-bold text-xl">Cantigi Tours</h1>
                        </div>
                    </a>
                </div>

                <!-- Collapsible Sections -->
                <div class="space-y-0">
                    <!-- Informasi Section -->
                    <div class="footer-section py-3">
                        <div class="section-toggle flex justify-between items-center" onclick="toggleSection('informasi')">
                            <h3 class="font-medium text-base text-white">Informasi</h3>
                            <i class="fas fa-chevron-down chevron text-gray-400 text-sm" id="chevron-informasi"></i>
                        </div>
                        <div class="section-content" id="content-informasi">
                            <ul class="space-y-2">
                                <li><a href="#" class="footer-link text-gray-300 hover:text-white text-sm block py-1">Tentang Kami</a></li>
                                <li><a href="#" class="footer-link text-gray-300 hover:text-white text-sm block py-1">Hubungi Kami</a></li>
                                <li><a href="#" class="footer-link text-gray-300 hover:text-white text-sm block py-1">Kebijakan Privasi</a></li>
                                <li><a href="#" class="footer-link text-gray-300 hover:text-white text-sm block py-1">Ketentuan Pengguna</a></li>
                                <li><a href="#" class="footer-link text-gray-300 hover:text-white text-sm block py-1">Pusat Bantuan</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Contact Us Section -->
                    <div class="footer-section py-3">
                        <div class="section-toggle flex justify-between items-center" onclick="toggleSection('contact')">
                            <h3 class="font-medium text-base text-white">Contact Us</h3>
                            <i class="fas fa-chevron-down chevron text-gray-400 text-sm" id="chevron-contact"></i>
                        </div>
                        <div class="section-content" id="content-contact">
                            <ul class="space-y-2">
                                <li><a href="https://wa.me/6285363483996" target="_blank" class="footer-link text-gray-300 hover:text-white text-sm block py-1">WhatsApp</a></li>
                                <li><a href="https://instagram.com/cantigitours_" target="_blank" class="footer-link text-gray-300 hover:text-white text-sm block py-1">Instagram</a></li>
                                <li><a href="https://facebook.com/Cantigi Tours" target="_blank" class="footer-link text-gray-300 hover:text-white text-sm block py-1">Facebook</a></li>
                                <li><a href="https://www.tiktok.com/@putra_putt_" target="_blank" class="footer-link text-gray-300 hover:text-white text-sm block py-1">TikTok</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Lainnya Section -->
                    <div class="footer-section py-3">
                        <div class="section-toggle flex justify-between items-center" onclick="toggleSection('lainnya')">
                            <h3 class="font-medium text-base text-white">Lainnya</h3>
                            <i class="fas fa-chevron-down chevron text-gray-400 text-sm" id="chevron-lainnya"></i>
                        </div>
                        <div class="section-content" id="content-lainnya">
                            <ul class="space-y-2">
                                <li><a href="#" class="footer-link text-gray-300 hover:text-white text-sm block py-1">Syarat & Ketentuan</a></li>
                                <li><a href="#" class="footer-link text-gray-300 hover:text-white text-sm block py-1">Rating & Ulasan</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Social Media Icons - Always Visible on Mobile -->
                <div class="flex justify-center space-x-6 mt-6 mb-4">
                    <a href="https://wa.me/6285363483996" target="_blank" class="social-link text-gray-400 hover:text-green-400 text-2xl">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="https://instagram.com/cantigitours_" target="_blank" class="social-link text-gray-400 hover:text-pink-400 text-2xl">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://facebook.com/Cantigi Tours" target="_blank" class="social-link text-gray-400 hover:text-blue-400 text-2xl">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://www.tiktok.com/@putra_putt_" target="_blank" class="social-link text-gray-400 hover:text-gray-200 text-2xl">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>

                <!-- Copyright - Mobile -->
                <div class="text-center pt-4 border-t border-gray-800">
                    <p class="text-gray-400 text-xs leading-relaxed">
                        &copy; 2025 PT. Cantigi Tours International.<br>
                        Semua hak cipta dilindungi.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Script Responsive on mobile -->
    <script>
        function toggleSection(sectionId) {
            // Only work on mobile
            if (window.innerWidth >= 768) return;
            
            const content = document.getElementById(`content-${sectionId}`);
            const chevron = document.getElementById(`chevron-${sectionId}`);
            
            if (content.classList.contains('open')) {
                content.classList.remove('open');
                chevron.classList.remove('open');
            } else {
                // Close all other sections first (accordion behavior)
                const allContents = document.querySelectorAll('.section-content');
                const allChevrons = document.querySelectorAll('.chevron');
                
                allContents.forEach(c => c.classList.remove('open'));
                allChevrons.forEach(c => c.classList.remove('open'));
                
                // Open clicked section
                content.classList.add('open');
                chevron.classList.add('open');
            }
        }

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                // Reset mobile states when switching to desktop
                const allContents = document.querySelectorAll('.section-content');
                const allChevrons = document.querySelectorAll('.chevron');
                
                allContents.forEach(c => c.classList.remove('open'));
                allChevrons.forEach(c => c.classList.remove('open'));
            }
        });

        // Smooth scroll behavior for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</div>
