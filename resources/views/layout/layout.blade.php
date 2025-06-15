<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ config('app.name') }} - @yield('title')</title>
    @vite('resources/css/app.css')
    @PwaHead
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    @stack('styles')
</head>
<body class="bg-gray-50 flex flex-col min-h-dvh">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:p-4 focus:bg-white focus:text-gray-900">
        {{ __('messages.accessibility.skip_to_content') }}
    </a>

    <!-- Navigation -->
    @include('layout/navbar')

    <!-- Main Content -->
    <main id="main-content" role="main" class="flex-grow py-6 sm:py-8 lg:py-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('info'))
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-md" role="alert" aria-live="polite">
                    <p class="text-blue-700">{{ session('info') }}</p>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-md" role="alert" aria-live="polite">
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md" role="alert" aria-live="polite">
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    @include('layout/footer')

    <script>
        // Mobile menu toggle
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
            this.setAttribute('aria-expanded', mobileMenu.classList.contains('hidden') ? 'false' : 'true');
        });

        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            disable: 'mobile'
        });
    </script>

    <style>
        /* Amélioration du focus visible */
        :focus-visible {
            outline: 2px solid #000;
            outline-offset: 2px;
        }
        /* Contraste amélioré pour le texte */
        .text-gray-700 {
            color: #374151;
        }
    </style>

    @stack('scripts')
    @RegisterServiceWorkerScript
</body>
</html>
