<header class="w-full bg-white shadow-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row items-center justify-between py-3">
      <!-- Logo and Brand -->
      <div class="flex items-center space-x-2 mb-4 md:mb-0">
        <img src="{{ asset('images/LOGOFIX.png') }}" alt="CantigiTours Logo" class="w-10 md:w-12 lg:w-16">
        <h1 class="font-bold text-xl sm:text-2xl lg:text-3xl">CantigiTours</h1>
      </div>
      
      <!-- Mobile Menu Button -->
      <button id="menu-toggle" class="md:hidden absolute top-4 right-4 text-gray-800">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
      
      <!-- Navigation and Buttons - Hidden on Mobile by Default -->
      <div id="mobile-menu" class="hidden md:flex flex-col md:flex-row items-center w-full md:w-auto space-y-4 md:space-y-0">
        <!-- Navigation Links -->
        <nav class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4 lg:space-x-8 text-gray-800 font-medium text-base sm:text-lg lg:text-xl w-full md:w-auto text-center md:text-left mb-4 md:mb-0 md:mr-4">
          <a href="#" class="hover:text-green-500 py-1">Home</a>
          <a href="#" class="hover:text-green-500 py-1">Kendaraan</a>
          <a href="#" class="hover:text-green-500 py-1">About Us</a>
        </nav>
        
        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 md:space-x-4 text-sm sm:text-base lg:text-lg w-full sm:w-auto">
          <button class="border border-green-500 text-green-500 px-3 py-1 rounded-md hover:bg-green-500 hover:text-white transition">
            Log In
          </button>
          <button class="border bg-[#138A40] text-white px-3 py-1 rounded-md hover:bg-green-800 hover:text-white transition">
            Sign Up
          </button>
        </div>
      </div>
    </div>
  </div>
</header>
