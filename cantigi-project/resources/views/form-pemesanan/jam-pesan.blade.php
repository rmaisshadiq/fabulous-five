{{-- Booking Times --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_booking_time" class="block text-sm font-medium text-gray-700 mb-2">Start Time <span class="text-red-500">*</span></label>
                        <input type="time" name="start_booking_time" id="start_booking_time" required value="{{ old('start_booking_time') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md @error('start_booking_time') border-red-500 @enderror">
                        @error('start_booking_time')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="end_booking_time" class="block text-sm font-medium text-gray-700 mb-2">End Time <span class="text-red-500">*</span></label>
                        <input type="time" name="end_booking_time" id="end_booking_time" required value="{{ old('end_booking_time') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md @error('end_booking_time') border-red-500 @enderror">
                        @error('end_booking_time')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>