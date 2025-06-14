
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    screens: {
                        'xs': '475px',
                    }
                }
            }
        }
    </script>

<section class="relative overflow-hidden min-h-screen py-8 xs:py-10 md:py-16 mt-8">   
  <div class="container mx-auto px-4 xs:px-4 md:px-4 flex flex-col md:flex-row items-center justify-between gap-6 xs:gap-8 md:gap-16 relative z-10">          
    <!-- Konten Teks -->     
    <div class="w-full md:w-1/2 space-y-3 xs:space-y-4 md:space-y-5 text-center md:text-left">       
      <h2 class="text-xl xs:text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-tight text-black px-2 xs:px-0">         
        Sewa Kendaraan<br class="hidden xs:block">         
        Dengan <span class="text-[#138A40] block xs:inline">Mudah <span class="text-black">&</span> Cepat</span>       
      </h2>       
      <p class="text-gray-600 text-sm xs:text-base sm:text-lg md:text-xl max-w-xs xs:max-w-md mx-auto md:mx-0 px-2 xs:px-0">         
        Rental Kendaraan Termurah Dan Proses Yang Gak Ribet Hanya Di Cantigi Tours.       
      </p>       
      <div class="pt-2">         
        <a href="{{ route('kendaraan') }}" class="inline-block w-9rem] xs:w-auto bg-[#138A40] text-white px-6 xs:px-8 py-3 xs:py-4 rounded-md hover:bg-green-800 transition duration-300 text-sm xs:text-base font-medium">             
          Sewa Sekarang           
        </a>       
      </div>     
    </div>      

    <!-- Gambar Mobil - Mobile Version -->
    <div class="block md:hidden w-full relative mt-6 xs:mt-8">
      <div class="relative w-full flex items-center justify-center bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-4 xs:p-6 sm:p-8">
        <img            
          src="{{ asset('images/imgUtama/car.png') }}"            
          alt="Car"            
          class="w-full max-w-[280px] xs:max-w-[320px] sm:max-w-[400px] h-auto object-contain transform scale-x-[-1]">       
      </div>
      <!-- Mobile decorative shape -->
      <div class="absolute -top-4 -right-4 w-20 h-20 bg-[#138A40] rounded-full opacity-20"></div>
      <div class="absolute -bottom-6 -left-6 w-16 h-16 bg-[#138A40] rounded-full opacity-15"></div>
    </div>

    <!-- Gambar Mobil - Desktop Version -->     
    <div class="hidden md:block w-full md:w-1/2 relative">       
      <div class="relative w-full h-full flex items-center justify-center">         
        <img            
          src="{{ asset('images/imgUtama/car.png') }}"           
          alt="Car"            
          class="w-[60rem] sm:h-full md:w-full lg:w-full xl:w-full 2xl:w-full object-contain transform scale-x-[-1] mt-[10%]">       
      </div>     
    </div>   
  </div>    

  <!-- Shape Background - Desktop -->   
  <div class="hidden md:block absolute inset-y-0 right-0 w-1/2 mt-16 h-[90%] sm:h-[50%] md:h-[40%] md:mt-44 lg:h-[60%] lg:mt-24 xl:h-[60%] 2xl:h-[70%] bg-[#138A40] z-0 rounded-tl-[20vw] rounded-bl-[5vw]">   
  </div>

  <!-- Mobile Background Decorations -->
  <div class="block md:hidden absolute inset-0 overflow-hidden pointer-events-none">
    <!-- Top right circle -->
    <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#138A40] rounded-full opacity-10"></div>
    <!-- Bottom left circle -->
    <div class="absolute -bottom-16 -left-16 w-40 h-40 bg-[#138A40] rounded-full opacity-5"></div>
    <!-- Center decoration -->
    <div class="absolute top-1/2 left-1/4 w-6 h-6 bg-[#138A40] rounded-full opacity-20 transform -translate-y-1/2"></div>
    <div class="absolute top-1/3 right-1/4 w-4 h-4 bg-[#138A40] rounded-full opacity-15"></div>
  </div>
</section>