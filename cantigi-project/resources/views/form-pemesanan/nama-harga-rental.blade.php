 <!-- Nama dan harga rental -->
    <div class="flex justify-between items-center mb-8 p-6 bg-gray-100 rounded-2xl">
      <div class="flex items-center">
        <div>
          <p class="text-xl font-bold text-gray-800">{{ $vehicles->brand }} {{ $vehicles->model }}</p>
          <p class="text-sm text-gray-500">{{ $vehicles->car_type }}</p>
        </div>
      </div>
      <div class="text-right">
        <p class="text-2xl font-bold price-tag">{{ $vehicles->price_per_day }}</p>
        <p class="text-sm text-gray-500">per hari</p>
      </div>
    </div>