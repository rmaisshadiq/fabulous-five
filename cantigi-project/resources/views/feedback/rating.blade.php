<!-- Rating Section -->
                <div class="mb-8">
                    <label class="block font-roboto font-semibold text-xl text-gray-800 mb-4">
                        Rating Kepuasan
                        <span class="text-red-500">*</span>
                    </label>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <!-- Star Rating -->
                        <div class="flex items-center gap-3" id="star-rating">
                            <svg data-rating="1" class="star-icon w-10 h-10 cursor-pointer text-gray-300 hover:text-yellow-400 transition-all duration-200 hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg data-rating="2" class="star-icon w-10 h-10 cursor-pointer text-gray-300 hover:text-yellow-400 transition-all duration-200 hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg data-rating="3" class="star-icon w-10 h-10 cursor-pointer text-gray-300 hover:text-yellow-400 transition-all duration-200 hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg data-rating="4" class="star-icon w-10 h-10 cursor-pointer text-gray-300 hover:text-yellow-400 transition-all duration-200 hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg data-rating="5" class="star-icon w-10 h-10 cursor-pointer text-gray-300 hover:text-yellow-400 transition-all duration-200 hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            
                            <!-- Hidden input for rating -->
                            <input type="hidden" name="rating" id="rating" value="{{ old('rating', 0) }}" required>
                        </div>
                        
                        <!-- Rating Display -->
                        <div class="flex flex-col items-start sm:items-end">
                            <span class="font-roboto font-medium text-gray-700 text-lg" id="rating-text">Pilih rating Anda</span>
                            <span class="font-roboto text-sm text-gray-500" id="rating-description">Klik bintang untuk memberikan rating</span>
                        </div>
                    </div>
                    
                    <!-- Rating Error Message -->
                    <div id="rating-error" class="hidden mt-2 text-red-500 text-sm font-roboto">
                        Silakan pilih rating terlebih dahulu
                    </div>
                </div>