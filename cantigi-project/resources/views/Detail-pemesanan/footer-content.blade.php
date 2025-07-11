<!-- Footer Actions -->
<div class="bg-white rounded-b-2xl shadow-sm border border-gray-200 px-8 py-6">
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="flex items-center text-sm text-gray-500">
            <i class="fa fa-shield-alt text-green-500 mr-2"></i>
            <span>Pembayaran Aman & Terpercaya</span>
        </div>

        <div class="flex gap-3">
            @if ($orders->status === 'confirmed')
                <!-- Tombol Bayar -->
                <button id="pay-button"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium text-sm">
                    <i class="fa fa-credit-card mr-2"></i>
                    Bayar Sekarang
                </button>
            @elseif ($orders->status === 'completed' || $orders->status === 'in_progress')
                <!-- Tombol Download PDF -->
                <a href="{{ route('orders.invoice.download', ['order' => $orders->id]) }}"
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium text-sm">
                    <i class="fa fa-download mr-2"></i>
                    Unduh PDF
                </a>
            @else
                <!-- Tombol WhatsApp -->
                <a href="https://wa.me/6281234567890" target="_blank"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium text-sm">
                    <i class="fa fa-whatsapp mr-2"></i>
                    Hubungi CS
                </a>
            @endif
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        if (this.dataset.processing === 'true') {
            return;
        }
        this.dataset.processing = 'true';
        this.disabled = true;
        this.classList.add('opacity-50', 'cursor-not-allowed');

        snap.pay('{{ $snapToken }}', {
            onPending: function (result) {
                location.reload();
            },
            onSuccess: function (result) {
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
                        window.location.href = "{{ route('payment.success', ['orderId' => $orders->id]) }}";
                    })
                    .catch(error => {
                        window.paymentProcessing = false; // Allow retries if the network call failed
                        console.error('Error saving payment data:', error);
                        alert('Gagal menyimpan data pembayaran: ' + (error.message || 'Terjadi kesalahan jaringan.'));
                        location.reload(); // Reload to reset state after network error
                    });
            },
            onError: function (error) {
                // Re-enable button on error
                document.getElementById('pay-button').dataset.processing = 'false';
                document.getElementById('pay-button').disabled = false;
                document.getElementById('pay-button').classList.remove('opacity-50', 'cursor-not-allowed');
                alert('Terjadi kesalahan: ' + error.status_message);
            },
            onClose: function () {
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