 <!-- Pilih lokasi -->
    <div class="mb-8">
      <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        Lokasi Pengambilan
      </h3>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Opsi: Kantor -->
        <label class="bg-gradient-to-r from-green-700 to-green-500 p-4 rounded-xl cursor-pointer border border-gray-300 hover:border-emerald-500 transition-all duration-300 flex items-center hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-500/30" onclick="selectLocation(this)">
          <input type="radio" name="location-option" value="kantor" class="hidden">
          <div>
            <p class="text-white font-semibold">Kantor Kami</p>
            <p class="text-emerald-100 text-sm">Gratis</p>
          </div>
        </label>

        <!-- Opsi: Lokasi Lain -->
        <label class="bg-gradient-to-r from-green-700 to-green-500 p-4 rounded-xl cursor-pointer border border-gray-300 hover:border-emerald-500 transition-all duration-300 flex items-center hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-500/30" onclick="selectLocation(this)">
          <input type="radio" name="location-option" value="lainnya" class="hidden">
          <div>
            <p class="text-white font-semibold">Lokasi Lainnya</p>
            <p class="text-emerald-100 text-sm">+ Biaya antar</p>
          </div>
        </label>
      </div>

      <!-- Input lokasi kustom -->
      <div id="custom-location-input" class="mt-4 hidden">
        <label class="block text-gray-800 font-semibold mb-2">Masukkan Alamat Anda</label>
        <input type="text" placeholder="Contoh: Jl. by pass"
               class="w-full p-3 rounded-lg bg-white text-gray-800 border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 focus:outline-none transition-all duration-300">
      </div>
    </div>

    <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent my-6"></div>