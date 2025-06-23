{{-- Selected Vehicle --}}
                @if(isset($vehicles))
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kendaraan yang dipilih</label>
                        <div class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 shadow-sm text-gray-700">
                            {{ $vehicles->brand }} - {{ $vehicles->model }} ({{ $vehicles->license_plate }})
                        </div>
                        <input type="hidden" name="vehicle_id" value="{{ $vehicles->id }}">
                    </div>
                @else
                    <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <p>No vehicle selected. Please <a href="{{ route('kendaraan') }}" class="underline">select a vehicle</a> first.</p>
                    </div>
                @endif