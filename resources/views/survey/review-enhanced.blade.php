@extends('layouts.app')

@section('title', 'Semakan Jawapan - ' . ($sectionTitle ?? 'Soal Selidik'))

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-green-600 to-blue-600 text-white rounded-2xl p-6">
            <div class="text-center">
                <div class="text-2xl font-bold">{{ $sectionTitle ?? 'Bahagian' }}</div>
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

            <!-- Subsection Grouping -->
            <div class="p-8">
                @if (empty($questionsBySubsection))
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-exclamation-triangle text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-600 mb-2">Tiada Soalan</h3>
                        <p class="text-gray-500">Tiada soalan untuk disemak dalam bahagian ini.</p>
                    </div>
                @else
                    <div class="space-y-8">
                        @foreach ($questionsBySubsection as $subsectionName => $subsectionData)
                            <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow">
                                @if ($subsectionName != 'main')
                                    <div class="flex items-center mb-4">
                                        <div
                                            class="min-w-8 min-h-8 w-auto h-auto bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">
                                            {{ $loop->index + 1 }}
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-800 text-left">{{ $subsectionName }}</h3>
                                    </div>
                                @endif
                                @if (isset($subsectionData['score']) && $subsectionData['score'] !== null)
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                        <div class="flex items-center justify-between">
                                            <span class="font-semibold text-blue-800">Skor:
                                                {{ $subsectionData['score'] }}</span>
                                            <span
                                                class="text-sm text-blue-600">{{ $subsectionData['category'] ?? 'Sederhana' }}</span>
                                        </div>
                                        <p class="text-sm text-blue-700 mt-2">
                                            {{ $subsectionData['recommendation'] ?? '' }}
                                        </p>
                                    </div>
                                @endif

                                <div class="space-y-4">
                                    @foreach ($subsectionData['questions'] as $index => $question)
                                        <div class="border-l-4 border-blue-500 pl-4">
                                            <div class="flex items-start mb-2">
                                                <div
                                                    class="min-w-6 min-h-6 w-auto h-auto px-2 py-1 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs mr-3 flex-shrink-0">
                                                    {{ $index + 1 }}
                                                </div>
                                                <h4 class="text-md font-semibold text-gray-800 text-left flex-1">
                                                    {!! $question['text_BM'] ?? ($question['text'] ?? ($question['title'] ?? 'Soalan tanpa tajuk')) !!}
                                                </h4>
                                            </div>

                                            @php
                                                $answer = $response->answers
                                                    ->where('question_id', $question['id'] ?? null)
                                                    ->first();
                                            @endphp

                                            <div class="ml-8">
                                                @if ($answer)
                                                    <div
                                                        class="bg-green-50 border text-left border-green-200 rounded-lg p-3 mb-2">
                                                        <div class="flex mb-1">
                                                            <div class="hidden sm:block"><i
                                                                    class="fas fa-check-circle mt-1 text-green-600 mr-2"></i>
                                                                <span class="font-semibold text-green-800 mr-5">Jawapan
                                                                    Anda:
                                                                </span>
                                                            </div>

                                                            @php
                                                                $answerValue = $answer->answer ?? '';
                                                                $isJson = false;
                                                                $decodedAnswer = null;

                                                                if (is_string($answerValue)) {
                                                                    $decodedAnswer = json_decode($answerValue, true);
                                                                    $isJson =
                                                                        json_last_error() === JSON_ERROR_NONE &&
                                                                        is_array($decodedAnswer);
                                                                }
                                                            @endphp

                                                            @if ($isJson && is_array($decodedAnswer))
                                                                @if (!preg_match('/\.(png|jpg|jpeg|gif|webp)$/i', trim($answerQuestion)))
                                                                    <ol class="list-disc list-inside space-y-1">
                                                                        @foreach ($decodedAnswer as $item)
                                                                            @php
                                                                                $answerQuestion = is_array($item)
                                                                                    ? implode(', ', $item)
                                                                                    : htmlspecialchars((string) $item);
                                                                            @endphp
                                                                            <li class="text-green-700">
                                                                                {{ $answerQuestion }}
                                                                            </li>
                                                                        @endforeach
                                                                    </ol>
                                                                @else
                                                                    <ol class="list-inside space-y-1">
                                                                        @foreach ($decodedAnswer as $item)
                                                                            @php
                                                                                $answerQuestion = is_array($item)
                                                                                    ? implode(', ', $item)
                                                                                    : htmlspecialchars((string) $item);
                                                                            @endphp
                                                                            <li class="text-green-700">
                                                                                <img
                                                                                    src="{{ asset('img/' . $answerQuestion) }}" />
                                                                            </li>
                                                                        @endforeach
                                                                    </ol>
                                                                @endif
                                                            @else
                                                                <span class="text-green-700">
                                                                    @php
                                                                        $answerQuestion = getDisplayTextForAnswer(
                                                                            $question,
                                                                            is_array($answerValue)
                                                                                ? json_encode($answerValue)
                                                                                : (string) $answerValue,
                                                                        );
                                                                    @endphp
                                                                    @if (preg_match('/\.(png|jpg|jpeg|gif|webp)$/i', trim($answerQuestion)))
                                                                        <img src="{{ asset('img/' . $answerQuestion) }}" />
                                                                    @else
                                                                        {{ $answerQuestion }}
                                                                    @endif

                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                                        <div class="flex items-center">
                                                            <i class="fas fa-times-circle text-red-600 mr-2"></i>
                                                            <span class="font-semibold text-red-800">Belum
                                                                dijawab</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
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
