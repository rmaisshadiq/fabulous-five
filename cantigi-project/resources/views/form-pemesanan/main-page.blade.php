{{-- resources/views/kendaraan/index.blade.php --}}
@extends('layouts.main')

@section('title', 'pemesanan')

@section('content')
    <section class="w-[60rem] mx-auto glass-card mt-[100px] mb-[100px] rounded-3xl p-8 animate-slide-in">



        {{-- nama harga rental --}}
        @include('form-pemesanan.style')

        {{-- nama harga rental --}}
        @include('form-pemesanan.nama-harga-rental')

        {{-- opsi rental --}}
        @include('form-pemesanan.opsi-rental')

        {{-- tanggal pesan --}}
        @include('form-pemesanan.tanggal-pesan')

        {{-- lokasi --}}
        @include('form-pemesanan.lokasi')

        {{-- buton booking --}}
        @include('form-pemesanan.buton-booking')

    </section>

    <script>
        // js form pemesanan
        function selectOption(element) {
            // Remove selected class from all option cards in the same group
            const siblings = element.parentElement.children;
            for (let sibling of siblings) {
                sibling.classList.remove('selected');
            }

            // Add selected class to clicked element
            element.classList.add('selected');

            // Check the radio button
            const radio = element.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
            }
        }

        function selectLocation(element) {
            // Remove selected class from all location cards
            const siblings = element.parentElement.children;
            for (let sibling of siblings) {
                sibling.classList.remove('selected');
            }

            // Add selected class to clicked element
            element.classList.add('selected');

            // Check the radio button
            const radio = element.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
            }
        }

        // Add animation delays for smooth entrance
        document.addEventListener('DOMContentLoaded', function () {
            const sections = document.querySelectorAll('section > div');
            sections.forEach((section, index) => {
                section.style.animationDelay = `${index * 0.1}s`;
                section.classList.add('animate-slide-in');
            });
        });

        function selectLocation(el) {
            // Reset semua pilihan
            document.querySelectorAll('.option-card').forEach(card => {
                card.classList.remove('selected');
                card.querySelector('input[type="radio"]').checked = false;
            });

            // Tandai yang dipilih
            el.classList.add('selected');
            el.querySelector('input[type="radio"]').checked = true;

            // Cek apakah 'lokasi lainnya' yang dipilih
            const isCustom = el.querySelector('input[type="radio"]').value === 'lainnya';
            const customInput = document.getElementById('custom-location-input');
            if (isCustom) {
                customInput.classList.remove('hidden');
            } else {
                customInput.classList.add('hidden');
            }
        }

        // hitung hari
        const startDateInput = document.getElementById('start-date');
        const endDateInput = document.getElementById('end-date');
        const durasiSpan = document.getElementById('durasi-hari');

        function hitungDurasi() {
            const start = new Date(startDateInput.value);
            const end = new Date(endDateInput.value);

            if (!isNaN(start) && !isNaN(end)) {
                const selisihMs = end - start;
                const hari = selisihMs / (1000 * 60 * 60 * 24);
                durasiSpan.textContent = hari >= 0 ? hari : 0;
            }
        }

        startDateInput.addEventListener('change', hitungDurasi);
        endDateInput.addEventListener('change', hitungDurasi);
    </script>
@endsection