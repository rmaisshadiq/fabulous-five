@extends('layouts.main')

@section('content')
    <div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-8">
            <div class="text-center mb-6">
                <h2 class="mt-2 text-3xl font-extrabold text-gray-900">Proses Pembayaran</h2>
                <p class="mt-1 text-sm text-gray-600">Total yang harus dibayar:</p>
                {{-- FIX: Use $order->total_amount (or similar) instead of $order->payment->amount --}}
                {{-- This assumes your Order model has a field directly storing the total amount --}}
                <p class="mt-1 text-2xl font-semibold text-green-600">Rp {{ $order->formatted_final_total }}
                </p>
                <p class="mt-2 text-sm text-gray-500">
                    Untuk pesanan #{{ $order->id }}
                </p>
            </div>

            <button id="pay-button"
                class="w-full flex items-center justify-center bg-gradient-to-r from-green-400 to-green-600 hover:from-green-500 hover:to-green-700 text-white font-semibold py-3 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v6m0 0H9m3 0h3" />
                </svg>
                Bayar Sekarang
            </button>

            <div class="mt-4 text-center">
                <a href="{{ route('payment.history') }}" class="text-sm text-blue-600 hover:underline">Lihat Riwayat
                    Pembayaran</a>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        document.getElementById('pay-button').addEventListener('click', function() {
            if (this.dataset.processing === 'true') {
                return;
            }
            this.dataset.processing = 'true';
            this.disabled = true;
            this.classList.add('opacity-50', 'cursor-not-allowed');

            snap.pay('{{ $snapToken }}', {
                onPending: function(result) {
                    alert('Transaksi pending: ' + result.status_message);
                },
                onSuccess: function(result) {
                    // Prevent multiple calls if somehow the success callback fires more than once rapidly
                    if (window.paymentProcessing) return;
                    window.paymentProcessing = true;

                    fetch("{{ route('payment.callback') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify(result)
                        })
                        .then(res => res.json())
                        .then(() => {
                            window.location.href = "{{ route('payment.success', ['orderId' => $order->id]) }}";
                        })
                        .catch(error => {
                            window.paymentProcessing = false; // Allow retries if the network call failed
                            console.error('Error saving payment data:', error);
                            alert('Gagal menyimpan data pembayaran: ' + (error.message || 'Terjadi kesalahan jaringan.'));
                            location.reload(); // Reload to reset state after network error
                        });
                },
                onError: function(error) {
                    // Re-enable button on error
                    document.getElementById('pay-button').dataset.processing = 'false';
                    document.getElementById('pay-button').disabled = false;
                    document.getElementById('pay-button').classList.remove('opacity-50', 'cursor-not-allowed');
                    alert('Terjadi kesalahan: ' + error.status_message);
                },
                onClose: function() {
                    // Re-enable button if user closes popup without completing
                    document.getElementById('pay-button').dataset.processing = 'false';
                    document.getElementById('pay-button').disabled = false;
                    document.getElementById('pay-button').classList.remove('opacity-50', 'cursor-not-allowed');
                    // Optionally, alert or log that the user closed the popup
                    // alert('Anda menutup jendela pembayaran.');
                }
            });
        });
    </script>
@endsection