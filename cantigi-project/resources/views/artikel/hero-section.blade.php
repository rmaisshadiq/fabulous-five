<section class="relative bg-gradient-to-br bg-green-600 bg-green-700">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="text-center">
                <div class="rounded-3xl p-2 mx-auto">
                   
                     {{-- Menampilkan Gambar Article --}}
                    <div class="">
                        @if($article->image)
                            <img src="{{ asset('storage/' . $article->image) }}" 
                                 alt="{{ $article->title }}"
                                 class="w-full h-[30rem] object-cover rounded-xl mb-4">
                        @else
                            <div class="w-full h-64 bg-white/30 rounded-xl mb-4 flex items-center justify-center">
                                <svg class="w-16 h-16 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>