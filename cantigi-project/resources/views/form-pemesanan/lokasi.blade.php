{{-- Drop Address --}}
                <div>
                    <div>
                        <label for="drop_address" class="block text-gray-800 font-semibold mb-2">Masukkan Alamat Anda <span class="text-red-500">*</span></label>
                        <input type="text" name="drop_address" id="drop_address" placeholder="Contoh: Jl. By Pass" required
                            value="{{ old('drop_address') }}"
                            class="w-full p-3 rounded-lg border-2 border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 focus:outline-none @error('drop_address') border-red-500 @enderror">
                        @error('drop_address')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>