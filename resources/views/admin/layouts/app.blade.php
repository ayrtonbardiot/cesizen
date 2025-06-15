<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ config('app.name') }} - Admin - @yield('title')</title>
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
    @include('admin.partials.navigation')

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

        /* Styles pour les inputs et formulaires */
        .form-input,
        .form-select,
        .form-textarea {
            @apply w-full px-4 py-3 text-base border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500;
        }

        /* Style pour les boutons */
        .btn-primary {
            @apply inline-flex items-center px-6 py-3 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500;
        }

        .btn-secondary {
            @apply inline-flex items-center px-6 py-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500;
        }

        /* Style pour les labels */
        .form-label {
            @apply block text-sm font-medium text-gray-700 mb-2;
        }

        /* Style pour les groupes de formulaire */
        .form-group {
            @apply mb-6;
        }

        /* Style pour les messages d'erreur */
        .error-message {
            @apply mt-2 text-sm text-red-600;
        }

        /* Style pour les tableaux */
        .table-container {
            @apply overflow-x-auto;
        }

        .admin-table {
            @apply min-w-full divide-y divide-gray-200;
        }

        .admin-table th {
            @apply px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider;
        }

        .admin-table td {
            @apply px-6 py-4 whitespace-nowrap text-sm text-gray-900;
        }

        /* Style pour les cartes */
        .card {
            @apply bg-white overflow-hidden shadow-sm rounded-lg;
        }

        .card-header {
            @apply px-6 py-4 border-b border-gray-200;
        }

        .card-body {
            @apply p-6;
        }

        /* Style pour les badges */
        .badge {
            @apply inline-flex items-center px-3 py-1 rounded-full text-xs font-medium;
        }

        .badge-success {
            @apply bg-green-100 text-green-800;
        }

        .badge-warning {
            @apply bg-yellow-100 text-yellow-800;
        }

        .badge-danger {
            @apply bg-red-100 text-red-800;
        }

        /* Style pour les boutons d'action */
        .action-button {
            @apply inline-flex items-center px-4 py-2 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2;
        }

        .action-button-edit {
            @apply text-indigo-600 hover:text-indigo-900 focus:ring-indigo-500;
        }

        .action-button-delete {
            @apply text-red-600 hover:text-red-900 focus:ring-red-500;
        }

        /* Style pour les étapes d'exercice */
        .exercise-step {
            @apply flex items-center space-x-4 p-4 bg-gray-50 rounded-lg mb-4;
        }

        .exercise-step-input {
            @apply flex-1;
        }

        .exercise-step-actions {
            @apply flex items-center space-x-2;
        }

        /* Style pour les filtres */
        .filter-container {
            @apply flex flex-wrap gap-4 mb-6;
        }

        .filter-group {
            @apply flex-1 min-w-[200px];
        }

        /* Style pour la pagination */
        .pagination {
            @apply flex items-center justify-between mt-6;
        }

        .pagination-info {
            @apply text-sm text-gray-700;
        }

        .pagination-links {
            @apply flex items-center space-x-2;
        }

        .pagination-link {
            @apply px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50;
        }

        .pagination-link-active {
            @apply bg-indigo-600 text-white hover:bg-indigo-700;
        }
    </style>

    @stack('scripts')
    @RegisterServiceWorkerScript
</body>
</html> 