@extends('layouts.main')

@section('title', 'Order History')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Page Header -->
            @include('order-history.page-header')



            <!-- Orders Content -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8">
                    @if($orders->count() > 0)
                        <!-- Stats Summary -->
                        @include('order-history.stats-summary')

                        <!-- Orders List -->
                        @include('order-history.order-list')
                    @else
                        <!-- Empty State -->
                        @include('order-history.empty-state')
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>



<script>
let orderToCancel = null;

function cancelOrder(orderId) {
    orderToCancel = orderId;
    document.getElementById('cancelModal').classList.remove('hidden');
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
    orderToCancel = null;
}

document.getElementById('confirmCancel').addEventListener('click', function() {
    if (orderToCancel) {
        // Submit form to cancel order
        fetch(`/orders/${orderToCancel}/cancel`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal membatalkan pesanan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
    closeCancelModal();
});
</script>
@endsection