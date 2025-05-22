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