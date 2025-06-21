<!-- Customer Information -->
<div class="space-y-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            Informasi Pemesan
        </h2>
        <div class="bg-gray-50 rounded-xl p-5 space-y-4">
            <div class="flex justify-between items-start">
                <span class="text-sm font-medium text-gray-600">Atas Nama</span>
                <span class="text-sm font-semibold text-gray-900 text-right">
                    {{ $orders->customer->user->name ?? 'Nama tidak tersedia' }}
                </span>
            </div>
            <div class="flex justify-between items-start">
                <span class="text-sm font-medium text-gray-600">Email</span>
                <span class="text-sm font-semibold text-gray-900 text-right">
                    {{ $orders->customer->user->email ?? 'Email tidak tersedia' }}
                </span>
            </div>
        </div>
    </div>