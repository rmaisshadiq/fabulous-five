{{-- Booking Dates --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_booking_date" class="block text-sm font-medium text-gray-700 mb-2">Start Date <span class="text-red-500">*</span></label>
                        <input type="date" name="start_booking_date" id="start_booking_date" required min="{{ date('Y-m-d') }}" value="{{ old('start_booking_date') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md @error('start_booking_date') border-red-500 @enderror">
                        @error('start_booking_date')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="end_booking_date" class="block text-sm font-medium text-gray-700 mb-2">End Date <span class="text-red-500">*</span></label>
                        <input type="date" name="end_booking_date" id="end_booking_date" required min="{{ date('Y-m-d') }}" value="{{ old('end_booking_date') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md @error('end_booking_date') border-red-500 @enderror">
                        @error('end_booking_date')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>