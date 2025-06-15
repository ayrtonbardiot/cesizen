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

    <!-- Activité récente -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ __('messages.admin.recent_activity') }}</h2>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if(isset($recentActivities) && count($recentActivities) > 0)
                    <div class="space-y-4">
                        @foreach($recentActivities as $activity)
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-100">
                                        <span class="text-sm font-medium leading-none text-indigo-600">
                                            {{ $activity->user ? substr($activity->user->name, 0, 1) : 'A' }}
                                        </span>
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $activity->user ? $activity->user->name : __('messages.admin.anonymous_user') }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $activity->description }}
                                    </p>
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $activity->created_at->diffForHumans() }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">{{ __('messages.admin.no_recent_activity') }}</p>
                @endif
            </div>
        </div>
    </div>
@endsection 