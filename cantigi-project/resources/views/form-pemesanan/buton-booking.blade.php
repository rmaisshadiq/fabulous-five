      <!-- Button booking -->
    <div class="text-center">
      <button class="w-full p-4 rounded-xl bg-gradient-to-r from-green-700 to-green-500 hover:from-green-600 hover:to-green-700 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-green-500/40 relative overflow-hidden group">
        <div class="flex items-center justify-center text-white font-bold text-lg relative z-10">
          <i class="fas fa-calendar-check mr-3"></i>
          <span><a href="{{ route('detail-pemesanan') }}">Booking Sekarang</a></span>
          <i class="fa fa-arrow-right ml-3 transition-transform duration-300 group-hover:translate-x-1"></i>
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-500"></div>
      </button>
    </div>