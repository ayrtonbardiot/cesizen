@extends('layout.layout')

@section('title', __('messages.dashboard.title'))

@section('content')
    <div class="space-y-8">
        <!-- En-tête du dashboard -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-lg" data-aos="fade-up">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ __('messages.dashboard.welcome', ['name' => $user->name]) }}</h1>
                    <p class="text-gray-700 mt-2">{{ __('messages.dashboard.subtitle') }}</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('breathing.index') }}" class="bg-nav text-gray-900 px-4 py-2 rounded-xl font-medium hover:bg-nav/80 transition-colors duration-200">
                        {{ __('messages.dashboard.start_breathing') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Grille des fonctionnalités -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Carte Exercices de respiration -->
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="bg-nav p-3 rounded-xl">
                        <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">{{ __('messages.dashboard.breathing.title') }}</h2>
                </div>
                <p class="text-gray-700 mb-4">{{ __('messages.dashboard.breathing.description') }}</p>
                <a href="{{ route('breathing.index') }}" class="text-gray-900 font-medium hover:text-gray-700 transition-colors duration-200 inline-flex items-center gap-2">
                    {{ __('messages.dashboard.breathing.start') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <!-- Carte Suivi des émotions -->
            <div class="bg-gray-100 rounded-2xl p-6 shadow-lg" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center gap-4 mb-4">
                    <div class="bg-gray-300 p-3 rounded-xl">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-500">{{ __('messages.dashboard.emotions.title') }}</h2>
                </div>
                <p class="text-gray-500 mb-4">{{ __('messages.dashboard.emotions.description') }}</p>
                <p class="text-gray-500 font-medium">{{ __('messages.dashboard.unavailable') }}</p>
            </div>

            <!-- Carte Activités de relaxation -->
            <div class="bg-gray-100 rounded-2xl p-6 shadow-lg" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-center gap-4 mb-4">
                    <div class="bg-gray-300 p-3 rounded-xl">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-500">{{ __('messages.dashboard.relaxation.title') }}</h2>
                </div>
                <p class="text-gray-500 mb-4">{{ __('messages.dashboard.relaxation.description') }}</p>
                <p class="text-gray-500 font-medium">{{ __('messages.dashboard.unavailable') }}</p>
            </div>
        </div>

        <!-- Section Statistiques -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-lg" data-aos="fade-up" data-aos-delay="400">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">{{ __('messages.dashboard.stats.title') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-nav rounded-xl p-4">
                    <p class="text-sm text-gray-700">{{ __('messages.dashboard.stats.breathing_sessions') }}</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{  $breathingTotal }}</p>
                </div>
                <div class="bg-gray-100 rounded-xl p-4">
                    <p class="text-sm text-gray-500">{{ __('messages.dashboard.stats.emotions_tracked') }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ __('messages.dashboard.unavailable') }}</p>
                </div>
                <div class="bg-gray-100 rounded-xl p-4">
                    <p class="text-sm text-gray-500">{{ __('messages.dashboard.stats.relaxation_time') }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ __('messages.dashboard.unavailable') }}</p>
                </div>
                <div class="bg-nav rounded-xl p-4">
                    <p class="text-sm text-gray-700">{{ __('messages.dashboard.stats.streak') }}</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $currentStreak }} {{ __('messages.dashboard.stats.days') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection


