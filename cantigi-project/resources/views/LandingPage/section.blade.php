<section class="relative overflow-hidden min-h-screen py-10 md:py-16 mt-[2rem]">
  <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-16 relative z-10">
    
    <!-- Konten Teks -->
    <div class="w-full md:w-1/2 space-y-5 text-center md:text-left">
      <h2 class="text-3xl text-black sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
        Sewa Kendaraan<br class="hidden sm:block">
        Dengan <span class="text-green-600 block sm:inline">Mudah <span class="text-black">&</span> Cepat</span>
      </h2>
      <p class="text-gray-600 text-base sm:text-lg md:text-xl max-w-md mx-auto md:mx-0">
        Rental Kendaraan Termurah Dan Proses Yang Gak Ribet Hanya Di Cantigi Tours.
      </p>
      <div class="pt-2">
        <button class="bg-green-600 text-white px-6 py-3 text-base sm:text-lg lg:text-xl rounded-md hover:bg-green-700 transition duration-300 ease-in-out shadow-md">
          Sewa Sekarang
        </button>
      </div>
    </div>

    <!-- Gambar Mobil -->
    <div class="hidden md:block w-full md:w-1/2 relative">
      <div class="relative w-full h-full flex items-center justify-center">
        <img 
          src="{{ asset('images/car.png') }}" 
          alt="Car" 
          class="w-[60rem]
                 sm:h-full
                  md:w-full
                  lg:w-full
                  xl:w-full
                  2xl:w-full
                object-contain 
                transform scale-x-[-1]"
          style=" margin-top: 10%;">
      </div>
    </div>
  </div>

  <!-- Shape Background -->
  <div class="hidden 
              md:block 
              absolute 
              inset-y-0 right-0 
              w-1/2
              mt-[4rem] 
              h-[90%]
              sm:h-[50%]
              md:h-[40%]
              md:mt-[11rem]
              lg:h-[60%]
              lg:mt-[6rem]
              xl:h-[60%]
              2xl:h-[70%]
              bg-[#138A40] 
              z-0"
       style="border-top-left-radius: 20vw; border-bottom-left-radius: 5vw;">
  </div>
</section>
