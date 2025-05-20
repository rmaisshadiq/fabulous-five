import './bootstrap';

  const toggleBtn = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');

  toggleBtn.addEventListener('click', () => {
    const isOpen = mobileMenu.classList.contains('scale-y-100');
    
    mobileMenu.classList.toggle('scale-y-100', !isOpen);
    mobileMenu.classList.toggle('scale-y-0', isOpen);
    toggleBtn.setAttribute('aria-expanded', String(!isOpen));
  });
