{{-- resources/views/kendaraan/index.blade.php --}}
@extends('layouts.main')

@section('title', 'about us')

@section('content')
    <section>



        {{-- herosection --}}
        @include('about-us.hero-section')

        {{-- company overview --}}
        @include('about-us.company-overview')

        {{-- visi misi --}}
        @include('about-us.visi-misi')

        {{-- unggulan --}}
        @include('about-us.unggulan')

        {{-- contact section --}}
        @include('about-us.contact-section')

        {{-- contact section --}}
        @include('about-us.feedback')



    </section>

     <script>
    // Scroll to top functionality
    const scrollToTopBtn = document.getElementById('scrollToTop');
    
    window.addEventListener('scroll', () => {
      if (window.pageYOffset > 300) {
        scrollToTopBtn.classList.remove('opacity-0', 'invisible');
      } else {
        scrollToTopBtn.classList.add('opacity-0', 'invisible');
      }
    });
    
    scrollToTopBtn.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });

    // Animate elements on scroll
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('animate-slide-up');
        }
      });
    }, observerOptions);

    // Observe all elements with animation classes
    document.querySelectorAll('.animate-slide-up').forEach(el => {
      observer.observe(el);
    });
  </script>
@endsection