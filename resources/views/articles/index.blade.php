@extends('layout.layout')

@section('title', __('messages.articles.title'))

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
@endpush

@section('content')
<div class="space-y-8">
    <!-- En-tête -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-lg" data-aos="fade-down">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ __('messages.articles.title') }}</h1>
    </div>

    <!-- Liste des articles -->
    @if($articles->isEmpty())
        <div class="bg-white rounded-2xl p-6 shadow-lg text-center" data-aos="fade-up">
            <p class="text-gray-600">{{ __('messages.articles.no_articles') }}</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-aos="fade-up">
            @foreach($articles as $article)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transform transition duration-300 hover:scale-105" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    @if($article->image)
                        <div class="relative h-48">
                            <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        </div>
                    @endif
                    <div class="p-6 space-y-3">
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $article->published_at->format('d/m/Y') }}
                            @if($article->author)
                                <span class="mx-2">•</span>
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $article->author }}
                            @endif
                        </div>

                        <h3 class="text-xl font-semibold text-gray-900">{{ $article->title }}</h3>
                        <p class="text-gray-600">{{ $article->excerpt }}</p>

                        <a href="{{ route('articles.show', $article->slug) }}"
                           class="inline-flex items-center text-black font-medium hover:underline transition">
                            {{ __('messages.articles.read_more') }}
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8" data-aos="fade-up">
            {{ $articles->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            disable: 'mobile'
        });
    </script>
@endpush
