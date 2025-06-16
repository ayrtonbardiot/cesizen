@extends('layout.layout')

@section('title', $article->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('articles.index') }}" class="inline-block mb-6 text-blue-600 hover:text-blue-800">
            ← {{ __('messages.articles.back_to_articles') }}
        </a>

        <article class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($article->image)
                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-64 object-cover">
            @endif
            
            <div class="p-8">
                <h1 class="text-3xl font-bold mb-4">{{ $article->title }}</h1>
                
                <div class="text-gray-600 mb-6">
                    {{ __('messages.articles.published_on') }} {{ $article->published_at->format('d/m/Y') }}
                    @if($article->author)
                        {{ __('messages.articles.by') }} {{ $article->author }}
                    @endif
                </div>

                <div class="prose prose-lg max-w-none">
                    {!! $article->content !!}
                </div>
            </div>
        </article>
    </div>
</div>
@endsection 