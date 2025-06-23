import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import './bootstrap';


  const toggleBtn = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');

  toggleBtn.addEventListener('click', () => {
    const isOpen = mobileMenu.classList.contains('scale-y-100');
    
    mobileMenu.classList.toggle('scale-y-100', !isOpen);
    mobileMenu.classList.toggle('scale-y-0', isOpen);
    toggleBtn.setAttribute('aria-expanded', String(!isOpen));
  });

   // Script untuk lazy loading gambar
        document.addEventListener("DOMContentLoaded", function() {
            // Deteksi browser support IntersectionObserver
            if ('IntersectionObserver' in window) {
                const images = document.querySelectorAll('.blog-image');
                
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const image = entry.target;
                            // Simulasi lazy loading
                            setTimeout(() => {
                                image.classList.add('lazy-loaded');
                            }, 300);
                            imageObserver.unobserve(image);
                        }
                    });
                });
                
                images.forEach(image => {
                    image.classList.add('lazy-image');
                    imageObserver.observe(image);
                });
            }
            
            // Efek hover untuk tombol Baca Selengkapnya
            const readMoreLinks = document.querySelectorAll('.read-more');
            readMoreLinks.forEach(link => {
                link.addEventListener('mouseenter', () => {
                    const svg = link.querySelector('svg');
                    svg.style.transform = 'translateX(4px)';
                });
                
                link.addEventListener('mouseleave', () => {
                    const svg = link.querySelector('svg');
                    svg.style.transform = 'translateX(0)';
                });
            });
        });

         document.addEventListener('DOMContentLoaded', function() {
            // Ambil tombol "Sewa Sekarang" berdasarkan ID
            const sewaButton = document.getElementById('sewa-button');
            
            if (sewaButton) {
                sewaButton.addEventListener('click', function(e) {
                    e.preventDefault(); // Mencegah default behavior link
                    
                    // Scroll ke atas dengan animasi smooth
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }
            
            // Alternatif: Jika ada beberapa tombol "Sewa Sekarang" lainnya
            const allSewaButtons = document.querySelectorAll('a[href="#top"]');
            allSewaButtons.forEach(button => {
                if (button.textContent.trim() === 'Sewa Sekarang') {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    });
                }
            });
        });
        // 
        // 
        // 
        // 
        // 
        // 
        // 
        // 
        // 
        // 
        // selesai



// public/js/vehicle-slider.js
// js slider
// 
// 
// 
// 
// 
const VehicleSlider = {
    currentSlide: 0,
    totalSlides: 0,
    
    init: function() {
        this.totalSlides = document.querySelectorAll('.slide').length;
        this.showSlide(0);
        
        // Event listeners
        document.addEventListener('DOMContentLoaded', () => {
            this.showSlide(0);
        });
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                this.changeSlide(-1);
            } else if (e.key === 'ArrowRight') {
                this.changeSlide(1);
            }
        });
    },
    
    showSlide: function(slideIndex) {
        // Sembunyikan semua slide
        document.querySelectorAll('.slide').forEach(slide => {
            slide.classList.add('hidden');
            slide.classList.remove('block');
        });
        
        // Tampilkan slide yang dipilih
        const targetSlide = document.querySelector(`[data-slide="${slideIndex}"]`);
        if (targetSlide) {
            targetSlide.classList.remove('hidden');
            targetSlide.classList.add('block');
        }
        
        // Update indicators
        this.updateIndicators(slideIndex);
        
        // Update counter
        this.updateCounter(slideIndex);
        
        // Update button states
        this.updateButtons(slideIndex);
    },
    
    updateIndicators: function(activeIndex) {
        document.querySelectorAll('.slide-indicator').forEach((indicator, index) => {
            if (index === activeIndex) {
                indicator.classList.remove('bg-gray-300');
                indicator.classList.add('bg-green-500');
            } else {
                indicator.classList.remove('bg-green-500');
                indicator.classList.add('bg-gray-300');
            }
        });
    },
    
    updateCounter: function(slideIndex) {
        const counter = document.getElementById('slideCounter');
        if (counter) {
            counter.textContent = slideIndex + 1;
        }
    },
    
    updateButtons: function(slideIndex) {
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        
        if (prevBtn) {
            prevBtn.disabled = slideIndex === 0;
            prevBtn.classList.toggle('opacity-50', slideIndex === 0);
        }
        
        if (nextBtn) {
            nextBtn.disabled = slideIndex === this.totalSlides - 1;
            nextBtn.classList.toggle('opacity-50', slideIndex === this.totalSlides - 1);
        }
    },
    
    changeSlide: function(direction) {
        this.currentSlide += direction;
        
        // Ensure slide index stays within bounds
        if (this.currentSlide < 0) {
            this.currentSlide = 0;
        } else if (this.currentSlide >= this.totalSlides) {
            this.currentSlide = this.totalSlides - 1;
        }
        
        this.showSlide(this.currentSlide);
    },
    
    goToSlide: function(slideIndex) {
        this.currentSlide = slideIndex;
        this.showSlide(this.currentSlide);
    },
    
    // Auto slide functionality (optional)
    startAutoSlide: function(interval = 10000) {
        setInterval(() => {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
            this.showSlide(this.currentSlide);
        }, interval);
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    VehicleSlider.init();
    
    // Uncomment to enable auto-sliding
    // VehicleSlider.startAutoSlide(10000); // 10 seconds
});
// 
// 
// 
// 
// 
//
//
// 
// selesai





