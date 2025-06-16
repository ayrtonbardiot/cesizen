@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Statistiques -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('messages.admin.stats.users') }}</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $totalUsers ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('messages.admin.stats.exercises') }}</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $totalExercises ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('messages.admin.stats.sessions') }}</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $totalSessions ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- todo: compléter avec activités récentes sur l'admin?-->
@endsection 