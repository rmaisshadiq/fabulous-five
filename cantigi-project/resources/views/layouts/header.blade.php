<!-- Enhanced Header -->
<header class="bg-white shadow-lg sticky top-0 z-50 transition-all duration-300">
  <div class="container mx-auto px-6 lg:px-8">
    <div class="flex items-center justify-between py-4">
      <a href="{{ route('home') }}">
        <!-- Logo Section -->
        <div class="flex items-center space-x-3">
          <!-- Logo -->
          <div class="flex items-center space-x-2 mb-4 md:mb-0">
            <img src="{{ asset('images/logo/LOGOFIX.png') }}" alt="CantigiTours Logo" class="w-10 md:w-12 lg:w-16">
          </div>
          <div>
            <h1 class="font-bold text-2xl lg:text-3xl text-gray-800">CantigiTours</h1>
            <p class="text-xs text-gray-500 hidden sm:block">Come and Find Your Story</p>
          </div>
        </div>
      </a>

      <!-- Desktop Navigation -->
      <nav class="hidden md:flex space-x-8 text-gray-700 font-medium">
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

      <!-- Desktop CTA Buttons & Mobile Burger Container -->
      <div class="flex items-center space-x-4">
        <!-- CTA Buttons -->
        @auth
        {{-- Menu Profil jika telah log in --}}
        <!-- Settings Dropdown -->
        <div class="hidden sm:flex sm:items-center sm:ms-6">
        <x-dropdown align="right" width="60" class="z-50">
          <x-slot name="trigger">
          <button
            class="group inline-flex items-center gap-3 px-4 py-2.5 border border-gray-200 text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 ease-in-out shadow-sm hover:shadow-md">
            <!-- User Avatar -->
            <div class="relative">
            @if(Auth::user()->profile_image)
          <!-- Profile Image -->
          <img src="{{ Auth::user()->profile_image_url }}" alt="{{ Auth::user()->name }}"
          class="h-8 w-8 rounded-full object-cover ring-2 ring-white shadow-sm"
          onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
          <!-- Fallback Avatar (hidden by default) -->
          <div
          class="h-8 w-8 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white font-semibold text-sm ring-2 ring-white shadow-sm"
          style="display: none;">
          {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
          </div>
        @else
          <!-- Default Avatar -->
          <div
          class="h-8 w-8 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white font-semibold text-sm ring-2 ring-white shadow-sm">
          {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
          </div>
        @endif

            <!-- Online Status Indicator -->
            <div class="absolute -bottom-0.5 -right-0.5 h-3 w-3 bg-green-400 border-2 border-white rounded-full">
            </div>
            </div>

            <!-- User Name -->
            <div class="flex items-center gap-2">
            <span class="text-gray-900 font-medium truncate max-w-32">
              {{ Auth::user()->name }}
            </span>

            <!-- Dropdown Arrow -->
            <svg
              class="h-4 w-4 text-gray-400 group-hover:text-gray-600 transition-all duration-200 transform group-hover:rotate-180"
              xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
            </div>
          </button>
          </x-slot>

          <x-slot name="content">
          <!-- User Info Header -->
          <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
            <div class="flex items-center gap-3">
            @if(Auth::user()->profile_image)
          <!-- Profile Image -->
          <img src="{{ Auth::user()->profile_image_url }}" alt="{{ Auth::user()->name }}"
          class="h-10 w-10 rounded-full object-cover ring-2 ring-white shadow-sm"
          onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
          <!-- Fallback Avatar (hidden by default) -->
          <div
          class="h-10 w-10 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white font-semibold ring-2 ring-white shadow-sm"
          style="display: none;">
          {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
          </div>
        @else
          <!-- Default Avatar -->
          <div
          class="h-10 w-10 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white font-semibold ring-2 ring-white shadow-sm">
          {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
          </div>
        @endif

            <div>
              <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
              <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
            </div>
            </div>
          </div>

          <!-- Menu Items -->
          <div class="py-1">
            <x-dropdown-link :href="route('profile.edit')"
            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-green-700 transition-colors duration-150">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            {{ __('Profile') }}
            </x-dropdown-link>

            <!-- Divider -->
            <div class="border-t border-gray-100 my-1"></div>

            <!-- Admin Panel -->
            @if (auth()->user()->hasRole('super_admin'))
          <x-dropdown-link :href="route('filament.admin.pages.dashboard')"
          class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-green-700 transition-colors duration-150">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
          <path fill-rule="evenodd"
          d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z"
          clip-rule="evenodd" />
          </svg>
          {{ __('Admin Panel')}}
          </x-dropdown-link>

          <!-- Divider -->
          <div class="border-t border-gray-100 my-1"></div>
        @endif

          <!-- Order history -->
            @if (auth()->user()->hasRole('super_admin'))
          <x-dropdown-link :href="route('order-history')"
          class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-green-700 transition-colors duration-150">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
          <path fill-rule="evenodd"
          d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z"
          clip-rule="evenodd" />
          </svg>
          {{ __('Order History')}}
          </x-dropdown-link>

          <!-- Divider -->
          <div class="border-t border-gray-100 my-1"></div>
        @endif

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-dropdown-link :href="route('logout')"
              onclick="event.preventDefault(); this.closest('form').submit();"
              class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors duration-150">
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
              </svg>
              {{ __('Log Out') }}
            </x-dropdown-link>
            </form>
          </div>
          </x-slot>
        </x-dropdown>
        </div>
      @else
        <div class="hidden md:flex space-x-3">
        <a href="{{ route('login') }}"
          class="hidden sm:block border border-green-500 text-green-600 px-6 py-2 rounded-lg hover:bg-green-100 transition-all duration-300 font-medium">
          Masuk
        </a>
        <a href="{{ route('register') }}"
          class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-300 font-medium shadow-lg hover:shadow-xl">
          Daftar
        </a>
        </div>
      @endauth

      <!-- Mobile Burger Menu Button -->
      <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all duration-200">
        <svg id="burger-icon" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <svg id="close-icon" class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div id="mobile-menu" class="md:hidden border-t border-gray-100 bg-white shadow-lg transform transition-all duration-300 ease-in-out max-h-0 overflow-hidden opacity-0">
      <div class="px-6 py-4 space-y-4">
        <!-- Mobile Navigation Links -->
        <div class="space-y-3">
          <a href="{{ route('home') }}" class="block text-gray-700 hover:text-green-600 font-medium py-2 px-3 rounded-lg hover:bg-green-50 transition-all duration-200 {{ request()->routeIs('home') ? 'text-green-600 bg-green-50' : '' }}">
            Home
          </a>
          <a href="{{ route('kendaraan') }}" class="block text-gray-700 hover:text-green-600 font-medium py-2 px-3 rounded-lg hover:bg-green-50 transition-all duration-200 {{ request()->routeIs('kendaraan') ? 'text-green-600 bg-green-50' : '' }}">
            Kendaraan
          </a>
          <a href="{{ route('about-us') }}" class="block text-gray-700 hover:text-green-600 font-medium py-2 px-3 rounded-lg hover:bg-green-50 transition-all duration-200 {{ request()->routeIs('about-us') ? 'text-green-600 bg-green-50' : '' }}">
            Tentang Kami
          </a>
        </div>

        <!-- Mobile Authentication Section -->
        @auth
          <!-- Mobile Profile Section -->
          <div class="pt-4 border-t border-gray-100">
            <div class="flex items-center gap-3 mb-4 p-3 bg-gray-50 rounded-lg">
              @if(Auth::user()->profile_image)
                <!-- Profile Image -->
                <img src="{{ Auth::user()->profile_image_url }}" alt="{{ Auth::user()->name }}"
                class="h-10 w-10 rounded-full object-cover ring-2 ring-white shadow-sm"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <!-- Fallback Avatar (hidden by default) -->
                <div
                class="h-10 w-10 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white font-semibold ring-2 ring-white shadow-sm"
                style="display: none;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
              @else
                <!-- Default Avatar -->
                <div
                class="h-10 w-10 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white font-semibold ring-2 ring-white shadow-sm">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
              @endif
              <div>
                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
              </div>
            </div>
            
            <div class="space-y-2">
              <a href="{{ route('profile.edit') }}" class="block w-full text-left px-3 py-2 text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200">
                Profile
              </a>
              
              @if (auth()->user()->hasRole('super_admin'))
                <a href="{{ route('filament.admin.pages.dashboard') }}" class="block w-full text-left px-3 py-2 text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200">
                  Admin Panel
                </a>
              @endif
              
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-3 py-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-200">
                  Log Out
                </button>
              </form>
            </div>
          </div>
        @else
          <!-- Mobile CTA Buttons -->
          <div class="pt-4 border-t border-gray-100 space-y-3">
            <a href="{{ route('login') }}"
              class="block w-full text-center border border-green-500 text-green-600 py-3 rounded-lg hover:bg-green-100 transition-all duration-300 font-medium">
              Masuk
            </a>
            <a href="{{ route('register') }}"
              class="block w-full text-center bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition-all duration-300 font-medium shadow-lg">
              Daftar
            </a>
          </div>
        @endauth
      </div>
    </div>
  </div>
</header>

<script>
// Mobile Menu Toggle Script
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const burgerIcon = document.getElementById('burger-icon');
    const closeIcon = document.getElementById('close-icon');
    
    let isMenuOpen = false;
    
    mobileMenuButton.addEventListener('click', function() {
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
        link.addEventListener('click', function() {
            if (isMenuOpen) {
                mobileMenuButton.click(); // Trigger the close animation
            }
        });
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const isClickInsideMenu = mobileMenu.contains(event.target);
        const isClickOnButton = mobileMenuButton.contains(event.target);
        
        if (isMenuOpen && !isClickInsideMenu && !isClickOnButton) {
            mobileMenuButton.click(); // Trigger the close animation
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768 && isMenuOpen) {
            // Close mobile menu on desktop view
            mobileMenuButton.click();
        }
    });
});
</script>