{{-- Tombol --}}
                <div class="flex space-x-4">
                    @if(isset($vehicles))
                        <button type="submit" class="flex-1 bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700">Submit Order</button>
                    @endif
                    <a href="{{ route('kendaraan') }}" class="flex-1 text-center bg-gray-300 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-400">
                        {{ isset($vehicle) ? 'Change Vehicle' : 'Select Vehicle' }}
                    </a>
                </div>