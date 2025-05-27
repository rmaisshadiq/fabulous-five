<!-- HEADER -->
<header class="w-full bg-white shadow-sm fixed top-0 left-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row items-center justify-between py-3">

      <!-- Logo -->
      <div class="flex items-center space-x-2 mb-4 md:mb-0">
        <img src="{{ asset('images/logo/LOGOFIX.png') }}" alt="CantigiTours Logo" class="w-10 md:w-12 lg:w-16">
        <h1 class="font-bold text-xl sm:text-2xl lg:text-3xl">CantigiTours</h1>
      </div>

      <!-- Mobile Menu Toggle -->
      <button id="menu-toggle" aria-expanded="false"
        class="md:hidden absolute top-4 right-4 text-gray-800 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform duration-300 ease-in-out"
          fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <!-- NAVIGATION -->
      <div id="mobile-menu"
        class="transition-all duration-300 ease-in-out transform scale-y-0 origin-top md:scale-y-100 md:transform-none md:flex flex-col md:flex-row items-start md:items-center w-full md:w-auto space-y-4 md:space-y-0 md:space-x-4 lg:space-x-8 absolute md:static top-full left-0 bg-white md:bg-transparent shadow-md md:shadow-none px-4 md:px-0 py-4 md:py-0 z-40">

        <!-- Nav Links -->
        <nav
          class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4 lg:space-x-8 text-gray-800 font-medium text-base sm:text-lg lg:text-xl w-full md:w-auto text-left">
          <a href="{{ route('home') }}" class="hover:text-green-500 py-1 transition-colors duration-200">Home</a>
          <a href="{{ route('kendaraan') }}"
            class="hover:text-green-500 py-1 transition-colors duration-200">Kendaraan</a>
          <a href="#" class="hover:text-green-500 py-1 transition-colors duration-200">About Us</a>
        </nav>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 md:space-x-4 text-sm sm:text-base lg:text-lg w-full sm:w-auto text-center sm:text-left">
          <a href="{{ route('login') }}" class="w-full sm:w-auto border border-green-500 text-green-500 px-3 py-2 rounded-md hover:bg-green-500 hover:text-white transition duration-300">
            Log In
          </a>
          <a href="{{ route('register') }}" class="w-full sm:w-auto bg-[#138A40] text-white px-3 py-2 rounded-md hover:bg-green-800 transition duration-300">
            Sign Up
          </a>
        </div>
      </div>
    </div>
  </div>
</header>