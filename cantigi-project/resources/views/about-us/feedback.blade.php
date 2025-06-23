 <section class="bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 py-8 max-w-4xl">

            {{-- herosection --}}
            @include('feedback.header')
            <!-- Feedback Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <form id="feedback-form" action="{{ route('feedback.store') }}" method="POST">
                    @csrf
                    
                   <!-- Hidden Order (tidak ditampilkan ke user, tapi dikirim ke server) -->
@if($orders->isNotEmpty())
    @php $latestOrder = $orders->last(); @endphp
    <input type="hidden" name="order_id" value="{{ $latestOrder->id }}">
@endif

<!-- Hidden Customer (tidak ditampilkan ke user, tapi dikirim ke server) -->
@if($customers->isNotEmpty())
    @php $activeCustomer = $customers->first(); @endphp
    <input type="hidden" name="customer_id" value="{{ $activeCustomer->id }}">
@endif



                    <!-- Hidden field for feedback date -->
                    <input type="hidden" name="feedback_date" id="feedback_date">

                    {{-- company overview --}}
                    {{-- @include('feedback.pesan') --}}
                    <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl font-roboto">
            <strong>Terima kasih!</strong> {{ session('success') }}
        </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl font-roboto">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

                    {{-- visi misi --}}
                    {{-- @include('feedback.rating') --}}
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

                    {{-- unggulan --}}
                    {{-- @include('feedback.ulasan') --}}
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

                    {{-- contact section --}}
                    {{-- @include('feedback.action-button') --}}
                    <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                    <button 
                        type="button" 
                        id="cancel-btn"
                        class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-roboto font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200"
                    >
                        Batal
                    </button>
                    
                    <button 
                        type="submit" 
                        id="submit-btn"
                        class="px-8 py-3 bg-green-600 text-white font-roboto font-semibold rounded-xl hover:bg-grees-700 focus:outline-none focus:ring-4 focus:ring-blue-200 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span id="submit-text">Kirim Feedback</span>
                        <span id="loading-text" class="hidden">Mengirim...</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('.star-icon');
            const ratingInput = document.getElementById('rating');
            const ratingText = document.getElementById('rating-text');
            const ratingDescription = document.getElementById('rating-description');
            const ratingError = document.getElementById('rating-error');
            const commentTextarea = document.getElementById('comment');
            const charCounter = document.getElementById('char-counter');
            const form = document.getElementById('feedback-form');
            const submitBtn = document.getElementById('submit-btn');
            const submitText = document.getElementById('submit-text');
            const loadingText = document.getElementById('loading-text');
            const cancelBtn = document.getElementById('cancel-btn');
            const feedbackDateInput = document.getElementById('feedback_date');

            let currentRating = parseInt(ratingInput.value) || 0;

            const ratingLabels = {
                0: { text: 'Pilih rating Anda', desc: 'Klik bintang untuk memberikan rating' },
                1: { text: '1/5 - Sangat Buruk', desc: 'Sangat tidak puas dengan layanan' },
                2: { text: '2/5 - Buruk', desc: 'Tidak puas dengan layanan' },
                3: { text: '3/5 - Cukup', desc: 'Layanan biasa saja' },
                4: { text: '4/5 - Baik', desc: 'Puas dengan layanan' },
                5: { text: '5/5 - Sangat Baik', desc: 'Sangat puas dengan layanan' }
            };

            feedbackDateInput.value = new Date().toISOString().split('T')[0];

            if (currentRating > 0) {
                updateStars(currentRating);
                updateRatingDisplay(currentRating);
            }

            updateCharCounter();

            stars.forEach(star => {
                star.addEventListener('click', function () {
                    const rating = parseInt(this.dataset.rating);
                    currentRating = rating;
                    ratingInput.value = rating;
                    updateRatingDisplay(rating);
                    updateStars(rating);
                    hideRatingError();
                });

                star.addEventListener('mouseenter', function () {
                    const rating = parseInt(this.dataset.rating);
                    updateStars(rating);
                    updateRatingDisplay(rating);
                });
            });

            document.getElementById('star-rating').addEventListener('mouseleave', function () {
                updateStars(currentRating);
                updateRatingDisplay(currentRating);
            });

            commentTextarea.addEventListener('input', updateCharCounter);

            form.addEventListener('submit', function (e) {
                if (!validateForm()) {
                    e.preventDefault();
                    return false;
                }

                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                loadingText.classList.remove('hidden');
            });

            cancelBtn.addEventListener('click', function () {
                if (confirm('Apakah Anda yakin ingin membatalkan feedback?')) {
                    resetForm();
                }
            });

            function updateStars(rating) {
                stars.forEach(star => {
                    const starRating = parseInt(star.dataset.rating);
                    if (starRating <= rating) {
                        star.classList.remove('text-gray-300');
                        star.classList.add('text-yellow-400');
                        star.style.filter = 'drop-shadow(0 0 4px rgba(251, 191, 36, 0.5))';
                    } else {
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-300');
                        star.style.filter = 'none';
                    }
                });
            }

            function updateRatingDisplay(rating) {
                ratingText.textContent = ratingLabels[rating].text;
                ratingDescription.textContent = ratingLabels[rating].desc;
            }

            function updateCharCounter() {
                const length = commentTextarea.value.length;
                charCounter.textContent = `${length} karakter`;
            }

            function validateForm() {
                let isValid = true;

                if (currentRating === 0) {
                    showRatingError();
                    isValid = false;
                } else {
                    hideRatingError();
                }

                return isValid;
            }

            function showRatingError() {
                ratingError.classList.remove('hidden');
                document.getElementById('star-rating').scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            function hideRatingError() {
                ratingError.classList.add('hidden');
            }

            function resetForm() {
                currentRating = 0;
                ratingInput.value = 0;
                commentTextarea.value = '';
                updateCharCounter();
                updateStars(0);
                updateRatingDisplay(0);
                hideRatingError();
            }
        });
    </script>