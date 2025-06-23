{{-- resources/views/kendaraan/car/vehicle-slider-container.blade.php --}}
@php 
    $vehicleChunks = $vehicles->chunk(6); // 6 kendaraan per slide 
@endphp

<div class="vehicle-slider-container">
    <div class="slides-container relative max-w-[1200px] mx-auto px-4">
        <!-- Slides -->
        @foreach ($vehicleChunks as $index => $vehicleChunk)
            <div class="slide {{ $index == 0 ? 'block' : 'hidden' }}" data-slide="{{ $index }}">
                <section class="grid grid-cols-1 md:grid-cols-2 gap-6 py-10">
                    @foreach ($vehicleChunk as $vehicle)
                        @include('kendaraan.car.vehicle-card', ['vehicle' => $vehicle])
                    @endforeach
                </section>
            </div>
        @endforeach
    </div>

    <!-- Pagination Controls -->
    @if($vehicleChunks->count() > 1)
        <div class="slider-controls">
            <!-- Navigation Controls -->
            <div class="flex justify-center items-center mt-8 space-x-4">
                <!-- Previous Button -->
                <button 
                    id="prevBtn" 
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                    onclick="VehicleSlider.changeSlide(-1)">
                    <i class="fa fa-chevron-left"></i> Sebelumnya
                </button>

                <!-- Slide Indicators -->
                <div class="flex space-x-2">
                    @foreach ($vehicleChunks as $slideIndex => $chunk)
                        <button 
                            class="slide-indicator w-3 h-3 rounded-full transition-colors duration-200 {{ $slideIndex == 0 ? 'bg-green-500' : 'bg-gray-300' }}"
                            onclick="VehicleSlider.goToSlide({{ $slideIndex }})"
                            data-slide="{{ $slideIndex }}">
                        </button>
                    @endforeach
                </div>

                <!-- Next Button -->
                <button 
                    id="nextBtn" 
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                    onclick="VehicleSlider.changeSlide(1)">
                    Selanjutnya <i class="fa fa-chevron-right"></i>
                </button>
            </div>

            <!-- Slide Counter -->
            <div class="text-center mt-4 text-gray-600">
                <span id="slideCounter">1</span> dari {{ $vehicleChunks->count() }}
            </div>
        </div>
    @endif
</div>