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

        // kode pagination
        class CarPagination {
        constructor() {
        this.currentPage = 0;
        this.totalPages = 4;
        this.slidesContainer = document.getElementById('slidesContainer');
        this.prevBtn = document.getElementById('prevBtn');
        this.nextBtn = document.getElementById('nextBtn');
        this.pageIndicators = document.getElementById('pageIndicators');
        this.currentPageInfo = document.getElementById('currentPageInfo');
        this.totalPagesInfo = document.getElementById('totalPagesInfo');
        
        this.init();
      }
      
      init() {
        this.createPageIndicators();
        this.updateUI();
        this.bindEvents();
      }
      
      createPageIndicators() {
        this.pageIndicators.innerHTML = '';
        for (let i = 0; i < this.totalPages; i++) {
          const indicator = document.createElement('button');
          indicator.className = `w-3 h-3 rounded-full transition-all duration-300 ${
            i === this.currentPage ? 'bg-green-600' : 'bg-gray-300 hover:bg-green-400'
          }`;
          indicator.addEventListener('click', () => this.goToPage(i));
          this.pageIndicators.appendChild(indicator);
        }
      }
      
      bindEvents() {
        this.prevBtn.addEventListener('click', () => this.previousPage());
        this.nextBtn.addEventListener('click', () => this.nextPage());
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
          if (e.key === 'ArrowLeft') this.previousPage();
          if (e.key === 'ArrowRight') this.nextPage();
        });
        
        // Touch/Swipe support
        let startX = 0;
        let endX = 0;
        
        this.slidesContainer.addEventListener('touchstart', (e) => {
          startX = e.touches[0].clientX;
        });
        
        this.slidesContainer.addEventListener('touchend', (e) => {
          endX = e.changedTouches[0].clientX;
          this.handleSwipe();
        });
        
        // Mouse drag support
        let isDragging = false;
        let startMouseX = 0;
        let endMouseX = 0;
        
        this.slidesContainer.addEventListener('mousedown', (e) => {
          isDragging = true;
          startMouseX = e.clientX;
          this.slidesContainer.style.cursor = 'grabbing';
        });
        
        this.slidesContainer.addEventListener('mousemove', (e) => {
          if (!isDragging) return;
          e.preventDefault();
        });
        
        this.slidesContainer.addEventListener('mouseup', (e) => {
          if (!isDragging) return;
          isDragging = false;
          endMouseX = e.clientX;
          this.slidesContainer.style.cursor = 'grab';
          
          const deltaX = startMouseX - endMouseX;
          if (Math.abs(deltaX) > 50) { // Minimum drag distance
            if (deltaX > 0) {
              this.nextPage();
            } else {
              this.previousPage();
            }
          }
        });
        
        this.slidesContainer.addEventListener('mouseleave', () => {
          isDragging = false;
          this.slidesContainer.style.cursor = 'default';
        });
      }
      
      handleSwipe() {
        const deltaX = startX - endX;
        if (Math.abs(deltaX) > 50) { // Minimum swipe distance
          if (deltaX > 0) {
            this.nextPage();
          } else {
            this.previousPage();
          }
        }
      }
      
      goToPage(page) {
        if (page >= 0 && page < this.totalPages && page !== this.currentPage) {
          this.currentPage = page;
          this.updateSlidePosition();
          this.updateUI();
        }
      }
      
      nextPage() {
        if (this.currentPage < this.totalPages - 1) {
          this.currentPage++;
          this.updateSlidePosition();
          this.updateUI();
        }
      }
      
      previousPage() {
        if (this.currentPage > 0) {
          this.currentPage--;
          this.updateSlidePosition();
          this.updateUI();
        }
      }
      
      updateSlidePosition() {
        const translateX = -this.currentPage * 100;
        this.slidesContainer.style.transform = `translateX(${translateX}%)`;
      }
      
      updateUI() {
        // Update navigation buttons
        this.prevBtn.disabled = this.currentPage === 0;
        this.nextBtn.disabled = this.currentPage === this.totalPages - 1;
        
        // Update page indicators
        this.createPageIndicators();
        
        // Update page info
        this.currentPageInfo.textContent = this.currentPage + 1;
        this.totalPagesInfo.textContent = this.totalPages;
      }
    }
    
    // Initialize pagination when DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
      new CarPagination();
    });
