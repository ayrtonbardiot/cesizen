@extends('layout.layout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">{{ __('messages.articles.title') }}</h1>

    @if($articles->isEmpty())
        <p class="text-gray-600">{{ __('messages.articles.no_articles') }}</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($articles as $article)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2">{{ $article->title }}</h2>
                        <p class="text-gray-600 text-sm mb-4">
                            {{ __('messages.articles.published_on') }} {{ $article->published_at->format('d/m/Y') }}
                            @if($article->author)
                                {{ __('messages.articles.by') }} {{ $article->author }}
                            @endif
                        </p>
                        <div class="prose prose-sm mb-4">
                            {!! Str::limit(strip_tags($article->content), 150) !!}
                        </div>
                        <a href="{{ route('articles.show', $article->slug) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            {{ __('messages.articles.read_more') }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $articles->links() }}
        </div>
    @endif
</div>
@endsection 