@extends('layouts.app')

@section('title', 'Semakan Jawapan - ' . ($sectionTitle ?? 'Soal Selidik'))

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-green-600 to-blue-600 text-white rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Semakan Jawapan</h1>
                    <p class="text-green-100">Sila semak semua jawapan anda sebelum meneruskan</p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold">{{ $sectionTitle ?? 'Bahagian' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Card -->
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Summary Header -->
            <div class="bg-gradient-to-r from-green-500 to-blue-500 text-white p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-clipboard-check text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Ringkasan Jawapan</h3>
                        <p class="text-green-100 text-sm">Semua jawapan anda dalam bahagian ini</p>
                    </div>
                </div>
            </div>

            <!-- Questions List -->
            <div class="p-8">
                @if ($questions->isEmpty())
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-exclamation-triangle text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-600 mb-2">Tiada Soalan</h3>
                        <p class="text-gray-500">Tiada soalan untuk disemak dalam bahagian ini.</p>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach ($questions as $index => $question)
                            <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-3">
                                            <div
                                                class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">
                                                {{ $index + 1 }}
                                            </div>
                                            <h4 class="text-lg font-semibold text-gray-800">
                                                {{ $question['text_BM'] ?? ($question['text'] ?? ($question['title'] ?? 'Soalan tanpa tajuk')) }}
                                            </h4>
                                        </div>

                                        @php
                                            $answer = $response->answers
                                                ->where('question_id', $question['id'] ?? null)
                                                ->first();
                                        @endphp

                                        <div class="ml-11">
                                            @if ($answer)
                                                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                                    <div class="flex items-center mb-2">
                                                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                                        <span class="font-semibold text-green-800">Jawapan Anda:</span>
                                                    </div>
                                                    <p class="text-green-700">
                                                        {{ getDisplayTextForAnswer($question, $answer->answer ?? '') }}
                                                    </p>
                                                </div>

                                                <a href="{{ route('survey.edit', [$section, $question['id'] ?? 0]) }}"
                                                    class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                                                    <i class="fas fa-edit mr-2"></i>
                                                    Edit Jawapan
                                                </a>
                                            @else
                                                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-times-circle text-red-600 mr-2"></i>
                                                        <span class="font-semibold text-red-800">Belum dijawab</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('survey.results', $section) }}"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Lihat Keputusan
                        </a>
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-colors">
                            <i class="fas fa-home mr-2"></i>
                            Kembali ke Dashboard
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Completion Message -->
    @if ($response->completed)
        <div class="mt-8 max-w-4xl mx-auto">
            <div class="bg-gradient-to-r from-green-400 to-blue-500 text-white rounded-xl p-6 text-center">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-trophy text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Tahniah!</h3>
                <p class="text-green-100">
                    Anda telah menyelesaikan semua soalan dalam bahagian ini.
                </p>
            </div>
        </div>
    @endif
@endsection

@push('styles')
    <style>
        /* Custom animations */
        .hover\:shadow-lg:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s ease;
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Add interactive features
        document.addEventListener('DOMContentLoaded', function() {
            // Add fade-in animation to cards
            const cards = document.querySelectorAll('.border.border-gray-200');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.5s ease';

                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 100);
            });

            // Add hover effects
            const editButtons = document.querySelectorAll('a[href*="edit"]');
            editButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        });
    </script>
@endpush
