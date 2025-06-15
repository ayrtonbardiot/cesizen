<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ config('app.name') }} - {{ __('messages.index.title') }}</title>
    @vite('resources/css/app.css')
    @PwaHead
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
</head>
<body class="bg-gray-50">
    <main>
        <!-- Section hero -->
        <section class="min-h-screen bg-nav relative overflow-hidden">
            <div class="absolute inset-0 bg-grid-black/[0.05] bg-[size:60px_60px]"></div>
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20 relative">
                <div class="flex flex-col items-center text-center">
                    <img src="assets/img/logo.png" class="w-32 h-32 sm:w-40 sm:h-40 lg:w-48 lg:h-48 object-contain animate-float" alt="{{ __('messages.index.hero.image_alt') }}">
                    <h1 class="text-4xl sm:text-5xl lg:text-7xl font-bold text-gray-900 mb-4 sm:mb-6 leading-tight">
                        {{ __('messages.index.hero.main_text') }}
                    </h1>
                    <p class="text-lg sm:text-xl text-gray-700 max-w-xs sm:max-w-md lg:max-w-2xl px-4">
                        {{ __('messages.index.hero.paragraph') }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 mt-6 sm:mt-8 w-full sm:w-auto px-4 sm:px-0">
                        <a href="{{ route('login') }}" 
                           class="w-full sm:w-auto bg-gray-900 text-nav px-6 sm:px-8 py-3 sm:py-4 rounded-full font-bold hover:bg-gray-800 transition-all duration-300 transform hover:scale-105 shadow-lg text-center">
                            {{ __('messages.login.title') }}
                        </a>
                        <a href="{{ route('register') }}" 
                           class="w-full sm:w-auto bg-transparent border-2 border-gray-900 text-gray-900 px-6 sm:px-8 py-3 sm:py-4 rounded-full font-bold hover:bg-gray-900/10 transition-all duration-300 transform hover:scale-105 text-center">
                            {{ __('messages.register.title') }}
                        </a>
                    </div>
                </div>
            </div>
            <!-- Indicateur de défilement -->
            <div class="absolute bottom-4 sm:bottom-6 lg:bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                <div class="flex flex-col items-center text-gray-900">
                    <span class="text-sm sm:text-base lg:text-lg font-medium mb-1 sm:mb-2">{{ __('messages.index.hero.arrow_text') }}</span>
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>
            </div>
        </section>

        <!-- Section Exercices de respiration -->
        <section class="py-12 sm:py-16 lg:py-20 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12" data-aos="fade-up">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">{{ __('messages.breathing.title') }}</h2>
                    <p class="text-lg sm:text-xl text-gray-700 max-w-2xl mx-auto">{{ __('messages.breathing.subtitle') }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($breathingExercises as $exercise)
                        <div class="bg-nav rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-200" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                            @if($exercise->image_path)
                                <img src="{{ asset('storage/' . $exercise->image_path) }}" alt="{{ $exercise->title }}" class="w-full h-48 object-cover">
                            @endif
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $exercise->title }}</h3>
                                <p class="text-gray-700 mb-4">{{ Str::limit($exercise->description, 100) }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="px-3 py-1 text-sm rounded-full bg-gray-900/10 text-gray-900">
                                        {{ $exercise->category->name }}
                                    </span>
                                    <a href="{{ route('breathing.show', $exercise) }}" class="bg-gray-900 text-nav px-6 py-3 rounded-xl font-medium hover:bg-gray-800 transition-colors duration-200">
                                        {{ __('messages.breathing.exercise.start') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-12" data-aos="fade-up">
                    <a href="{{ route('breathing.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        {{ __('messages.breathing.exercise.view_all') }}
                        <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Séparateur -->
        <div class="relative py-12">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center">
                <span class="bg-white px-4 text-gray-500">
                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </span>
            </div>
        </div>

        <!-- Section témoignages -->
        <section class="py-12 sm:py-16 lg:py-20 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-center mb-8 sm:mb-12 lg:mb-16 text-gray-900" data-aos="fade-up">
                    {{ __('messages.index.testimonials.title') }}
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    <div class="bg-nav rounded-2xl p-6 sm:p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                        <div class="flex flex-col items-center">
                            <img class="w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32 rounded-full object-cover mb-4 sm:mb-6 ring-4 ring-white" src="assets/img/logo_alt.png" alt="{{ __('messages.index.testimonials.testimonial_1.name') }}">
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-3 sm:mb-4">{{ __('messages.index.testimonials.testimonial_1.name') }}</h3>
                            <p class="text-sm sm:text-base text-gray-700 text-center leading-relaxed">{{ __('messages.index.testimonials.testimonial_1.text') }}</p>
                        </div>
                    </div>
                    <div class="bg-nav rounded-2xl p-6 sm:p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                        <div class="flex flex-col items-center">
                            <img class="w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32 rounded-full object-cover mb-4 sm:mb-6 ring-4 ring-white" src="assets/img/logo_alt.png" alt="{{ __('messages.index.testimonials.testimonial_2.name') }}">
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-3 sm:mb-4">{{ __('messages.index.testimonials.testimonial_2.name') }}</h3>
                            <p class="text-sm sm:text-base text-gray-700 text-center leading-relaxed">{{ __('messages.index.testimonials.testimonial_2.text') }}</p>
                        </div>
                    </div>
                    <div class="bg-nav rounded-2xl p-6 sm:p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                        <div class="flex flex-col items-center">
                            <img class="w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32 rounded-full object-cover mb-4 sm:mb-6 ring-4 ring-white" src="assets/img/logo_alt.png" alt="{{ __('messages.index.testimonials.testimonial_3.name') }}">
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-3 sm:mb-4">{{ __('messages.index.testimonials.testimonial_3.name') }}</h3>
                            <p class="text-sm sm:text-base text-gray-700 text-center leading-relaxed">{{ __('messages.index.testimonials.testimonial_3.text') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section CTA -->
        <section class="py-12 sm:py-16 lg:py-20 bg-nav">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-up">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-4 sm:mb-6">{{ __('messages.index.cta.title') }}</h2>
                <p class="text-lg sm:text-xl text-gray-700 max-w-xs sm:max-w-md lg:max-w-2xl mx-auto px-4">{{ __('messages.index.cta.subtitle') }}</p>
                <a href="{{ route('register') }}" 
                   class="inline-block mt-8 bg-gray-900 text-nav px-8 py-4 rounded-full font-bold hover:bg-gray-800 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    {{ __('messages.index.cta.button') }}
                </a>
            </div>
        </section>
    </main>

    @include('layout/footer')

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
    </style>

@RegisterServiceWorkerScript
</body>
</html>
