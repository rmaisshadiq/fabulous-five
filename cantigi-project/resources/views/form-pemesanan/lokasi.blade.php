<!-- Pilih lokasi -->
<div class="mb-8">
  <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
    Lokasi Pengambilan
  </h3>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- Opsi: Kantor -->
    <label class="option-card p-4 rounded-xl cursor-pointer border border-gray-300 hover:border-green-500 transition flex items-center" onclick="selectLocation(this)">
      <input type="radio" name="location-option" value="kantor" class="hidden">
      <div>
        <p class="font-semibold">Kantor Kami</p>
        <p class="text-sm">Gratis</p>
      </div>
    </label>

    <!-- Opsi: Lokasi Lain -->
    <label class="option-card p-4 rounded-xl cursor-pointer border border-gray-300 hover:border-green-500 transition flex items-center" onclick="selectLocation(this)">
      <input type="radio" name="location-option" value="lainnya" class="hidden">
      <div>
        <p class="font-semibold">Lokasi Lainnya</p>
        <p class="text-sm">+ Biaya antar</p>
      </div>
    </label>
  </div>

  <!-- Input lokasi kustom -->
  <div id="custom-location-input" class="mt-4 hidden">
    <label class="block black font-semibold mb-2">Masukkan Alamat Anda</label>
    <input type="text" placeholder="Contoh: Jl. by pass"
           class="w-full p-3 rounded-lg bg-gray-200 text-gray-800">
  </div>
</div>

<div class="section-divider"></div>