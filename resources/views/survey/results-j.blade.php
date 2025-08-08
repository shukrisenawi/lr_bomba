@extends('layouts.app')

@section('title', 'Keputusan Bahagian J')

@section('content')
    <div class="mx-auto">

        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold gradient-text mb-2">
                {{ $sectionData['title_BM'] }}
            </h1>
            <p class="text-gray-600">Berikut adalah ringkasan jawapan anda.</p>
        </div>

        <!-- Main Results Card -->
        <div class="glass-card mb-8 sm:p-5 text-left">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">
                    <i class="fas fa-list-alt text-blue-500 mr-2"></i>
                    Soalan dan Jawapan
                </h3>
            </div>

            @if ($questionsAndAnswers->isNotEmpty())
                @foreach ($questionsAndAnswers as $item)
                    <div class="mb-6 border-l-4 border-blue-500 pl-4">
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">{!! $item['question']['text_BM'] ?? $item['question']['text'] !!}</h4>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="font-medium text-gray-700">Jawapan:</span>
                            <span class="text-gray-900 ml-2">
                                @if (is_array($item['answer']))
                                    @foreach ($item['answer'] as $answer)
                                        <span
                                            class="badge badge-soft badge-primary rounded-3xl px-5">{{ $answer }}</span>
                                    @endforeach
                                @else
                                    {{ $item['answer'] ?? 'Tidak dijawab' }}
                                @endif
                            </span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clipboard-list text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Tiada Jawapan</h3>
                    <p class="text-gray-500 mb-6">Anda belum menjawab soalan untuk bahagian ini.</p>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                <a href="{{ route('dashboard') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-semibold transition-colors flex items-center justify-center">
                    <i class="fas fa-home mr-2"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* Additional custom styles for results page */
        .text-gradient-to-r {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass-card {
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            background-color: rgba(255, 255, 255, 0.75);
            border-radius: 12px;
            border: 1px solid rgba(209, 213, 219, 0.3);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
        }

        @media (max-width: 640px) {
            .glass-card {
                margin: 0.5rem;
                padding: 1rem;
            }
        }
    </style>
@endsection
