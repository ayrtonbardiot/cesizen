<footer class="bg-gray-900 text-white py-8 sm:py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 sm:gap-0">
                <div class="text-center sm:text-left">
                    <p class="text-sm sm:text-base text-gray-400">{{ __('messages.footer.copyright') }}</p>
                </div>
                <div class="flex gap-4 sm:gap-8">
                    <a href="{{ route('pages.show', 'a-propos') }}" class="text-sm sm:text-base text-gray-400 hover:text-nav transition-colors duration-300">{{ __('messages.footer.about') }}</a>
                    <a href="{{ route('pages.show', 'contact') }}" class="text-sm sm:text-base text-gray-400 hover:text-nav transition-colors duration-300">{{ __('messages.footer.contact') }}</a>
                    <a href="{{ route('pages.show', 'conditions-utilisation') }}" class="text-sm sm:text-base text-gray-400 hover:text-nav transition-colors duration-300">{{ __('messages.footer.terms') }}</a>
                    <a href="{{ route('pages.show', 'politique-confidentialite') }}" class="text-sm sm:text-base text-gray-400 hover:text-nav transition-colors duration-300">{{ __('messages.footer.privacy') }}</a>
                </div>
            </div>
        </div>
    </footer>