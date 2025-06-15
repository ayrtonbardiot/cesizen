@extends('admin.layouts.app')

@section('title', __('messages.admin.breathing.actions.show'))

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">{{ __('messages.admin.breathing.actions.show') }}</h2>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        {{ __('messages.admin.breathing.form.title') }}
                    </label>
                    <p class="mt-1 text-gray-900">{{ $breathing->title }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        {{ __('messages.admin.breathing.form.description') }}
                    </label>
                    <p class="mt-1 text-gray-900 whitespace-pre-line">{{ $breathing->description }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        {{ __('messages.admin.breathing.form.category') }}
                    </label>
                    <p class="mt-1 text-gray-900">{{ $breathing->category->name ?? '-' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        {{ __('messages.admin.breathing.form.image') }}
                    </label>
                    @if($breathing->image)
                        <img src="{{ asset('storage/' . $breathing->image) }}" alt="{{ $breathing->title }}" class="mt-2 w-64 rounded-md shadow">
                    @else
                        <p class="mt-1 text-gray-500 italic">Aucune image</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        {{ __('messages.admin.breathing.form.steps') }}
                    </label>
                    <ul class="mt-2 space-y-2">
                        @foreach($breathing->steps as $index => $step)
                            <li class="flex gap-4">
                                <span class="flex-1 text-gray-900 font-medium">
                                    {{ __('messages.admin.breathing.form.step_types.' . $step['type']) }}
                                </span>
                                <span class="flex-1 text-gray-700">
                                    {{ $step['duration'] }} {{ __('messages.admin.breathing.form.seconds') }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        {{ __('messages.admin.breathing.form.is_active') }}
                    </label>
                    <p class="mt-1 text-gray-900">
                        {{ $breathing->is_active ? __('messages.common.status.active') : __('messages.common.status.inactive') }}
                    </p>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('admin.breathing.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('messages.admin.breathing.actions.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
