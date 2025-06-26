
    <style>
        @media (max-width: 640px) {
            .vehicle-card {
                width: 90%;
                margin: 1rem auto;
            }
        }
        
        .vehicle-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .vehicle-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .vehicle-image-container {
            overflow: hidden;
        }
        
        .vehicle-image {
            transition: transform 0.5s ease;
        }
        
        .vehicle-card:hover .vehicle-image {
            transform: scale(1.1);
        }
        
        .btn-sewa {
            transition: all 0.3s ease;
        }
        
        .btn-sewa:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-center items-center mb-6 md:mb-12">
            <h1 class="text-center font-semibold text-2xl sm:text-3xl md:text-4xl lg:text-5xl">Pilih Kendaraanmu</h1>
        </div>
        
        <!-- Vehicle Cards Container -->
        <div class="flex flex-wrap justify-center gap-4 sm:gap-6 md:gap-8 lg:gap-12 mt-4 md:mt-8 lg:mt-12">
            
            <!-- Card 1: BUS -->
            <div class="vehicle-card bg-white rounded-3xl  w-full sm:w-64 md:w-72 lg:w-80 xl:w-96 mb-8">
                <div class="vehicle-image-container bg-[#138A40] rounded-tl-[60px] sm:rounded-tl-[90px] rounded-bl-[20px] sm:rounded-bl-[30px] rounded-tr-[20px] sm:rounded-tr-[30px] rounded-br-[60px] sm:rounded-br-[90px] flex items-center justify-center overflow-hidden shadow-lg">
                    <img class="vehicle-image w-full h-48 sm:h-56 md:h-64 lg:h-72 object-contain p-4" src="{{ asset('images/pilihKendaraan/BUS.png') }}" alt="Bus">
                </div>
                <div class="p-4 flex flex-col items-center">
                    <h2 class="font-semibold text-xl sm:text-2xl">BUS</h2>
                    <a href="{{ route('kendaraan') }}" class="btn-sewa bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition mt-4 text-sm sm:text-base md:text-lg w-full sm:w-auto">
                        Sewa Sekarang
                    </a>
                </div>
            </div>
            
            <!-- Card 2: MOBIL -->
            <div class="vehicle-card bg-white rounded-3xl w-full sm:w-64 md:w-72 lg:w-80 xl:w-96 mb-8">
                <div class="vehicle-image-container bg-[#138A40] rounded-tl-[60px] sm:rounded-tl-[90px] rounded-bl-[20px] sm:rounded-bl-[30px] rounded-tr-[20px] sm:rounded-tr-[30px] rounded-br-[60px] sm:rounded-br-[90px] flex items-center justify-center overflow-hidden shadow-lg">
                    <img class="vehicle-image w-full h-48 sm:h-56 md:h-64 lg:h-72 object-contain p-4" src="{{ asset('images/pilihKendaraan/car.png') }}" alt="Mobil">
                </div>
                <div class="p-4 flex flex-col items-center">
                    <h2 class="font-semibold text-xl sm:text-2xl">MOBIL</h2>
                    <a href="{{ route('kendaraan') }}" class="btn-sewa bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition mt-4 text-sm sm:text-base md:text-lg w-full sm:w-auto">
                        Sewa Sekarang
                    </a>
                </div>
            </div>
            
            <!-- Card 3: MOTOR -->
            <div class="vehicle-card bg-white rounded-3xl w-full sm:w-64 md:w-72 lg:w-80 xl:w-96 mb-8">
                <div class="vehicle-image-container bg-[#138A40] rounded-tl-[60px] sm:rounded-tl-[90px] rounded-bl-[20px] sm:rounded-bl-[30px] rounded-tr-[20px] sm:rounded-tr-[30px] rounded-br-[60px] sm:rounded-br-[90px] flex items-center justify-center overflow-hidden shadow-lg">
                    <img class="vehicle-image w-full h-48 sm:h-56 md:h-64 lg:h-72 object-contain p-4" src="{{ asset('images/pilihKendaraan/MotorCycles.png') }}" alt="Motor">
                </div>
                <div class="p-4 flex flex-col items-center">
                    <h2 class="font-semibold text-xl sm:text-2xl">MOTOR</h2>
                    <a href="{{ route('kendaraan') }}" class="btn-sewa bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition mt-4 text-sm sm:text-base md:text-lg w-full sm:w-auto">
                        Sewa Sekarang
                    </a>
                </div>
            </div>
            
        </div>
    </div>
