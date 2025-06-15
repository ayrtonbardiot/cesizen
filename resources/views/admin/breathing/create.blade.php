@extends('admin.layouts.app')

@section('title', __('messages.admin.breathing.actions.create'))

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">{{ __('messages.admin.breathing.actions.create') }}</h2>

            <form action="{{ route('admin.breathing.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">
                        {{ __('messages.admin.breathing.form.title') }}
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">
                        {{ __('messages.admin.breathing.form.description') }}
                    </label>
                    <textarea name="description" id="description" rows="3" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">
                        {{ __('messages.admin.breathing.form.category') }}
                    </label>
                    <select name="category_id" id="category_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">{{ __('messages.admin.breathing.form.select_category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">
                        {{ __('messages.admin.breathing.form.image') }}
                    </label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        {{ __('messages.admin.breathing.form.steps') }}
                    </label>
                    <div id="steps-container" class="mt-2 space-y-4">
                        <div class="step-item flex gap-4 items-start">
                            <div class="flex-1">
                                <select name="steps[0][type]" required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="inhale">{{ __('messages.admin.breathing.form.step_types.inhale') }}</option>
                                    <option value="exhale">{{ __('messages.admin.breathing.form.step_types.exhale') }}</option>
                                    <option value="hold">{{ __('messages.admin.breathing.form.step_types.hold') }}</option>
                                </select>
                            </div>
                            <div class="flex-1">
                                <input type="number" name="steps[0][duration]" min="1" required placeholder="{{ __('messages.admin.breathing.form.duration_placeholder') }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <button type="button" class="remove-step text-red-600 hover:text-red-900" style="display: none;">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <button type="button" id="add-step" class="mt-2 inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('messages.admin.breathing.form.add_step') }}
                    </button>
                    @error('steps')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">{{ __('messages.admin.breathing.form.is_active') }}</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.breathing.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('messages.common.actions.cancel') }}
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('messages.common.actions.create') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('steps-container');
            const addButton = document.getElementById('add-step');
            let stepCount = 1;

            addButton.addEventListener('click', function() {
                const stepItem = document.createElement('div');
                stepItem.className = 'step-item flex gap-4 items-start';
                stepItem.innerHTML = `
                    <div class="flex-1">
                        <select name="steps[${stepCount}][type]" required
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="inhale">{{ __('messages.admin.breathing.form.step_types.inhale') }}</option>
                            <option value="exhale">{{ __('messages.admin.breathing.form.step_types.exhale') }}</option>
                            <option value="hold">{{ __('messages.admin.breathing.form.step_types.hold') }}</option>
                        </select>
                    </div>
                    <div class="flex-1">
                        <input type="number" name="steps[${stepCount}][duration]" min="1" required placeholder="{{ __('messages.admin.breathing.form.duration_placeholder') }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <button type="button" class="remove-step text-red-600 hover:text-red-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                `;
                container.appendChild(stepItem);
                stepCount++;

                // Afficher le bouton de suppression pour tous les éléments sauf le premier
                const removeButtons = container.querySelectorAll('.remove-step');
                removeButtons.forEach(button => {
                    button.style.display = removeButtons.length > 1 ? 'block' : 'none';
                });
            });

            container.addEventListener('click', function(e) {
                if (e.target.closest('.remove-step')) {
                    const stepItem = e.target.closest('.step-item');
                    stepItem.remove();

                    // Réindexer les étapes
                    const steps = container.querySelectorAll('.step-item');
                    steps.forEach((step, index) => {
                        step.querySelector('select').name = `steps[${index}][type]`;
                        step.querySelector('input').name = `steps[${index}][duration]`;
                    });

                    // Afficher/masquer le bouton de suppression
                    const removeButtons = container.querySelectorAll('.remove-step');
                    removeButtons.forEach(button => {
                        button.style.display = removeButtons.length > 1 ? 'block' : 'none';
                    });
                }
            });
        });
    </script>
    @endpush
@endsection 