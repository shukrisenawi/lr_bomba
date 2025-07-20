@extends('layouts.app')

@section('title', 'Keputusan ' . $sectionData['title_BM'])
@section('content')
    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-indigo-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="text-center mb-8">
                <div class="floating mb-4">
                    <div class="section-icon bg-gradient-to-r from-purple-500 to-indigo-600">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
                <h1 class="text-4xl font-bold gradient-text mb-2">
                    Keputusan {{ $sectionData['title_BM'] }}
                </h1>
                <p class="text-gray-600 text-lg">
                    Analisis mendalam berdasarkan jawapan anda
                </p>
            </div>

            <!-- Main Results Card -->
            <div class="glass-card mb-8">
                <div class="p-8">
                    @if ($response->scores->isNotEmpty())
                        @foreach ($response->scores as $score)
                            <!-- Score Visualization -->
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                                <!-- Score Ring -->
                                <div class="flex flex-col items-center">
                                    <div class="relative w-48 h-48">
                                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                            <path class="text-gray-200" stroke-width="3" fill="none" d="M18 2.0845
                                                       a 15.9155 15.9155 0 0 1 0 31.831
                                                       a 15.9155 15.9155 0 0 1 0 -31.831" />
                                            <path class="text-gradient-to-r from-purple-500 to-indigo-600" stroke-width="3"
                                                stroke-dasharray="{{ ($score->score / 100) * 100 }}, 100"
                                                stroke-linecap="round" fill="none" d="M18 2.0845
                                                       a 15.9155 15.9155 0 0 1 0 31.831
                                                       a 15.9155 15.9155 0 0 1 0 -31.831" />
                                        </svg>
                                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                                            <span class="text-3xl font-bold text-gray-800">{{ $score->score }}</span>
                                            <span class="text-sm text-gray-500">daripada 100</span>
                                        </div>
                                    </div>
                                    <h3 class="text-xl font-semibold mt-4 gradient-text">{{ $score->category }}</h3>
                                </div>

                                <!-- Score Details -->
                                <div class="lg:col-span-2">
                                    <div class="space-y-4">
                                        <div
                                            class="flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl">
                                            <span class="font-semibold text-gray-700">Skor Keseluruhan</span>
                                            <span class="text-2xl font-bold text-purple-600">{{ $score->score }}/100</span>
                                        </div>

                                        <div
                                            class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-blue-50 rounded-xl">
                                            <span class="font-semibold text-gray-700">Kategori</span>
                                            <span
                                                class="px-3 py-1 rounded-full text-sm font-medium
                                                @if (str_contains(strtolower($score->category), 'tinggi')) bg-green-100 text-green-800
                                                @elseif(str_contains(strtolower($score->category), 'sederhana')) bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ $score->category }}
                                            </span>
                                        </div>

                                        <div
                                            class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl">
                                            <span class="font-semibold text-gray-700">Status</span>
                                            <span
                                                class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                Selesai
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Recommendations Section -->
                            <div class="space-y-6">
                                <h3 class="text-2xl font-bold text-gray-800 mb-4">
                                    <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                                    Cadangan & Tindakan
                                </h3>

                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                                <i class="fas fa-info text-white text-sm"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-lg font-semibold text-gray-800 mb-2">Analisis Mendalam</h4>
                                            <p class="text-gray-600 leading-relaxed">
                                                {{ $score->recommendation }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Items -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-chart-bar text-purple-500 mr-2"></i>
                                            <span class="font-semibold text-gray-700">Semula Jawapan</span>
                                        </div>
                                        <p class="text-sm text-gray-600">Lihat semula jawapan anda untuk pemahaman lebih
                                            mendalam</p>
                                    </div>

                                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-home text-indigo-500 mr-2"></i>
                                            <span class="font-semibold text-gray-700">Kembali ke Dashboard</span>
                                        </div>
                                        <p class="text-sm text-gray-600">Sambung ke bahagian seterusnya atau selesaikan</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- No Results State -->
                        <div class="text-center py-12">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-clipboard-list text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">Tiada Keputusan</h3>
                            <p class="text-gray-500 mb-6">Tiada keputusan dikira untuk bahagian ini.</p>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                        <a href="{{ route('survey.review', $section) }}"
                            class="btn-enhanced flex items-center justify-center">
                            <i class="fas fa-eye mr-2"></i>
                            Semak Jawapan
                        </a>

                        <a href="{{ route('dashboard') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-semibold transition-colors flex items-center justify-center">
                            <i class="fas fa-home mr-2"></i>
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>

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
            @endif
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
