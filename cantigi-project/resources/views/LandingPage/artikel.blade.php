<!-- BLOG HEADER -->
<div class="flex justify-center items-center mt-24 sm:mt-28 md:mt-32 lg:mt-36">
    <div class="text-center">
        <h1 class="font-bold text-3xl sm:text-4xl md:text-5xl lg:text-6xl tracking-tight text-gray-900 mb-4 relative">
            <span class="text-black">
                Articles
            </span>
            <!-- Underline effect -->
            <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-0 h-1 bg-gradient-to-r from-green-400 to-blue-500 rounded-full transition-all duration-500 hover:w-24"></div>
        </h1>
        <p class="text-gray-600 text-lg mt-6 max-w-2xl mx-auto px-4">
            Temukan artikel-artikel menarik dan informatif
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto p-4 sm:p-5 md:p-6 lg:p-8 space-y-8 lg:space-y-12">
    <!-- Grid Layout -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($articles as $article)
            <article class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 overflow-hidden border border-gray-100 relative">
                
                <!-- Image Container with Overlay Effects -->
                <div class="relative overflow-hidden rounded-t-2xl">
                    <img src="{{ asset('storage/' . $article->image) }}" 
                         alt="{{ $article->title }}"
                         class="w-full h-48 sm:h-56 object-cover transition-transform duration-700 group-hover:scale-110">
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <!-- Shine Effect -->
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -skew-x-12 transform translate-x-[-100%] group-hover:translate-x-[200%] transition-transform duration-1000"></div>
                    </div>
                    
                    <!-- Date Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="bg-white/90 backdrop-blur-sm text-gray-800 px-3 py-1 rounded-full text-xs font-medium shadow-lg">
                            {{ $article->publish_date }}
                        </span>
                    </div>
                </div>

                <!-- Content Container -->
                <div class="p-6 space-y-4">
                    <!-- Article Title -->
                    <h2 class="font-bold text-xl lg:text-2xl text-gray-900 group-hover:text-green-600 transition-colors duration-300 leading-tight line-clamp-2">
                        {{ $article->title }}
                    </h2>
                    
                    <!-- Article Excerpt -->
                    <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">
                        {{ Str::limit($article->content, 120) }}
                    </p>
                    
                    <!-- Meta Info -->
                    <div class="flex items-center justify-between text-xs text-gray-500 pt-2 border-t border-gray-100">
                        <div class="flex items-center space-x-2">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center">
                                {{-- <span class="text-white font-semibold text-xs">
                                    {{ substr($article->employees->user->name ?? 'Admin', 0, 1) }}
                                </span> --}}
                                <img src="{{ asset('storage/' . $article->employees->user->profile_image) }}" alt="{{ $article->employees->user->name }}" class="w-full h-full object-cover rounded-full">
                            </div>
                            <span>{{ $article->employees->user->name ?? 'Admin' }}</span>
                        </div>
                    </div>
                    
                    <!-- Read More Button -->
                    <div class="pt-4">
                        <a href="{{ route('artikel.detail', $article->id) }}" 
                           class="group/link inline-flex items-center text-green-600 hover:text-green-700 font-semibold text-sm transition-all duration-300 transform hover:translate-x-1">
                            <span class="relative">
                                Baca Selengkapnya
                                <!-- Animated underline -->
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-600 group-hover/link:w-full transition-all duration-300"></span>
                            </span>
                            <svg class="w-4 h-4 ml-2 transform group-hover/link:translate-x-1 transition-transform duration-300" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Floating Animation Effect -->
                <div class="absolute -top-1 -right-1 w-20 h-20 bg-gradient-to-br from-green-400/20 to-blue-500/20 rounded-full blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </article>
        @endforeach
    </div>
    
    <!-- Pagination (jika ada) -->
    @if(method_exists($articles, 'links'))
    <div class="flex justify-center mt-12">
        <div class="bg-white rounded-xl shadow-lg p-4">
            {{ $articles->links() }}
        </div>
    </div>
    @endif
</div>

<style>
/* Custom animations yang tidak bisa dicapai dengan Tailwind saja */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}

.floating-animation {
    animation: float 3s ease-in-out infinite;
}

/* Loading skeleton untuk gambar */
.lazy-image {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* Line clamp untuk browser yang belum support */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #10b981, #3b82f6);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #059669, #2563eb);
}
</style>