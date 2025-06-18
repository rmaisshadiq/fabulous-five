{{-- resources/views/feedback/main-page.blade.php --}}
@extends('layouts.main')

@section('title', 'feedback')

@section('content')
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
                    @include('feedback.pesan')

                    {{-- visi misi --}}
                    @include('feedback.rating')

                    {{-- unggulan --}}
                    @include('feedback.ulasan')

                    {{-- contact section --}}
                    @include('feedback.action-button')
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
@endsection