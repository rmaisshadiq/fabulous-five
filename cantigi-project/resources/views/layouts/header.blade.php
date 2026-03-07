<!-- Enhanced Header -->
<header class="bg-white shadow-lg sticky top-0 z-50 transition-all duration-300">
  <div class="container mx-auto px-6 lg:px-8">
    <div class="relative flex items-center justify-between py-4">
      <a href="{{ route('home') }}">
        <div class="flex items-center space-x-3">
          <div class="flex items-center space-x-2 mb-4 md:mb-0">
            <img src="{{ asset('images/logo/LOGOFIX.png') }}" alt="CantigiTours Logo" class="w-10 md:w-12 lg:w-16">
          </div>
          <div>
            <h1 class="font-bold text-2xl lg:text-3xl text-gray-800">CantigiTours</h1>
            <p class="text-xs text-gray-500 hidden sm:block">Come and Find Your Story</p>
          </div>
        </div>
      </a>

      <nav class="hidden md:flex absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 space-x-8 text-gray-700 font-medium">
        <a href="{{ route('home') }}" class="hover:text-green-600 transition-colors duration-300 relative group
                {{ request()->routeIs('home') ? 'text-green-600' : '' }}">
          Home
          <span class="absolute -bottom-1 left-0 h-0.5 bg-green-600 transition-all duration-300 
                       {{ request()->routeIs('home') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
        </a>

        <a href="{{ route('kendaraan') }}" class="hover:text-green-600 transition-colors duration-300 relative group
                {{ request()->routeIs('kendaraan') ? 'text-green-600' : '' }}">
          Kendaraan
          <span class="absolute -bottom-1 left-0 h-0.5 bg-green-600 transition-all duration-300 
                       {{ request()->routeIs('kendaraan') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
        </a>

        <a href="{{ route('about-us') }}" class="hover:text-green-600 transition-colors duration-300 relative group
                {{ request()->routeIs('about-us') ? 'text-green-600' : '' }}">
          Tentang Kami
          <span class="absolute -bottom-1 left-0 h-0.5 bg-green-600 transition-all duration-300 
                       {{ request()->routeIs('about-us') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
        </a>
      </nav>

      <div class="flex items-center space-x-4">
        <button id="mobile-menu-button"
          class="md:hidden p-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all duration-200">
          <svg id="burger-icon" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <svg id="close-icon" class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>

    <div id="mobile-menu"
      class="md:hidden border-t border-gray-100 bg-white shadow-lg transform transition-all duration-300 ease-in-out max-h-0 overflow-hidden opacity-0">
      <div class="px-6 py-4 space-y-4">
        <div class="space-y-3">
          <a href="{{ route('home') }}"
            class="block text-gray-700 hover:text-green-600 font-medium py-2 px-3 rounded-lg hover:bg-green-50 transition-all duration-200 {{ request()->routeIs('home') ? 'text-green-600 bg-green-50' : '' }}">
            Home
          </a>
          <a href="{{ route('kendaraan') }}"
            class="block text-gray-700 hover:text-green-600 font-medium py-2 px-3 rounded-lg hover:bg-green-50 transition-all duration-200 {{ request()->routeIs('kendaraan') ? 'text-green-600 bg-green-50' : '' }}">
            Kendaraan
          </a>
          <a href="{{ route('about-us') }}"
            class="block text-gray-700 hover:text-green-600 font-medium py-2 px-3 rounded-lg hover:bg-green-50 transition-all duration-200 {{ request()->routeIs('about-us') ? 'text-green-600 bg-green-50' : '' }}">
            Tentang Kami
          </a>
        </div>
      </div>
    </div>
  </div>
</header>

<script>
  // Mobile Menu Toggle Script
  document.addEventListener('DOMContentLoaded', function () {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const burgerIcon = document.getElementById('burger-icon');
    const closeIcon = document.getElementById('close-icon');

    let isMenuOpen = false;

    mobileMenuButton.addEventListener('click', function () {
      isMenuOpen = !isMenuOpen;

      if (isMenuOpen) {
        // Show menu
        mobileMenu.style.maxHeight = mobileMenu.scrollHeight + 'px';
        mobileMenu.classList.remove('opacity-0');
        mobileMenu.classList.add('opacity-100');

        // Switch icons
        burgerIcon.classList.add('hidden');
        closeIcon.classList.remove('hidden');
      } else {
        // Hide menu
        mobileMenu.style.maxHeight = '0px';
        mobileMenu.classList.remove('opacity-100');
        mobileMenu.classList.add('opacity-0');

        // Switch icons
        burgerIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
      }
    });

    // Close menu when clicking on mobile menu links
    const mobileMenuLinks = mobileMenu.querySelectorAll('a');
    mobileMenuLinks.forEach(link => {
      link.addEventListener('click', function () {
        if (isMenuOpen) {
          mobileMenuButton.click(); // Trigger the close animation
        }
      });
    });

    // Close menu when clicking outside
    document.addEventListener('click', function (event) {
      const isClickInsideMenu = mobileMenu.contains(event.target);
      const isClickOnButton = mobileMenuButton.contains(event.target);

      if (isMenuOpen && !isClickInsideMenu && !isClickOnButton) {
        mobileMenuButton.click(); // Trigger the close animation
      }
    });

    // Handle window resize
    window.addEventListener('resize', function () {
      if (window.innerWidth >= 768 && isMenuOpen) {
        // Close mobile menu on desktop view
        mobileMenuButton.click();
      }
    });
  });
</script>