@extends('layouts.app')

@section('title', $sectionTitle)

@section('content')
    <!-- Progress Header -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">{{ $sectionTitle }}</h1>
                    <p class="text-blue-100">Sila jawab soalan berikut dengan jujur</p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold">{{ $progress }}%</div>
                    <div class="text-sm text-blue-100">Kemajuan</div>
                </div>
            </div>
            <div class="mt-4">
                <div class="w-full bg-white/20 rounded-full h-2">
                    <div class="bg-white rounded-full h-2 transition-all duration-500" style="width: {{ $progress }}%">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Question Card -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Question Header -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-4">
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
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 leading-relaxed">
                        {{ $question['text_BM'] ?? $question['text'] }}
                    </h2>

                    @if (isset($question['description_BM']))
                        <p class="text-gray-600 mb-6">{{ $question['description_BM'] }}</p>
                    @endif
                </div>

                <!-- Answer Form -->
                <form method="POST" action="{{ route('survey.store', $section) }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $question['id'] }}">

                    @if ($question['type'] === 'single_choice')
                        <div class="space-y-4">
                            @foreach ($question['options'] as $index => $option)
                                @php
                                    $optionText = is_array($option) ? $option['text'] ?? '' : $option;
                                    $optionValue = is_array($option) ? $option['value'] ?? $optionText : $option;
                                @endphp
                                <label class="block">
                                    <input type="radio" name="answer" value="{{ $optionValue }}" class="peer sr-only"
                                        required>
                                    <div
                                        class="relative flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition-all hover:border-indigo-500 hover:bg-indigo-50 peer-checked:border-indigo-600 peer-checked:bg-indigo-50">
                                        <div
                                            class="w-6 h-6 border-2 border-gray-300 rounded-full mr-4 flex items-center justify-center peer-checked:border-indigo-600">
                                            <div
                                                class="w-3 h-3 bg-indigo-600 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity">
                                            </div>
                                        </div>
                                        <span class="text-gray-700 font-medium">{{ $optionText }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @elseif($question['type'] === 'numeric')
                        <div class="space-y-4">
                            <label class="block">
                                <span class="text-gray-700 font-medium">Masukkan nilai:</span>
                                <input type="number" name="answer"
                                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Masukkan angka" required>
                            </label>
                            @if (isset($question['unit']))
                                <p class="text-sm text-gray-500">Unit: {{ $question['unit'] }}</p>
                            @endif
                        </div>
                    @elseif($question['type'] === 'text')
                        <div class="space-y-4">
                            <label class="block">
                                <span class="text-gray-700 font-medium">Masukkan jawapan:</span>
                                <input type="text" name="answer"
                                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Taip jawapan anda di sini" required>
                            </label>
                        </div>
                    @else
                        <div class="space-y-4">
                            <label class="block">
                                <span class="text-gray-700 font-medium">Masukkan jawapan:</span>
                                <input type="text" name="answer"
                                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Taip jawapan anda di sini" required>
                            </label>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Hantar Jawapan
                        </button>
                        <a href="{{ route('dashboard') }}"
                            class="flex-1 bg-gray-200 text-gray-700 py-3 px-6 rounded-xl font-semibold hover:bg-gray-300 transition-all duration-300 text-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Debug Info (if enabled) -->
    @if (isset($debug_info) && config('app.debug'))
        <div class="mt-8 max-w-4xl mx-auto">
            <div class="bg-gray-100 rounded-xl p-6">
                <h3 class="text-lg font-semibold mb-4">Maklumat Debug</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="bg-white p-4 rounded-lg">
                        <strong>Jumlah Soalan:</strong> {{ $debug_info['total_questions'] }}
                    </div>
                    <div class="bg-white p-4 rounded-lg">
                        <strong>Dijawab:</strong> {{ $debug_info['answered'] }}
                    </div>
                    <div class="bg-white p-4 rounded-lg">
                        <strong>Baki:</strong> {{ $debug_info['remaining'] }}
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('styles')
    <style>
        /* Custom radio button styling */
        .peer:checked~.peer-checked\:border-indigo-600 {
            border-color: #4f46e5;
        }

        .peer:checked~.peer-checked\:bg-indigo-50 {
            background-color: #eef2ff;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Add smooth animations and interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Animate progress bar
            const progressBar = document.querySelector('.bg-white');
            if (progressBar) {
                setTimeout(() => {
                    progressBar.style.transition = 'width 1s ease-in-out';
                }, 100);
            }

            // Add hover effects to radio options
            const radioOptions = document.querySelectorAll('label.block');
            radioOptions.forEach(option => {
                option.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(5px)';
                });
                option.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });
        });
    </script>
@endpush
