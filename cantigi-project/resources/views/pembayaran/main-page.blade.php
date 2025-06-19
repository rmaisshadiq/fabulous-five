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
        document.querySelector('input[placeholder="MM/YY"]').addEventListener('input', function(e) {
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

        // Validasi form
        document.querySelector('button').addEventListener('click', function(e) {
            e.preventDefault();
            
            const cardNumber = document.getElementById('cardNumber').value;
            const selectedBank = document.querySelector('input[name="bank"]:checked');
            
            if (!selectedBank) {
                alert('Silakan pilih bank terlebih dahulu');
                return;
            }
            
            if (cardNumber.replace(/\s/g, '').length < 16) {
                alert('Nomor kartu tidak valid');
                return;
            }
            
            // Simulasi proses pembayaran
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            this.disabled = true;
            
            setTimeout(() => {
                alert('Pembayaran berhasil! Terima kasih.');
                this.innerHTML = '<i class="fas fa-check mr-2"></i>Pembayaran Berhasil';
                this.classList.remove('from-blue-600', 'to-blue-700');
                this.classList.add('from-green-600', 'to-green-700');
            }, 2000);
        });
    </script>
</body>
@endsection