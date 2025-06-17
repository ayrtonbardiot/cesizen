@extends('layout.layout')

@section('title', $exercise->title)

@section('content')
<div class="space-y-8">
    <!-- Bouton retour -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-lg" data-aos="fade-up">
        <a href="{{ route('breathing.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 text-sm font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('messages.breathing.exercise.back_to_list') }}
        </a>
    </div>

    <!-- Contenu principal -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
        @if($exercise->image_path)
            <img src="{{ asset('storage/' . $exercise->image_path) }}" alt="{{ $exercise->title }}" class="w-full h-64 object-cover">
        @endif

        <div class="p-6 sm:p-8 space-y-6">
            <h1 class="text-3xl font-bold text-gray-900">{{ $exercise->title }}</h1>

            <div class="flex flex-wrap gap-2">
                <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm">
                    {{ $exercise->category->name }}
                </span>
            </div>

            <div class="prose max-w-none">
                <h2 class="text-xl font-semibold text-gray-900">{{ __('messages.breathing.exercise.instructions') }}</h2>
                <p>{{ $exercise->description }}</p>
            </div>

            <div class="bg-gray-50 rounded-xl p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ __('messages.breathing.exercise.information') }}</h2>
                <div class="space-y-4">
                    @foreach($exercise->steps as $index => $step)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-800 font-semibold">
                                {{ $index + 1 }}
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-900 font-medium">{{ $step['text'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center">
                <button id="startExercise"
                        class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-semibold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    {{ __('messages.breathing.exercise.start_exercise') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="exerciseModal" class="fixed inset-0 z-50 bg-opacity-60 flex items-center justify-center p-4 hidden backdrop-blur-md">
    <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10 md:p-12 max-w-3xl w-full mx-auto transform transition-all">
        <div id="exerciseContent" class="text-center">
            <h2 id="exerciseStep" class="text-4xl sm:text-5xl font-extrabold text-gray-900 mb-6"></h2>

            <div class="relative w-60 h-60 mx-auto mb-10 flex items-center justify-center rounded-full bg-gray-900 animate-breathing-circle">
                <p id="exerciseTimer" class="text-5xl font-extrabold text-white leading-none"></p>
            </div>

            <p id="exerciseInstruction" class="text-lg text-gray-700 mb-8 leading-relaxed"></p>

            <button id="stopExercise"
                    class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-semibold rounded-xl text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                {{ __('messages.breathing.exercise.stop_exercise') }}
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('exerciseModal');
    const startButton = document.getElementById('startExercise');
    const stopButton = document.getElementById('stopExercise');
    const stepElement = document.getElementById('exerciseStep');
    const timerElement = document.getElementById('exerciseTimer');
    const instructionElement = document.getElementById('exerciseInstruction');

    let currentStep = 0;
    let timer = null;
    let timeLeft = 0;
    const steps = @json($exercise->steps);

    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remaining = seconds % 60;
        return `${String(minutes).padStart(2, '0')}:${String(remaining).padStart(2, '0')}`;
    }

    function updateStep() {
        if (currentStep >= steps.length) {
            clearInterval(timer);
            modal.classList.add('hidden');

            fetch('/api/breathing/session', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    exercise_id: {{ $exercise->id }},
                    duration: steps.reduce((sum, step) => sum + (step.duration || 0), 0)
                })
            });

            return;
        }

        const step = steps[currentStep];
        stepElement.textContent = step.type || '';
        timeLeft = step.duration || 0;
        timerElement.textContent = formatTime(timeLeft);
        instructionElement.textContent = step.text || '';

        clearInterval(timer);
        timer = setInterval(() => {
            timeLeft--;
            timerElement.textContent = formatTime(timeLeft);

            if (timeLeft <= 0) {
                clearInterval(timer);
                currentStep++;
                updateStep();
            }
        }, 1000);
    }

    startButton.addEventListener('click', () => {
        modal.classList.remove('hidden');
        currentStep = 0;
        updateStep();
    });

    stopButton.addEventListener('click', () => {
        clearInterval(timer);
        modal.classList.add('hidden');
    });
});
</script>
@endpush
@endsection
