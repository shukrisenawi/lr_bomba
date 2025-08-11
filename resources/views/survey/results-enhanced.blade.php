@extends('layouts.app')

@section('title', 'Keputusan ' . $sectionData['title_BM'])
@section('content')
    <div class="mx-auto">

        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold gradient-text mb-2">
                {{ $sectionData['title_BM'] }}
            </h1>
        </div>

        <!-- Main Results Card -->
        <div class="glass-card mb-8 sm:p-5">

            @if ($hasSubsections && !empty($subsectionScores))
                <!-- Display Subsection Scores -->
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-chart-bar text-blue-500 mr-2"></i>
                        @if ($section === 'B')
                            Keputusan Keseluruhan
                        @else
                            Keputusan Keseluruhan
                        @endif
                    </h3>
                </div>
                @foreach ($subsectionScores as $index => $subsection)
                    @if ($subsection['name'] != 'Skor Bahagian A' && $subsection['name'] != 'Skor Bahagian B')
                        {{-- @if ($subsection['name'] != '') --}}
                        <div class="mb-8 border-l-4 border-blue-500 pl-4">
                            @php
                                $displayName = $subsection['name'];
                                if ($displayName === 'Jumlah Skor Keseluruhan BAT12') {
                                    $displayName = 'Keputusan Keseluruhan';
                                }
                            @endphp
                            <h4
                                class="text-lg mb-3 @if ($displayName === 'Keputusan Keseluruhan') font-bold text-black @else font-semibold text-gray-800 @endif">
                                {{ $displayName }}</h4>



                            <!-- Subsection Score Details -->
                            <div class="space-y-3">
                                <div
                                    class="flex items-center justify-between p-3 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-lg">
                                    <span class="font-medium text-gray-700">Jumlah Skor</span>
                                    <span class="text-xl font-bold text-purple-600">{{ $subsection['score'] }}</span>
                                </div>

                                @if (isset($subsection['category']) && $subsection['category'] && $section !== 'B')
                                    <div
                                        class="flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-blue-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Status</span>
                                        <span
                                            class="px-3 py-1 rounded-full text-sm font-medium
                                        @if (str_contains(strtolower($subsection['category']), 'cemerlang') ||
                                                str_contains(strtolower($subsection['category']), 'tinggi')) bg-green-100 text-green-800
                                        @elseif(str_contains(strtolower($subsection['category']), 'baik') ||
                                                str_contains(strtolower($subsection['category']), 'sederhana')) bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                            {{ $subsection['category'] }}
                                        </span>
                                    </div>
                                @endif

                                {{-- <div
                                class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg">
                                <span class="font-medium text-gray-700">Status</span>
                                <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    Selesai
                                </span>
                            </div> --}}
                            </div>

                            @if (isset($subsection['recommendation']) && $subsection['recommendation'] && $section !== 'B')
                                <!-- Subsection Recommendations -->
                                <div class="mt-4">
                                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 hidden sm:block">
                                                <div
                                                    class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-info text-white text-xs"></i>
                                                </div>
                                            </div>
                                            <div class="sm:ml-3 text-left">
                                                <h5 class="font-medium text-gray-800 mb-1">Saranan:</h5>
                                                <p class="text-gray-600 text-sm leading-relaxed">
                                                    {{ $subsection['recommendation'] }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if (!$loop->last && $section !== 'B')
                            <hr class="my-6 border-gray-200">
                        @endif
                    @endif
                @endforeach
            @elseif ($response->scores->isNotEmpty())
                <!-- Display Overall Scores (for sections without subsections) -->
                @foreach ($response->scores as $score)
                    <!-- Score Visualization -->
                    <div class="gap-8 mb-8">

                        <!-- Score Details -->
                        <div class="lg:col-span-2">
                            <div class="space-y-4">
                                <div
                                    class="flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl">
                                    @php
                                        $scoreTitles = [
                                            'D_Keseluruhan' => 'Jumlah Skor Keseluruhan',
                                            'D_Prestasi' => 'Jumlah Skor Prestasi',
                                            'D_Sikap' => 'Jumlah Skor Sikap',
                                        ];
                                        $scoreTitle = $scoreTitles[$score->section] ?? 'Jumlah Skor';
                                    @endphp
                                    <span class="font-semibold text-gray-700">{{ $scoreTitle }}</span>
                                    <span class="text-2xl font-bold text-purple-600">{{ $score->score }}</span>
                                </div>

                                @if ($score->category)
                                    <div
                                        class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-blue-50 rounded-xl">
                                        <span class="font-semibold text-gray-700">Status</span>
                                        <span
                                            class="px-3 py-1 rounded-full text-sm font-medium
                                                @if (str_contains(strtolower($score->category), 'tinggi')) bg-green-100 text-green-800
                                                @elseif(str_contains(strtolower($score->category), 'sederhana')) bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                            {{ $score->category }}
                                        </span>
                                    </div>
                                @endif
                                {{-- <div
                                    class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl">
                                    <span class="font-semibold text-gray-700">Status</span>
                                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        Selesai
                                    </span>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    @if ($score->recommendation)
                        <!-- Recommendations Section -->
                        <div class="space-y-6 mb-10">
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">
                                <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                                Saranan
                            </h3>

                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 hidden sm:block">
                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-info text-white text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="sm:ml-4">
                                        <p class="text-gray-600 leading-relaxed text-left">
                                            {{ $score->recommendation }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <hr class="mb-5">
                @endforeach
            @else
                <!-- No Results State -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clipboard-list text-3xl text-gray-400"></i>
                    </div>
                    @if ($section != 'K')
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Tiada Keputusan</h3>
                        <p class="text-gray-500 mb-6">Tiada keputusan dikira untuk bahagian ini.</p>
                    @else
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Maklumat yang diperolehi akan dijadikan
                            rujukan bagi penilaian keseluruhan Fit-to-work</h3>
                    @endif
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                @if ($section != 'J')
                    <a href="{{ route('survey.review', $section) }}" class="btn-enhanced flex items-center justify-center">
                        <i class="fas fa-eye mr-2"></i>
                        Semak Jawapan
                    </a>
                @endif


                <a href="{{ route('dashboard') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-semibold transition-colors flex items-center justify-center">
                    <i class="fas fa-home mr-2"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
        {{--
            <!-- Additional Insights -->
            @if ($response->scores->isNotEmpty())
                <div class="glass-card">
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                            <i class="fas fa-brain text-purple-500 mr-2"></i>
                            Maklumat Tambahan
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center">
                                <div
                                    class="w-16 h-16 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-clock text-white text-xl"></i>
                                </div>
                                <h4 class="font-semibold text-gray-800">Masa Diambil</h4>
                                <p class="text-gray-600">Dikira secara automatik</p>
                            </div>

                            <div class="text-center">
                                <div
                                    class="w-16 h-16 bg-gradient-to-r from-green-500 to-teal-600 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-check-circle text-white text-xl"></i>
                                </div>
                                <h4 class="font-semibold text-gray-800">Status Penilaian</h4>
                                <p class="text-gray-600">Lengkap & Disahkan</p>
                            </div>

                            <div class="text-center">
                                <div
                                    class="w-16 h-16 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-chart-pie text-white text-xl"></i>
                                </div>
                                <h4 class="font-semibold text-gray-800">Peratusan</h4>
                                <p class="text-gray-600">Berdasarkan jawapan anda</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif --}}
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
