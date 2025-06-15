@extends('layout.layout')

@section('title', __('messages.profile.title'))

@section('content')
    <div class="space-y-8">
        <!-- En-tête du profil -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-lg" data-aos="fade-up">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ __('messages.profile.title') }}</h1>
                    <p class="text-gray-700 mt-2">{{ __('messages.profile.subtitle') }}</p>
                </div>
            </div>
        </div>

        <!-- Informations du profil -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Informations personnelles -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Informations de base -->
                <div class="bg-white rounded-2xl p-6 shadow-lg" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('messages.profile.personal_info.title') }}</h2>
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('messages.profile.personal_info.name') }}
                                </label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       value="{{ old('name', $user->name) }}"
                                       class="w-full rounded-xl border-2 p-3 @error('name') border-red-500 bg-red-50 @else border-gray-200 focus:border-gray-900 @enderror transition-colors duration-200"
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('messages.profile.personal_info.email') }}
                                </label>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       value="{{ old('email', $user->email) }}"
                                       class="w-full rounded-xl border-2 p-3 @error('email') border-red-500 bg-red-50 @else border-gray-200 focus:border-gray-900 @enderror transition-colors duration-200"
                                       required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    class="bg-gray-900 text-nav px-6 py-3 rounded-xl font-medium hover:bg-gray-800 transition-colors duration-200">
                                {{ __('messages.profile.personal_info.save') }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Changement de mot de passe -->
                <div class="bg-white rounded-2xl p-6 shadow-lg" data-aos="fade-up" data-aos-delay="200">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('messages.profile.password.title') }}</h2>
                    <form action="{{ route('profile.password') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('messages.profile.password.current') }}
                            </label>
                            <input type="password"
                                   name="current_password"
                                   id="current_password"
                                   class="w-full rounded-xl border-2 p-3 @error('current_password') border-red-500 bg-red-50 @else border-gray-200 focus:border-gray-900 @enderror transition-colors duration-200"
                                   required>
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('messages.profile.password.new') }}
                                </label>
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="w-full rounded-xl border-2 p-3 @error('password') border-red-500 bg-red-50 @else border-gray-200 focus:border-gray-900 @enderror transition-colors duration-200"
                                       required>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('messages.profile.password.confirm') }}
                                </label>
                                <input type="password"
                                       name="password_confirmation"
                                       id="password_confirmation"
                                       class="w-full rounded-xl border-2 p-3 @error('password_confirmation') border-red-500 bg-red-50 @else border-gray-200 focus:border-gray-900 @enderror transition-colors duration-200"
                                       required>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    class="bg-gray-900 text-nav px-6 py-3 rounded-xl font-medium hover:bg-gray-800 transition-colors duration-200">
                                {{ __('messages.profile.password.update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Statistiques -->
                <div class="bg-white rounded-2xl p-6 shadow-lg" data-aos="fade-up" data-aos-delay="300">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('messages.profile.stats.title') }}</h2>
                    <div class="space-y-4">
                        <div class="bg-nav rounded-xl p-4">
                            <p class="text-sm text-gray-700">{{ __('messages.profile.stats.member_since') }}</p>
                            <p class="text-lg font-bold text-gray-900 mt-1">{{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div class="bg-nav rounded-xl p-4">
                            <p class="text-sm text-gray-700">{{ __('messages.profile.stats.last_login') }}</p>
                            <p class="text-lg font-bold text-gray-900 mt-1">{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : __('messages.profile.stats.never') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Téléchargement des données -->
                <div class="bg-white rounded-2xl p-6 shadow-lg" data-aos="fade-up" data-aos-delay="350">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('messages.profile.download.title') }}</h2>
                    <p class="text-gray-700 mb-6">{{ __('messages.profile.download.description') }}</p>
                    <a href="{{ route('profile.download-data') }}"
                       class="block w-full bg-gray-900 text-nav px-6 py-3 rounded-xl font-medium hover:bg-gray-800 transition-colors duration-200 text-center">
                        {{ __('messages.profile.download.button') }}
                    </a>
                </div>

                <!-- Suppression du compte -->
                <div class="bg-white rounded-2xl p-6 shadow-lg" data-aos="fade-up" data-aos-delay="400">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('messages.profile.delete.title') }}</h2>
                    <p class="text-gray-700 mb-6">{{ __('messages.profile.delete.warning') }}</p>
                    <form action="{{ route('profile.delete') }}" method="POST" onsubmit="return confirm('{{ __('messages.profile.delete.confirm') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full bg-red-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-red-700 transition-colors duration-200">
                            {{ __('messages.profile.delete.button') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
