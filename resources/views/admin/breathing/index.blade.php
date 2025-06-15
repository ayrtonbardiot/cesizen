@extends('admin.layouts.app')

@section('title', __('messages.admin.breathing.title'))

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-900">{{ __('messages.admin.breathing.title') }}</h2>
                <a href="{{ route('admin.breathing.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('messages.admin.breathing.actions.create') }}
                </a>
            </div>

            <!-- Filtres -->
            <div class="mb-6">
                <form action="{{ route('admin.breathing.index') }}" method="GET" class="flex gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.admin.breathing.search.placeholder') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <select name="category" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">{{ __('messages.admin.breathing.search.all_categories') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">{{ __('messages.admin.breathing.search.all_status') }}</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>{{ __('messages.admin.breathing.status.active') }}</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>{{ __('messages.admin.breathing.status.inactive') }}</option>
                        </select>
                    </div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('messages.admin.breathing.search.filter') }}
                    </button>
                </form>
            </div>

            <!-- Liste des exercices -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.admin.breathing.table.title') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.admin.breathing.table.category') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.admin.breathing.table.duration') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.admin.breathing.table.status') }}
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">{{ __('messages.admin.breathing.table.actions') }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($exercises as $exercise)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($exercise->image)
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ Storage::url($exercise->image) }}" alt="{{ $exercise->title }}">
                                            </div>
                                        @else
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-indigo-100">
                                                    <span class="text-sm font-medium leading-none text-indigo-600">
                                                        {{ substr($exercise->title, 0, 1) }}
                                                    </span>
                                                </span>
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $exercise->title }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $exercise->category->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @php
                                            $totalDuration = 0;
                                            if (is_array($exercise->steps)) {
                                                foreach ($exercise->steps as $step) {
                                                    $totalDuration += $step['duration'];
                                                }
                                            }
                                        @endphp
                                        {{ $totalDuration }}s
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $exercise->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $exercise->is_active ? __('messages.admin.breathing.status.active') : __('messages.admin.breathing.status.inactive') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.breathing.show', $exercise) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        {{ __('messages.admin.breathing.actions.show') }}
                                    </a>
                                    <a href="{{ route('admin.breathing.edit', $exercise) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        {{ __('messages.admin.breathing.actions.edit') }}
                                    </a>
                                    <form action="{{ route('admin.breathing.destroy', $exercise) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('messages.admin.breathing.actions.delete_confirm') }}')">
                                            {{ __('messages.admin.breathing.actions.delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    {{ __('messages.admin.breathing.table.no_exercises') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($exercises->hasPages())
                <div class="mt-6">
                    {{ $exercises->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection 