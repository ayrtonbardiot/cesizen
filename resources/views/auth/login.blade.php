<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ config('app.name') }} - {{ __('messages.login.title') }}</title>
    @PwaHead
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
</head>
<body class="bg-nav min-h-dvh">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:p-4 focus:bg-white focus:text-gray-900">
        {{ __('messages.accessibility.skip_to_content') }}
    </a>
    <main id="main-content" role="main">
        <div class="min-h-dvh flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl p-6 sm:p-8 lg:p-10 shadow-xl w-full max-w-4xl" data-aos="fade-up">
                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="lg:w-2/5 flex flex-col items-center justify-center gap-4 text-center">
                        <img alt="Logo de CESIZen" src="/assets/img/logo.png" class="w-32 h-32 sm:w-40 sm:h-40 lg:w-48 lg:h-48 object-contain animate-float">
                        <p class="text-gray-700 text-lg">{{ __('messages.login.subtitle') }}</p>
                    </div>
                    <div class="lg:w-3/5">
                        @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md" role="alert" aria-live="polite">
                            <h2 class="sr-only">{{ __('messages.accessibility.error_summary') }}</h2>
                            <ul class="text-red-700 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-6">{{ __('messages.login.title') }}</h1>
                        <form novalidate action="{{ route('login.post') }}" method="post" class="flex flex-col gap-4" aria-labelledby="login-title">
                            @csrf
                            <div class="flex flex-col gap-2">
                                <label for="email" class="text-gray-700 font-medium">{{ __('messages.login.email') }}</label>
                                <input class="w-full rounded-xl border-2 p-3 @error('email') border-red-500 bg-red-50 @else border-gray-200 focus:border-gray-900 @enderror transition-colors duration-200" 
                                       type="email" 
                                       name="email" 
                                       id="email"
                                       value="{{ old('email') }}"
                                       required
                                       aria-required="true"
                                       aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                                       aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}">
                                @error('email')
                                    <span id="email-error" class="text-red-700 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="password" class="text-gray-700 font-medium">{{ __('messages.login.password') }}</label>
                                <input class="w-full rounded-xl border-2 p-3 @error('password') border-red-500 bg-red-50 @else border-gray-200 focus:border-gray-900 @enderror transition-colors duration-200" 
                                       type="password" 
                                       name="password"
                                       id="password" 
                                       required
                                       aria-required="true"
                                       aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                                       aria-describedby="{{ $errors->has('password') ? 'password-error' : '' }}">
                                @error('password')
                                    <span id="password-error" class="text-red-700 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" 
                                    class="w-full bg-gray-900 text-nav p-4 rounded-xl font-bold hover:bg-gray-800 transition-all duration-300 transform hover:scale-[1.02] shadow-lg mt-2"
                                    aria-label="{{ __('messages.login.submit') }}">
                                {{ __('messages.login.submit') }}
                            </button>
                        </form>
                        <a href="{{ route('register') }}" 
                           class="w-full bg-transparent border-2 border-gray-900 text-gray-900 p-4 rounded-xl font-bold hover:bg-gray-900/10 transition-all duration-300 transform hover:scale-[1.02] block text-center mt-4"
                           aria-label="{{ __('messages.login.register_link') }}">
                            {{ __('messages.login.register_link') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        AOS.init({
            duration: 1000,
            once: true,
            disable: 'mobile'
        });
    </script>
    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
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
    @RegisterServiceWorkerScript 
</body>
</html>
