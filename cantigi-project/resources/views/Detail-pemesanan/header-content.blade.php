<!-- Header -->
        <div class="bg-white rounded-t-2xl shadow-sm border border-gray-200 px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">Detail Pemesanan</h1>
                    <p class="text-sm text-gray-500">ID Pesanan : {{ $orders->id }}</p>
                </div>
                <div class="text-right">
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'confirmed' => 'bg-blue-100 text-blue-800',
                            'inprogress' => 'bg-indigo-100 text-indigo-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                        ];

                        $color = $statusColors[$orders->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp

                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $color }}">
                        <i class="fa fa-check-circle mr-1"></i>
                        {{ ucfirst($orders->status) }}
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Tanggal: {{ $orders->start_booking_date }}</p>
                </div>
            </div>
        </div>