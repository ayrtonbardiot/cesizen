@extends('admin.layouts.app')

@section('title', __('messages.admin.settings.title'))

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">{{ __('messages.admin.settings.title') }}</h2>

            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Paramètres généraux -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('messages.admin.settings.general.title') }}</h3>
                    
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700">
                            {{ __('messages.admin.settings.general.site_name') }}
                        </label>
                        <input type="text" name="site_name" id="site_name" value="{{ old('site_name', $settings->site_name ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('site_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="site_description" class="block text-sm font-medium text-gray-700">
                            {{ __('messages.admin.settings.general.site_description') }}
                        </label>
                        <textarea name="site_description" id="site_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('site_description', $settings->site_description ?? '') }}</textarea>
                        @error('site_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Paramètres de contact -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('messages.admin.settings.contact.title') }}</h3>
                    
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700">
                            {{ __('messages.admin.settings.contact.email') }}
                        </label>
                        <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $settings->contact_email ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('contact_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700">
                            {{ __('messages.admin.settings.contact.phone') }}
                        </label>
                        <input type="tel" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', $settings->contact_phone ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('contact_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Paramètres de maintenance -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('messages.admin.settings.maintenance.title') }}</h3>
                    
                    <div class="flex items-center">
                        <input type="checkbox" name="maintenance_mode" id="maintenance_mode" value="1" {{ old('maintenance_mode', $settings->maintenance_mode ?? false) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="maintenance_mode" class="ml-2 block text-sm text-gray-900">
                            {{ __('messages.admin.settings.maintenance.mode') }}
                        </label>
                    </div>

                    <div>
                        <label for="maintenance_message" class="block text-sm font-medium text-gray-700">
                            {{ __('messages.admin.settings.maintenance.message') }}
                        </label>
                        <textarea name="maintenance_message" id="maintenance_message" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('maintenance_message', $settings->maintenance_message ?? '') }}</textarea>
                        @error('maintenance_message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('messages.admin.settings.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection 