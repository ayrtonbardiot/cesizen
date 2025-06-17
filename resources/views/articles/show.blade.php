@extends('layout.layout')

@section('title', $article->title)

@section('content')
<div class="space-y-8">
    <!-- Bouton retour -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-lg" data-aos="fade-up">
        <a href="{{ route('articles.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('messages.articles.back_to_articles') }}
        </a>
    </div>

    <!-- Contenu de l'article -->
    <article class="bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
        @if($article->image)
            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-64 object-cover">
        @endif

        <div class="p-6 sm:p-8 space-y-6">
            <h1 class="text-3xl font-bold text-gray-900">{{ $article->title }}</h1>

            <div class="text-sm text-gray-600 flex items-center flex-wrap gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ $article->published_at->format('d/m/Y') }}
                @if($article->author)
                    <span class="mx-1">•</span>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ $article->author }}
                @endif
            </div>

            <div class="prose prose-lg max-w-none">
                {!! $article->content !!}
            </div>
        </div>
    </article>
</div>
@endsection
