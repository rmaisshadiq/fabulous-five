 <!-- Opsi rental -->
   <div class="mb-8">
  <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
    Pilih Paket Rental
  </h3>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <label class="option-card p-4 rounded-xl cursor-pointer block border border-gray-300 hover:border-green-500 transition" onclick="selectOption(this)">
      <input type="radio" name="rental-option" value="tanpa-supir" class="hidden">
      <div class="flex items-center">
        <div>
          <p class="font-semibold">Tanpa Supir</p>
          <p class="text-sm">Lepas kunci</p>
        </div>
      </div>
    </label>
    
    <label class="option-card p-4 rounded-xl cursor-pointer block border border-gray-300 hover:border-green-500 transition" onclick="selectOption(this)">
      <input type="radio" name="rental-option" value="dengan-supir" class="hidden">
      <div class="flex items-center">
        <div>
          <p class="font-semibold">Dengan Supir</p>
          <p class="text-sm">Termasuk driver</p>
        </div>
      </div>
    </label>
  </div>
</div>