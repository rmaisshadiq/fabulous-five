<!-- Opsi rental -->
    <div class="mb-8">
      <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        Pilih Paket Rental
      </h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <label class="bg-gradient-to-r from-green-700 to-green-500 p-4 rounded-xl cursor-pointer block border border-gray-300 hover:border-emerald-500 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-500/30 group" onclick="selectOption(this)">
          <input type="radio" name="rental-option" value="tanpa-supir" class="hidden">
          <div class="flex items-center">
            <div>
              <p class="text-white font-semibold">Tanpa Supir</p>
              <p class="text-emerald-100 text-sm">Lepas kunci</p>
            </div>
          </div>
        </label>
        
        <label class="bg-gradient-to-r from-green-700 to-green-500 p-4 rounded-xl cursor-pointer block border border-gray-300 hover:border-emerald-500 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-500/30 group" onclick="selectOption(this)">
          <input type="radio" name="rental-option" value="dengan-supir" class="hidden">
          <div class="flex items-center">
            <div>
              <p class="text-white font-semibold">Dengan Supir</p>
              <p class="text-emerald-100 text-sm">Termasuk driver</p>
            </div>
          </div>
        </label>
      </div>
    </div>