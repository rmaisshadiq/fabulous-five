{{-- resources/views/kendaraan/car/vehicle-slider.blade.php --}}
<script>
const VehicleSlider = {
    currentSlide: 0,
    totalSlides: 0,
    
    init: function() {
        this.totalSlides = document.querySelectorAll('.slide').length;
        this.showSlide(0);
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                this.changeSlide(-1);
            } else if (e.key === 'ArrowRight') {
                this.changeSlide(1);
            }
        });
    },
    
    showSlide: function(slideIndex) {
        // Sembunyikan semua slide
        document.querySelectorAll('.slide').forEach(slide => {
            slide.classList.add('hidden');
            slide.classList.remove('block');
        });
        
        // Tampilkan slide yang dipilih
        const targetSlide = document.querySelector(`[data-slide="${slideIndex}"]`);
        if (targetSlide) {
            targetSlide.classList.remove('hidden');
            targetSlide.classList.add('block');
        }
        
        // Update indicators
        this.updateIndicators(slideIndex);
        
        // Update counter
        this.updateCounter(slideIndex);
        
        // Update button states
        this.updateButtons(slideIndex);
    },
    
    updateIndicators: function(activeIndex) {
        document.querySelectorAll('.slide-indicator').forEach((indicator, index) => {
            if (index === activeIndex) {
                indicator.classList.remove('bg-gray-300');
                indicator.classList.add('bg-green-500');
            } else {
                indicator.classList.remove('bg-green-500');
                indicator.classList.add('bg-gray-300');
            }
        });
    },
    
    updateCounter: function(slideIndex) {
        const counter = document.getElementById('slideCounter');
        if (counter) {
            counter.textContent = slideIndex + 1;
        }
    },
    
    updateButtons: function(slideIndex) {
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        
        if (prevBtn) {
            prevBtn.disabled = slideIndex === 0;
            prevBtn.classList.toggle('opacity-50', slideIndex === 0);
        }
        
        if (nextBtn) {
            nextBtn.disabled = slideIndex === this.totalSlides - 1;
            nextBtn.classList.toggle('opacity-50', slideIndex === this.totalSlides - 1);
        }
    },
    
    changeSlide: function(direction) {
        this.currentSlide += direction;
        
        // Ensure slide index stays within bounds
        if (this.currentSlide < 0) {
            this.currentSlide = 0;
        } else if (this.currentSlide >= this.totalSlides) {
            this.currentSlide = this.totalSlides - 1;
        }
        
        this.showSlide(this.currentSlide);
    },
    
    goToSlide: function(slideIndex) {
        this.currentSlide = slideIndex;
        this.showSlide(this.currentSlide);
    },
    
    // Auto slide functionality (optional)
    startAutoSlide: function(interval = 10000) {
        setInterval(() => {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
            this.showSlide(this.currentSlide);
        }, interval);
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    VehicleSlider.init();
    
    // Uncomment to enable auto-sliding
    // VehicleSlider.startAutoSlide(10000); // 10 seconds
});
</script>