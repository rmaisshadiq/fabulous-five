<!-- Comment Section -->
                <div class="mb-8">
                    <label for="comment" class="block font-roboto font-semibold text-xl text-gray-800 mb-4">
                        Ulasan Anda
                        <span class="text-red-500">*</span>
                    </label>
                    
                    <textarea 
                        name="comment" 
                        id="comment" 
                        rows="6"
                        placeholder="Ceritakan pengalaman Anda..."
                        class="w-full p-4 border-2 border-gray-300 rounded-xl font-roboto text-base text-gray-700 placeholder-gray-400 resize-none focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all duration-200"
                        required
                    >{{ old('comment') }}</textarea>
                    
                    <!-- Character Counter -->
                    <div class="flex justify-end items-center mt-2">
                        <span id="char-counter" class="text-gray-500 text-sm font-roboto">
                            0 karakter
                        </span>
                    </div>
                </div>