@extends('layouts.main')

@section('title', 'Create New Order')

@section('content')
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        @include('pembayaran.header')

        <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-8">
        <!-- Form Pembayaran -->
        @include('pembayaran.form-pembayaran')

        <!-- Ringkasan Pesanan -->
        @include('pembayaran.ringkasan-pesanan')
        </div>

        <!-- Footer Info -->
        @include('pembayaran.footer-info')
    </div>

    <script>
        // Format nomor kartu
        document.getElementById('cardNumber').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            this.value = formattedValue;
        });

        // Format tanggal expired
        document.querySelector('input[name="expiry_date"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            this.value = value;
        });

        // Animasi hover untuk bank options
        document.querySelectorAll('.bank-option').forEach(option => {
            option.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            option.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Handle form submission
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            const payButton = document.getElementById('payButton');
            
            // Show loading state
            payButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            payButton.disabled = true;
        });
    </script>
</body>
@endsection