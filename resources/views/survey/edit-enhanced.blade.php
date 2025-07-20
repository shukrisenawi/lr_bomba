@extends('layouts.app')

@section('title', 'Kemaskini Soal Selidik - ' . ($sectionTitle ?? 'Soal Selidik'))

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white rounded-2xl p-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Kemaskini Soal Selidik</h1>
                    <p class="text-indigo-100">Sunting soalan anda dengan mudah dan cantik</p>
                </div>
                <div class="hidden sm:block">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-edit text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto">
        <div class="glass-card overflow-hidden">
            <!-- Question Header -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-edit text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Kemaskini Soalan</h3>
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
                <form method="POST" action="{{ route('survey.update', [$section, $question['id']]) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="question_id" value="{{ $question['id'] }}">

                    <!-- Question Text -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Soalan</label>
                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <h2 class="text-xl font-semibold text-gray-800 leading-relaxed">
                                {{ $question['text_BM'] ?? $question['text'] }}
                            </h2>
                        </div>
                    </div>

                    <!-- Current Answer Display -->
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg mb-6">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            <span class="font-semibold text-blue-800">Jawapan Semasa:</span>
                        </div>
                        <p class="text-blue-700">{{ $answer->answer ?? 'Tiada jawapan' }}</p>
                    </div>

                    <!-- Answer Input -->
                    <div class="space-y-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jawapan Baharu</label>

                        @if ($question['type'] === 'single_choice')
                            <div class="space-y-3">
                                @foreach ($question['options'] as $key => $option)
                                    @php
                                        $optionText = is_array($option) ? $option['text'] ?? '' : $option;
                                        $optionValue = is_array($option) ? $option['value'] ?? $key : $key;
                                        $currentAnswer = is_array($answer->value ?? null)
                                            ? json_encode($answer->value)
                                            : $answer->value ?? '';
                                        $isChecked = $currentAnswer == $optionValue;
                                    @endphp

                                    <label class="block">
                                        <input type="radio" name="answer" value="{{ $optionValue }}"
                                            class="peer sr-only" {{ $isChecked ? 'checked' : '' }}>
                                        <div
                                            class="relative flex items-center p-4 border-2 border-gray-200 rounded-xl
                                                cursor-pointer transition-all duration-300 hover:border-indigo-500
                                                hover:bg-indigo-50 hover:shadow-lg peer-checked:border-indigo-600
                                                peer-checked:bg-indigo-50 peer-checked:shadow-lg">
                                            <div
                                                class="w-6 h-6 border-2 border-gray-300 rounded-full mr-4
                                                    flex items-center justify-center peer-checked:border-indigo-600">
                                                <div
                                                    class="w-3 h-3 bg-indigo-600 rounded-full opacity-0
                                                        peer-checked:opacity-100 transition-all duration-300">
                                                </div>
                                            </div>
                                            <span class="text-gray-700 font-medium">{{ $optionText }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @elseif($question['type'] === 'numeric')
                            <div>
                                <div class="relative">
                                    <input type="number" name="answer" id="answer"
                                        class="form-input-enhanced w-full text-lg"
                                        value="{{ is_array($answer->answer ?? null) ? '' : $answer->answer ?? '' }}"
                                        required>
                                    @if (isset($question['unit']))
                                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                                            {{ $question['unit'] }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @elseif($question['type'] === 'text')
                            <div>
                                <input type="text" name="answer" id="answer"
                                    class="form-input-enhanced w-full text-lg"
                                    value="{{ is_array($answer->answer ?? null) ? '' : $answer->answer ?? '' }}" required>
                            </div>
                        @else
                            <div>
                                <input type="text" name="answer" id="answer"
                                    class="form-input-enhanced w-full text-lg"
                                    value="{{ is_array($answer->answer ?? null) ? '' : $answer->answer ?? '' }}" required>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-8">
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-4 px-6
                                       rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700
                                       transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="fas fa-save mr-2"></i>
                            Kemaskini Jawapan
                        </button>
                        <a href="{{ route('survey.review', $section) }}"
                            class="flex-1 bg-gray-200 text-gray-700 py-4 px-6 rounded-xl font-semibold
                                  hover:bg-gray-300 transition-all duration-300 text-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Semakan
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Navigation Card -->
    <div class="mt-8 max-w-4xl mx-auto">
        <div class="glass-card p-4">
            <div class="flex items-center justify-between text-sm text-gray-600">
                <div>
                    <span class="font-medium">Soalan {{ $question['id'] }}</span>
                    <span class="text-gray-400">dari Bahagian {{ $section }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                    <span>Dalam pengemaskinian</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/enhanced-design.css') }}">
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
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

        /* Radio button animations */
        .peer:checked~div {
            transform: scale(1.02);
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
            // Animate radio buttons
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
            const validator = new SurveyValidator(form);

            // Add real-time validation feedback
            const inputs = form.querySelectorAll('input[name="answer"]');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validator.validateField(this);
                });
            });

            // Add loading state for submit button
            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
                    submitBtn.disabled = true;
                }
            });

            // Add smooth scroll to top
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
@endpush
