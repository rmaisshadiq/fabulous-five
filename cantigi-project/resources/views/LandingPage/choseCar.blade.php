<div class="rental-kendaraan mt-[100px]">
    <!-- header -->
    <div class="flex justify-center items-center ">
        <h1 class="text-center font-semibold text-[36px]">Pilih Kendaraanmu</h1>
    </div>
</div>

<!-- Images -->
<div class="images flex justify-center gap-[10rem] flex-wrap mt-[100px]">

    <!-- Card 1 -->
    <div class="bg-white rounded-3xl flex flex-col items-center text-[24px]">
        <div
            class="bg-green-500 w-[300px] h-[300px] rounded-tl-[90px] rounded-bl-[30px] rounded-tr-[30px] rounded-br-[90px] flex items-center justify-center overflow-hidden shadow-lg">
            <img class="w-[300px] h-[300px] object-cover" src="{{ asset('images/BUS.png') }}"
                alt="Bus">
        </div>
        <div class="p-4 flex flex-col items-center">
            <h1 class="font-semibold">BUS</h1>
            <button class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition mt-4">
                Sewa Sekarang
            </button>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="bg-white rounded-3xl flex flex-col items-center text-[24px]">
        <div
            class="bg-green-500 w-[300px] h-[300px] rounded-tl-[90px] rounded-bl-[30px] rounded-tr-[30px] rounded-br-[90px] flex items-center justify-center overflow-hidden shadow-lg">
            <img class="w-full h-48 object-cover" src="{{ asset('images/car.png') }}" alt="Mobil">
        </div>
        <div class="p-4 flex flex-col items-center">
            <h1 class="font-semibold">MOBIL</h1>
            <button class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition mt-4">
                Sewa Sekarang
            </button>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="bg-white rounded-3xl flex flex-col items-center text-[24px]">
        <div
            class="bg-green-500 w-[300px] h-[300px] rounded-tl-[90px] rounded-bl-[30px] rounded-tr-[30px] rounded-br-[90px] flex items-center justify-center overflow-hidden shadow-lg">
            <img class="w-full h-full object-cover" src="{{ asset('images/MotorCycles.png') }}" alt="Motor">
        </div>
        <div class="p-4 flex flex-col items-center">
            <h1 class=" font-semibold mt-2">MOTOR</h1>
            <button class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition mt-4">
                Sewa Sekarang
            </button>
        </div>
    </div>

</div>