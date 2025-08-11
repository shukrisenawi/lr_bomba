@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Enhanced Header -->
    <div class="mb-8">
        <div class="glass-card p-6 mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-center">
                <div class="text-center sm:text-left mb-4 sm:mb-0">
                    <h1 class="text-2xl sm:text-3xl font-bold gradient-text mb-2">
                        Aplikasi Penilaian ‘Fit-to-Work’
                    </h1>
                    <p class="text-gray-600 text-sm sm:text-base">
                        Pekerja Berusia di Jabatan Bomba dan Penyelamat Di Lembah Klang, Malaysia
                    </p>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="ml-4">
                    @csrf
                    <button type="submit" class="btn btn-error btn-sm glass-card hover:bg-red-500 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Survey Sections Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($sections as $section => $title)

            <div class="card-enhanced glass-card p-6 text-center">
                <!-- Section Icon -->
                <div
                    class="w-16 h-16 bg-gradient-to-r {{ getSectionGradient($section) }} rounded-full flex items-center justify-center mx-auto mb-4">
                    {{-- <i class="fas fa-{{ getSectionIcon($section) }} text-white text-2xl"></i> --}}
                    <img src="../img/{{ getSectionIcon($section) }}" />
                </div>

                <!-- Section Title -->
                <h3 class="text-xl font-bold text-gray-800 mb-4">{{ $title }}</h3>

                <!-- Progress Ring -->
                <div class="relative w-32 h-32 mx-auto mb-4">
                    <svg class="w-32 h-32 transform -rotate-90">
                        <defs>
                            <linearGradient id="gradient{{ $section }}" x1="0%" y1="0%" x2="100%"
                                y2="100%">
                                <stop offset="0%"
                                    style="stop-color:{{ getProgressColor($progress[$section] ?? 0, 'start') }};stop-opacity:1" />
                                <stop offset="100%"
                                    style="stop-color:{{ getProgressColor($progress[$section] ?? 0, 'end') }};stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        <circle stroke="#e5e7eb" stroke-width="8" fill="none" r="52" cx="64" cy="64" />
                        <circle stroke="url(#gradient{{ $section }})" stroke-width="8" fill="none" r="52"
                            cx="64" cy="64" stroke-dasharray="326.73"
                            stroke-dashoffset="{{ 326.73 - (326.73 * ($progress[$section] ?? 0)) / 100 }}" />
                    </svg>

                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-2xl font-bold {{ getProgressTextColor($progress[$section] ?? 0) }}">
                            {{ $progress[$section] ?? 0 }}%
                        </span>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="mb-4">
                    @if (($section == 'I' || $section == 'L') && !session()->has('admin_id'))
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <i class="fas fa-user mr-1"></i>&nbsp;
                            Admin sahaja
                        </span>
                    @else
                        @if (isset($responses[$section]))
                            @if ($responses[$section]->completed)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Selesai
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    Dalam Proses
                                </span>
                            @endif
                        @else
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-play-circle mr-1"></i>
                                Belum Dimulakan
                            </span>
                        @endif
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="space-y-2">
                    @if (($section == 'I' || $section == 'L') && !session()->has('admin_id'))
                        <a href="{{ route('survey.results', $section) }}" class="btn-enhanced w-full text-sm">
                            <i class="fas fa-lock mr-1"></i>
                            Admin log in
                        </a>
                    @else
                        @if (isset($responses[$section]))
                            @if ($responses[$section]->completed)
                                <a href="{{ route('survey.results', $section) }}" class="btn-enhanced w-full text-sm">
                                    <i class="fas fa-search mr-1"></i>
                                    @if ($section == 'J')
                                        Lihat Jawapan
                                    @else
                                        Lihat Score
                                    @endif
                                </a>
                            @else
                                <a href="{{ route('survey.show', $section) }}" class="btn-enhanced w-full text-sm">
                                    <i class="fas fa-play mr-1"></i>
                                    Jawab soalan
                                </a>
                            @endif
                        @else
                            <a href="{{ route('survey.show', $section) }}" class="btn-enhanced w-full text-sm">
                                <i class="fas fa-play mr-1"></i>
                                Mulakan
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Welcome Animation -->
    <div class="mt-12 text-center">
        <div class="glass-card p-6 max-w-md mx-auto">
            <div
                class="w-20 h-20 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-heart text-white text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Selamat Datang!</h3>
            <p class="text-gray-600 text-sm">
                Penglibatan
                dan komitmen yang anda berikan amatlah kami hargai.
            </p>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            border-radius: 1.5rem;
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-enhanced {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px 0 rgba(102, 126, 234, 0.4);
            display: inline-block;
            text-decoration: none;
        }

        .btn-enhanced:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px 0 rgba(102, 126, 234, 0.6);
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Add interactive features
        document.addEventListener('DOMContentLoaded', function() {
            // Animate progress rings on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const circles = entry.target.querySelectorAll('circle');
                        circles.forEach(circle => {
                            circle.style.transition = 'stroke-dashoffset 1.5s ease-in-out';
                        });
                    }
                });
            });

            document.querySelectorAll('svg').forEach(ring => {
                observer.observe(ring.parentElement);
            });
        });
    </script>
@endpush

@php
    function getSectionIcon($section)
    {
        $icons = [
            'B' => 'icon-01.png',
            'C' => 'icon-02.png',
            'D' => 'icon-03.png',
            'E' => 'icon-04.png',
            'F' => 'icon-05.png',
            'G' => 'icon-06.png',
            'H' => 'icon-07.png',
            'I' => 'icon-08.png',
            'J' => 'icon-09.png',
            'K' => 'icon-10.png',
            'L' => 'icon-11.png',
        ];
        return $icons[$section] ?? 'file-alt';
    }

    function getSectionGradient($section)
    {
        $gradients = [
            'A' => 'from-blue-500 to-purple-500',
            'B' => 'from-green-500 to-teal-500',
            'C' => 'from-pink-500 to-red-500',
            'D' => 'from-yellow-500 to-orange-500',
            'E' => 'from-indigo-500 to-pink-500',
            'F' => 'from-purple-500 to-blue-500',
        ];
        return $gradients[$section] ?? 'from-gray-500 to-gray-600';
    }

    function getProgressColor($percentage, $type = 'start')
    {
        if ($percentage >= 76) {
            return $type === 'start' ? '#10b981' : '#059669'; // Green
        } elseif ($percentage >= 51) {
            return $type === 'start' ? '#f59e0b' : '#d97706'; // Yellow
        } elseif ($percentage >= 26) {
            return $type === 'start' ? '#f97316' : '#ea580c'; // Orange
        } else {
            return $type === 'start' ? '#ef4444' : '#dc2626'; // Red
        }
    }

    function getProgressTextColor($percentage)
    {
        if ($percentage >= 76) {
            return 'text-green-600';
        } elseif ($percentage >= 51) {
            return 'text-yellow-600';
        } elseif ($percentage >= 26) {
            return 'text-orange-600';
        } else {
            return 'text-red-600';
        }
    }
@endphp
