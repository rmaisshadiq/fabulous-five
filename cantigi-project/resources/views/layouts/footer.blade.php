 <footer class="bg-[#0e0e0e] w-full py-6 xs:py-8 text-white px-4 xs:px-6 sm:px-8 md:px-12 lg:px-16 xl:px-24 2xl:px-36 mt-8">
      <!-- Bagian Atas Footer -->
      <div class="container mx-auto grid grid-cols-1 xs:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 xs:gap-5 mb-6 xs:mb-8">

        <!-- Brand -->
         <a href="#" class="col-span-1 xs:col-span-2 md:col-span-1 lg:col-span-1">
          <div>
            <div class="flex items-center justify-center xs:justify-start space-x-2">
              <img src="{{ asset('images/logo/logo.png') }}" alt="Logo" class="w-8 h-7 xs:w-10 xs:h-9">
              <h1 class="logo font-bold text-xl xs:text-2xl lg:text-[28px]">Cantigi Tours</h1>
            </div>
          </div>
        </a>

        <!-- Spacer - Hidden on mobile -->
        <div class="hidden lg:block"></div>

        <!-- Informasi -->
        <div class="text-center xs:text-left">
          <h1 class="font-semibold text-lg xs:text-xl mb-2">Informasi</h1>
          <ul class="space-y-1 text-sm">
            <li><a href="{{ route('about-us')}}" class="hover:underline">Tentang Kami</a></li>
        <li><a href="{{ route('hubungi-kami')}}" class="hover:underline">Hubungi Kami</a></li>
        <li><a href="{{ route('kebijakan-privasi')}}" class="hover:underline">Kebijakan Privasi</a></li>
        <li><a href="{{ route('ketentuan-pengguna')}}" class="hover:underline">Ketentuan Pengguna</a></li>
        <li><a href="{{ route('pusat-bantuan')}}" class="hover:underline">Pusat Bantuan</a></li>
          </ul>
        </div>

        <!-- Contact Us -->
        <div class="text-center xs:text-left">
          <h1 class="font-semibold text-lg xs:text-xl mb-2">Contact Us</h1>
          <ul class="space-y-1 text-sm">
            <li><a href="https://wa.me/6285363483996" target="_blank" class="hover:underline">WhatsApp</a></li>
            <li><a href="https://instagram.com/cantigitours_" target="_blank" class="hover:underline">Instagram</a></li>
            <li><a href="https://facebook.com/Cantigi Tours" target="_blank" class="hover:underline">Facebook</a></li>
            <li><a href="https://www.tiktok.com/@putra_putt_?_t=ZS-8wt1TIEeaox&_r=1" target="_blank"
                class="hover:underline">TikTok</a></li>
          </ul>
        </div>

        <!-- Lainnya -->
        <div class="text-center xs:text-left col-span-1 xs:col-span-2 md:col-span-1">
          <h1 class="font-semibold text-lg xs:text-xl mb-2">Lainnya</h1>
          <ul class="space-y-1 text-sm">
            <li><a href="{{ route('syarat-ketentuan')}}" class="hover:underline">Syarat & Ketentuan</></li>
          </ul>
        </div>
      </div>

      <hr class="border-gray-200 mb-4">

      <!-- Bagian Bawah Footer -->
      <div class="flex flex-col xs:flex-row justify-between items-center gap-4">
        <p class="text-xs xs:text-sm text-gray-200 text-center xs:text-left order-2 xs:order-1">&copy; 2025 PT.CantigiToursInternational. Semua hak cipta dilindungi.</p>

        <div class="flex gap-4 text-lg xs:text-xl order-1 xs:order-2">
          <a href="https://wa.me/6285363483996" target="_blank" class="hover:text-green-400 transition-colors duration-300"><i class="fa fa-whatsapp"
              aria-hidden="true"></i></a>
          <a href="https://instagram.com/cantigitours_" target="_blank" class="hover:text-pink-400 transition-colors duration-300"><i
              class="fa fa-instagram" aria-hidden="true"></i></a>
          <a href="https://facebook.com/Cantigi Tours" target="_blank" class="hover:text-blue-500 transition-colors duration-300"><i
              class="fa fa-facebook-square" aria-hidden="true"></i></a>
        </div>
      </div>
    </footer>

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