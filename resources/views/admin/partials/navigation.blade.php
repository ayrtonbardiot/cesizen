<nav class="bg-nav shadow-lg" role="navigation" aria-label="{{ __('messages.navigation.admin') }}">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-24">
            <div class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <img src="/assets/img/banner.png" alt="{{ config('app.name') }}" class="h-20 w-auto">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-white text-gray-900' : '' }}">
                    {{ __('messages.dashboard.title') }}
                </a>
                <a href="{{ route('admin.users.index') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'bg-white text-gray-900' : '' }}">
                    {{ __('messages.users.title') }}
                </a>
                <a href="{{ route('admin.breathing.index') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.breathing.*') ? 'bg-white text-gray-900' : '' }}">
                    {{ __('messages.admin.breathing.title') }}
                </a>
                <a href="{{ route('admin.articles.index') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.articles.*') ? 'bg-white text-gray-900' : '' }}">
                    {{ __('messages.admin.articles.title') }}
                </a>
                <a href="{{ route('admin.pages.index') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.pages.*') ? 'bg-white text-gray-900' : '' }}">
                    {{ __('messages.admin.pages.title') }}
                </a>
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                    {{ __('messages.navigation.back_to_site') }}
                </a>
                <a href="{{ route('logout') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                    {{ __('messages.auth.logout') }}
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="sm:hidden flex items-center">
                <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-900" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">{{ __('messages.navigation.open_menu') }}</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="sm:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-nav text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">
                {{ __('messages.dashboard.title') }}
            </a>
            <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.users.*') ? 'bg-nav text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">
                {{ __('messages.users.title') }}
            </a>
            <a href="{{ route('admin.breathing.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.breathing.*') ? 'bg-nav text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">
                {{ __('messages.admin.breathing.title') }}
            </a>            
            <a href="{{ route('admin.articles.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.articles.*') ? 'bg-nav text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">                
                {{ __('messages.admin.articles.title') }}
            </a>
            <a href="{{ route('admin.articles.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.pages.*') ? 'bg-nav text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">                
                {{ __('messages.admin.articles.title') }}
            </a>
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                {{ __('messages.navigation.back_to_site') }}
            </a>
            <a href="{{ route('logout') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                {{ __('messages.auth.logout') }}
            </a>
        </div>
    </div>
</nav> 