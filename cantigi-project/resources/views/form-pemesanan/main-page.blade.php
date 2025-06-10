{{-- resources/views/kendaraan/index.blade.php --}}
@extends('layouts.main')

@section('title', 'pemesanan')

@section('content')
    <section class="w-[60rem] mx-auto glass-card mt-[100px] mb-[100px] rounded-3xl p-8 animate-slide-in">
        <form action="/order-submit" method="POST">
        @csrf

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

    </form>


    </section>

   <script>
    function selectOption(element) {
      // Remove selected class from all option cards in the same group
      const siblings = element.parentElement.children;
      for (let sibling of siblings) {
        sibling.classList.remove('ring-4', 'ring-gray-800');
      }
      
      // Add selected class to clicked element
      element.classList.add('ring-4', 'ring-gray-800');
      
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
        sibling.classList.remove('ring-4', 'ring-gray-800');
      }
      
      // Add selected class to clicked element
      element.classList.add('ring-4', 'ring-gray-800');
      
      // Check the radio button
      const radio = element.querySelector('input[type="radio"]');
      if (radio) {
        radio.checked = true;
      }

      // Check if 'lokasi lainnya' is selected
      const isCustom = element.querySelector('input[type="radio"]').value === 'lainnya';
      const customInput = document.getElementById('custom-location-input');
      if (isCustom) {
        customInput.classList.remove('hidden');
        customInput.classList.add('animate-fade-in');
      } else {
        customInput.classList.add('hidden');
      }
    }

    // Add smooth entrance animation
    document.addEventListener('DOMContentLoaded', function() {
      const main = document.querySelector('section');
      main.style.opacity = '0';
      main.style.transform = 'translateY(30px)';
      
      setTimeout(() => {
        main.style.transition = 'all 0.6s ease-out';
        main.style.opacity = '1';
        main.style.transform = 'translateY(0)';
      }, 100);
    });
  </script>

  <style>
    @keyframes fade-in {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .animate-fade-in {
      animation: fade-in 0.5s ease-out forwards;
    }
  </style>
@endsection