@extends('layouts.app')

@section('title', $sectionTitle)

@section('content')
    <!-- Enhanced Progress Header -->
    <div class="mb-8">
        <div class="glass-card p-6">
            <div class="flex flex-col sm:flex-row items-center justify-between">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-2xl sm:text-3xl font-bold gradient-text mb-2">{{ $sectionTitle }}</h1>
                    <p class="text-gray-600">Sila jawab soalan berikut dengan jujur</p>
                </div>

                <!-- Enhanced Progress Indicator -->
                <div class="text-center">
                    <x-survey-progress :progress="$progress" size="large" />
                    <p class="text-sm text-gray-600 mt-2">Kemajuan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Question Card -->
    <div class="max-w-4xl mx-auto">
        <div class="glass-card overflow-hidden">
            <!-- Question Header -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-question text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Soalan</h3>
                            <p class="text-indigo-100 text-sm">Bahagian {{ $section }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold">#{{ $question['id'] }}</div>
                    </div>
                </div>
            </div>

            <!-- Question Content -->
            <div class="p-8">
                <div class="mb-8">
                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-4 leading-relaxed">
                        {!! $question['text_BM'] ?? $question['text'] !!}
                    </h2>

                    @if (isset($question['description_BM']))
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                            <p class="text-blue-700">{{ $question['description_BM'] }}</p>
                        </div>
                    @endif
                </div>

                <!-- Enhanced Answer Form -->
                <form method="POST" action="{{ route('survey.store', $section) }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $question['id'] }}">
                    @if (isset($question['image']))
                        @php
                            if ($question['type'] == 'image') {
                                $attr = '';
                            } else {
                                $attr = 'class="m-auto max-h-[150px]"';
                            }
                        @endphp
                        <a target="_blank" href="{{ $question['image'] }}" class=" w-full text-center"><img
                                {{ $attr }} src="{{ $question['image'] }}" alt="gambar" /></a>
                    @endif
                    @if ($question['type'] === 'single_choice')
                        <div class="space-y-4">
                            @foreach ($question['options'] as $index => $option)
                                @php
                                    $optionText = is_array($option) ? $option['text'] ?? '' : $option;
                                    $optionValue = $index;
                                    // Handle empty string options
                                    if ($optionText === '' || $optionText === null) {
                                        $optionText = 'Pilihan ' . ($index + 1);
                                    }
                                @endphp
                                <label class="block">
                                    <input type="radio" name="answer" value="{{ $optionValue }}" class="peer sr-only"
                                        required>
                                    <div
                                        class="relative flex items-center p-4 border-2 border-gray-200 rounded-xl
                                                cursor-pointer transition-all duration-300 hover:border-indigo-500
                                                hover:bg-indigo-50 hover:shadow-lg peer-checked:border-indigo-600
                                                peer-checked:bg-indigo-50 peer-checked:shadow-lg">
                                        <div
                                            class="radio-indicator w-6 h-6 border-2 border-gray-300 rounded-full mr-4
                                                    flex items-center justify-center transition-all duration-300">
                                            <div
                                                class="radio-dot w-3 h-3 bg-white rounded-full opacity-0 transition-all duration-300">
                                            </div>
                                        </div>
                                        <span class="text-gray-700 font-medium text-left">{{ $optionText }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @elseif($question['type'] === 'multiple_choice')
                        <div class="space-y-4">
                            @php
                                $existingAnswers = [];
                                if ($answer && $answer->answer) {
                                    $existingAnswers = is_array($answer->answer)
                                        ? $answer->answer
                                        : json_decode($answer->answer, true) ?? [];
                                }

                                // Helper function to decode JSON strings if needed
                                function decodeOptionText($option)
                                {
                                    if (is_string($option)) {
                                        $decoded = json_decode($option, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                            // If decoded is array, join elements as string
                                            return implode(', ', $decoded);
                                        } elseif (json_last_error() === JSON_ERROR_NONE && is_string($decoded)) {
                                            return $decoded;
                                        }
                                    }
                                    return $option;
                                }
                            @endphp
                            @foreach ($question['options'] as $index => $option)
                                @php
                                    $optionText = is_array($option) ? $option['text'] ?? '' : decodeOptionText($option);
                                    $optionValue = $index;
                                    // Handle empty string options
                                    if ($optionText === '' || $optionText === null) {
                                        $optionText = 'Pilihan ' . ($index + 1);
                                    }
                                @endphp
                                <label class="block">
                                    <input type="checkbox" name="answer[]" value="{{ $optionValue }}" class="peer sr-only"
                                        @if (in_array($optionValue, $existingAnswers)) checked @endif>
                                    <div
                                        class="relative flex items-center p-4 border-2 border-gray-200 rounded-xl
                            cursor-pointer transition-all duration-300 hover:border-indigo-500
                            hover:bg-indigo-50 hover:shadow-lg peer-checked:border-indigo-600
                            peer-checked:bg-indigo-50 peer-checked:shadow-lg">
                                        <div
                                            class="checkbox-indicator w-6 h-6 border-2 border-gray-300 rounded mr-4
                                flex items-center justify-center transition-all duration-300">
                                            <i
                                                class="fas fa-check text-white text-sm opacity-0 transition-all duration-300"></i>
                                        </div>
                                        <span class="text-gray-700 font-medium text-left">{{ $optionText }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @elseif($question['type'] === 'numeric')
                        <div class="space-y-4">
                            <label class="block">
                                <span class="text-gray-700 font-medium block mb-2">Masukkan nilai:</span>
                                <div class="relative">
                                    <input type="number" name="answer" class="form-input-enhanced w-full text-lg"
                                        placeholder="0" required>
                                    @if (isset($question['unit']))
                                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                                            {{ $question['unit'] }}
                                        </span>
                                    @endif
                                </div>
                            </label>
                        </div>
                    @elseif($question['type'] === 'text')
                        <div class="space-y-4">
                            <label class="block">
                                <span class="text-gray-700 font-medium block mb-2">Masukkan jawapan:</span>
                                <input type="text" name="answer" class="form-input-enhanced w-full text-lg"
                                    placeholder="Taip jawapan anda di sini" required>
                            </label>
                        </div>
                    @elseif($question['type'] === 'multiText')
                        <div class="space-y-4">
                            @php
                                $existingAnswers = [];
                                if ($answer && $answer->answer) {
                                    $existingAnswers = is_array($answer->answer)
                                        ? $answer->answer
                                        : json_decode($answer->answer, true) ?? [];
                                }
                            @endphp
                            <x-multi-text-input :questionId="$question['id']" label="Masukkan jawapan (boleh tambah lebih dari satu)" />
                        </div>
                    @elseif($question['type'] === 'scale')
                        <div class="space-y-4">
                            <label class="block">
                                <span class="text-gray-700 font-medium block mb-2">Masukkan jawapan:</span>

                                <div class="w-full">
                                    <input type="range" min="{{ $question['min'] }}" max="{{ $question['max'] }}"
                                        value="0" class="range w-full" step="1" name="answer" />
                                    <div class="flex justify-between px-2.5 mt-2 text-xs">
                                        @for ($i = $question['min']; $i <= $question['max']; $i++)
                                            <span>|</span>
                                        @endfor
                                    </div>
                                    <div class="flex justify-between px-2.5 mt-2 text-xs">
                                        @for ($i = $question['min']; $i <= $question['max']; $i++)
                                            <span>{{ $i }}</span>
                                        @endfor
                                    </div>
                                </div>
                            </label>
                        </div>
                    @else
                        <span class="font-bold text-red-500">Tiada paparan skor dan status ditunjukkan bagi bahagian ini.
                            Data yang dikumpulkan akan dianalisa kemudian</span>
                    @endif

                    <!-- Enhanced Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-8">
                        @if ($question['type'] != 'image')
                            <button type="submit"
                                class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-4 px-6
                                       rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700
                                       transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Hantar Jawapan
                            </button>
                        @endif
                        <a href="{{ route('dashboard') }}"
                            class="flex-1 bg-gray-200 text-gray-700 py-4 px-6 rounded-xl font-semibold
                                  hover:bg-gray-300 transition-all duration-300 text-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Question Navigation -->
    <div class="mt-8 max-w-4xl mx-auto">
        <div class="glass-card p-4">
            <div class="flex items-center justify-between text-sm text-gray-600">
                <div>
                    <span class="font-medium">Soalan {{ $question['id'] }}</span>
                    <span class="text-gray-400">dari {{ $debug_info['total_questions'] ?? '?' }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                    <span>{{ $debug_info['answered'] ?? 0 }} dijawab</span>
                    <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                    <span>{{ $debug_info['remaining'] ?? 0 }} baki</span>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/enhanced-design.css') }}">
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            border-radius: 1.5rem;
        }

        .form-input-enhanced {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-input-enhanced:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        /* Radio button animations and styling */
        .peer:checked~div {
            transform: scale(1.02);
        }

        /* Fix for radio button visual indicator */
        .peer:checked~div .radio-indicator {
            border-color: #4f46e5 !important;
            background-color: #4f46e5 !important;
        }

        .peer:checked~div .radio-dot {
            opacity: 1 !important;
        }

        /* Checkbox styling */
        .peer:checked~div .checkbox-indicator {
            border-color: #4f46e5 !important;
            background-color: #4f46e5 !important;
        }

        .peer:checked~div .checkbox-indicator i {
            opacity: 1 !important;
        }

        /* Floating animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Enhanced validation and interactive features
        document.addEventListener('DOMContentLoaded', function() {
            // Animate progress ring
            const progressRing = document.querySelector('circle[stroke-dasharray]');
            if (progressRing) {
                setTimeout(() => {
                    progressRing.style.transition = 'stroke-dashoffset 1.5s ease-in-out';
                }, 100);
            }

            // Add hover effects to radio/checkbox options
            const radioOptions = document.querySelectorAll('label.block');
            radioOptions.forEach(option => {
                option.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(5px)';
                });
                option.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });

            // Enhanced form validation
            const form = document.querySelector('form');
            if (form) {
                // Add loading state for submit button
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
                        submitBtn.disabled = true;
                    }
                });
            }
        });
    </script>
@endpush
