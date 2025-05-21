<section class="relative overflow-hidden min-h-screen py-10 md:py-16 mt-[4rem]">
  <!-- Container dengan layout responsif -->
  <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-10 md:gap-16 relative z-10 transition-all duration-500">
    
    <!-- Konten Teks -->
    <div class="w-full md:w-1/2 space-y-5 text-center md:text-left">
      <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-[64px] font-bold leading-tight transition duration-300">
        Sewa Kendaraan<br class="hidden sm:block">
        Dengan <span class="text-green-600 block sm:inline">Mudah <span class="text-black">&</span> Cepat</span>
      </h2>
      <p class="text-gray-600 text-base sm:text-lg md:text-xl lg:text-2xl px-4 sm:px-0 transition duration-300">
        Rental Kendaraan Termurah Dan Proses Yang Gak Ribet Hanya Di Cantigi Tours.
      </p>
      <button class="bg-green-600 text-white px-6 py-2 text-lg sm:text-xl lg:text-2xl rounded-md hover:bg-green-700 transition duration-300 ease-in-out">
        Sewa Sekarang
      </button>
    </div>

    <!-- Gambar Mobil - hanya tampil di md ke atas -->
    <div class="hidden md:block w-full md:w-1/2 relative z-10 transition duration-500">
      <img src="{{ asset('images/car.png') }}" alt="Car" class="w-full lg:max-w-xl md:mt-[150px] md:w-[100rem] xl:max-w-2xl transform scale-x-[-1] object-contain transition duration-300 ease-in-out" />
    </div>
  </div>

  <!-- Shape Background -->
  <div class="hidden md:block absolute right-0 w-[40rem] top-0 bg-[#138A40] rounded-tl-[150px] md:rounded-tl-[200px] lg:rounded-tl-[280px] lg:mt-[150px] rounded-bl-[60px] lg:rounded-bl-[80px] md:w-[50%] lg:w-[40rem] h-[300px] md:h-[400px] md:mt-[68px] lg:h-[500px] transition-all duration-500 ease-in-out z-0">
  </div>
</section>
