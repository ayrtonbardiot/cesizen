@extends('layout.layout')

@section('title', __('messages.breathing.title'))

@section('content')
    <div class="space-y-8">
        <!-- En-tête -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-lg" data-aos="fade-up">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ __('messages.breathing.title') }}</h1>
            <p class="text-gray-700 mt-2">{{ __('messages.breathing.subtitle') }}</p>
        </div>

        <!-- Filtres -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-lg" data-aos="fade-up" data-aos-delay="100">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ __('messages.breathing.filters.title') }}</h2>
            <form action="{{ route('breathing.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.breathing.filters.category') }}</label>
                    <select name="category" id="category"
                            class="w-full rounded-xl border-2 p-3 border-gray-200 focus:border-gray-900 transition-colors duration-200 text-base">
                        <option value="">{{ __('messages.breathing.filters.all_categories') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                            class="w-full bg-gray-900 text-nav px-6 py-3 rounded-xl font-medium hover:bg-gray-800 transition-colors duration-200 text-base">
                        {{ __('messages.breathing.filters.filter') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Liste des exercices -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-aos="fade-up" data-aos-delay="200">
            @forelse($exercises as $exercise)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-200">
                    @if($exercise->image_path)
                        <img src="{{ asset('storage/' . $exercise->image_path) }}" alt="{{ $exercise->title }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $exercise->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($exercise->description, 100) }}</p>
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-700">
                                {{ $exercise->category->name }}
                            </span>
                            <a href="{{ route('breathing.show', $exercise) }}"
                               class="bg-gray-900 text-nav px-6 py-3 rounded-xl font-medium hover:bg-gray-800 transition-colors duration-200">
                                {{ __('messages.breathing.exercise.start') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12" data-aos="fade-up">
                    <p class="text-gray-500">{{ __('messages.breathing.exercise.not_found') }}</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($exercises->hasPages())
            <div class="mt-8" data-aos="fade-up">
                {{ $exercises->links() }}
            </div>
        @endif
    </div>
@endsection
