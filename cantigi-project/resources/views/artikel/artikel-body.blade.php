<!-- Article Body -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="p-6 sm:p-8 lg:p-12">
            <!-- Article Content -->
            <div class="prose prose-lg prose-gray max-w-none">
                <div class="text-gray-700 leading-relaxed text-lg">
                    <div class="first-letter:text-6xl first-letter:font-bold first-letter:text-green-600 first-letter:float-left first-letter:mr-3 first-letter:mt-1 first-letter:leading-none">
                        {!! nl2br(e($article->content)) !!}
                    </div>
                </div>
            </div>
            
            <!-- Article Footer -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <!-- Tags (jika ada) -->
                    @if(isset($article->tags) && $article->tags)
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-sm font-medium text-gray-600">Tags:</span>
                        @foreach(explode(',', $article->tags) as $tag)
                        <span class="inline-flex items-center px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-full transition-colors duration-200">
                            #{{ trim($tag) }}
                        </span>
                        @endforeach
                    </div>
                    @endif
                    
                    <!-- Back to Articles Button -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ url()->previous() }}" 
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Articles (Optional) -->
@if(isset($relatedArticles) && $relatedArticles->count() > 0)
<div class="max-w-4xl mx-auto mt-16 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 border border-gray-100">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">Artikel Terkait</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($relatedArticles->take(4) as $related)
            <a href="{{ route('artikel.detail', $related->id) }}" 
               class="group flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                @if($related->image)
                <img src="{{ asset('storage/' . $related->image) }}" 
                     alt="{{ $related->title }}" 
                     class="w-16 h-16 object-cover rounded-lg group-hover:scale-105 transition-transform duration-200">
                @endif
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-medium text-gray-900 group-hover:text-green-600 transition-colors duration-200 line-clamp-2">
                        {{ $related->title }}
                    </h4>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $related->publish_date }}
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif