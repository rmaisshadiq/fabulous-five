<!-- Loop over each article -->
@foreach ($articles as $article)
    <!-- Featured Image -->
    <div class="relative h-64 md:h-80 overflow-hidden mb-6">
        <!-- Dynamic Image from Database -->
        <img 
            src="{{ $article->image ? asset('storage/' . $article->image) : '/api/placeholder/300x200' }}"
            alt="{{ $article->title ?? 'Artikel Image' }}" 
            class="w-full h-full object-cover"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
        >

        <!-- Fallback placeholder if image fails to load -->
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-emerald-600 items-center justify-center hidden">
            <div class="text-center text-white">
                <svg class="w-16 h-16 mx-auto mb-4 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
    </div>
@endforeach
