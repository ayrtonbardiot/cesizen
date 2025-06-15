@extends('layout.layout')

@section('title', __('auth.verify_email_title'))

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {{ __('auth.verify_email_title') }}
            </h2>
            <div class="mt-4 text-center text-gray-600">
                <p>{{ __('auth.verify_email_message') }}</p>
                <p class="mt-2">{{ __('auth.verify_email_instructions') }}</p>
            </div>
        </div>

        <div class="mt-8 space-y-6">
            <div class="rounded-md shadow-sm -space-y-px">
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>

            <div class="flex items-center justify-center">
                <form method="POST" action="{{ route('verification.send') }}" class="text-sm">
                    @csrf
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('auth.resend_verification_email') }}
                    </button>
                </form>
            </div>

            <div class="text-center text-sm">
                <a href="{{ route('logout') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    {{ __('auth.logout') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 