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
                <form action="{{ route('payment.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" id="order_id" value="{{ $orders->id }}">
                    
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium text-sm">
                       <i class="fa fa-credit-card mr-2"></i>
                       Lanjut ke Pembayaran
                    </button>
                </form>
            @elseif ($orders->status === 'completed' || $orders->status === 'in_progress')
                <!-- Tombol Download PDF -->
                <a href="{{ route('orders.invoice.download', ['order' => $orders->id]) }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium text-sm">
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
