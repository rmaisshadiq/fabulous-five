<!-- Stats Summary -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="bg-gradient-to-r from-green-100 to-green-50 border border-green-200 rounded-xl p-6">
                                <div class="flex items-center">
                                    <div class="bg-green-500 rounded-full p-3 mr-4">
                                        <i class="fa fa-check text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-green-600 text-sm font-medium">Total Pesanan</p>
                                        <p class="text-2xl font-bold text-green-800">{{ $orders->count() }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gradient-to-r from-blue-100 to-blue-50 border border-blue-200 rounded-xl p-6">
                                <div class="flex items-center">
                                    <div class="bg-blue-500 rounded-full p-3 mr-4">
                                        <i class="fa fa-car text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-blue-600 text-sm font-medium">Pesanan Aktif</p>
                                        <p class="text-2xl font-bold text-blue-800">{{ $orders->whereIn('status', ['pending', 'confirmed', 'ongoing'])->count() }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gradient-to-r from-purple-100 to-purple-50 border border-purple-200 rounded-xl p-6">
                                <div class="flex items-center">
                                    <div class="bg-purple-500 rounded-full p-3 mr-4">
                                        <i class="fa fa-flag-checkered text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-purple-600 text-sm font-medium">Selesai</p>
                                        <p class="text-2xl font-bold text-purple-800">{{ $orders->where('status', 'completed')->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>