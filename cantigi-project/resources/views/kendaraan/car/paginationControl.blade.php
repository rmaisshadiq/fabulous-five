 <!-- PAGINATION CONTROLS -->
  <div class="flex justify-center items-center py-8 space-x-4">
    <button id="prevBtn" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center gap-2 disabled:bg-gray-400 disabled:cursor-not-allowed disabled:transform-none">
      <i class="fa fa-chevron-left"></i>
      Sebelumnya
    </button>

    <!-- Page Indicators -->
    <div class="flex space-x-2" id="pageIndicators">
      <!-- Will be populated by JavaScript -->
    </div>

    <button id="nextBtn" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center gap-2 disabled:bg-gray-400 disabled:cursor-not-allowed disabled:transform-none">
      Berikutnya
      <i class="fa fa-chevron-right"></i>
    </button>
  </div>

  <!-- Page Info -->
  <div class="text-center pb-8">
    <span class="text-gray-600 font-medium">
      Halaman <span id="currentPageInfo">1</span> dari <span id="totalPagesInfo">4</span>
    </span>
  </div>