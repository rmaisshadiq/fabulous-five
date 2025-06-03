<!-- Enhanced Header -->
<header class="bg-white shadow-lg sticky top-0 z-50 transition-all duration-300">
  <div class="container mx-auto px-6 lg:px-8">
    <div class="flex items-center justify-between py-4">
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

      <!-- Navigation -->
      <nav class="hidden md:flex space-x-8 text-gray-700 font-medium">
        <a href="{{ route('home') }}" class="hover:text-green-600 transition-colors duration-300 relative group">
          Home
          <span
            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-green-600 transition-all duration-300 group-hover:w-full"></span>
        </a>
        <a href="{{ route('kendaraan') }}" class="hover:text-green-600 transition-colors duration-300 relative group">
          Kendaraan
          <span
            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-green-600 transition-all duration-300 group-hover:w-full"></span>
        </a>
        <a href="{{ route('about-us') }}" class="hover:text-green-600 transition-colors duration-300 relative group">
          Tentang Kami
          <span
            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-green-600 transition-all duration-300 group-hover:w-full"></span>
        </a>
      </nav>

      <!-- CTA Buttons -->
      @auth
      {{-- Menu Profil jika telah log in --}}
    @else
      <div class="flex space-x-3">
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
    </div>
  </div>
</header>