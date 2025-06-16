@extends('layout.layout')

@section('title', $page->title)

@section('content')
    <div class="space-y-8">
        <!-- En-tête -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-lg" data-aos="fade-up">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $page->title }}</h1>
        </div>

        <!-- Contenu -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-lg prose prose-indigo max-w-none" data-aos="fade-up" data-aos-delay="100">
            {!! $page->content !!}
        </div>
    </div>
@endsection