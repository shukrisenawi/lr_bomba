@extends('layouts.app')

@section('title', 'Maklumat Responder - ' . $user->name)

@section('content')
    <!-- Background decoration -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div
            class="absolute -top-40 -right-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse">
        </div>
        <div
            class="absolute top-0 -left-20 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse animation-delay-4000">
        </div>
    </div>

    <div class="relative z-10 container mx-auto max-w-7xl">
        <!-- Header Section with Glassmorphism -->
        <div class="mb-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <div class="flex items-center">
                        <a href="{{ route('admin.responders') }}"
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/50 hover:bg-white/80 transition-all duration-200 mr-4">
                            <i class="fas fa-arrow-left text-gray-600"></i>
                        </a>
                        <div>
                            <h1
                                class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                {{ $user->name }}
                            </h1>
                            <p class="text-gray-600 mt-1">Maklumat lengkap responder dan tinjauan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6 border border-white/20">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                        <i class="fas fa-clipboard-check text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Tinjauan Selesai</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $responses->where('completed', true)->count() }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6 border border-white/20">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-gradient-to-r from-green-500 to-green-600 text-white">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Jumlah Tinjauan</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $responses->count() }}</p>
                        </div>
                    </div>
                </div> --}}

            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6 border border-white/20">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-gradient-to-r from-purple-500 to-purple-600 text-white">
                        <i class="fas fa-percentage text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Kadar Penyelesaian</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $responses->count() > 0 ? round(($responses->where('completed', true)->count() / $responses->count()) * 100) : 0 }}%
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6 border border-white/20">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                        <i class="fas fa-calendar text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Tarikh Daftar</p>
                        <p class="text-lg font-bold text-gray-900">{{ $user->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Tab Navigation -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 mb-6">
            <nav class="flex flex-wrap" role="tablist">
                <button onclick="showTab('profile')"
                    class="tab-btn flex-1 sm:flex-none px-6 py-4 text-sm font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-blue-500 transition-all duration-200"
                    data-tab="profile">
                    <i class="fas fa-user mr-2"></i>
                    Profil
                </button>
                <button onclick="showTab('surveys')"
                    class="tab-btn flex-1 sm:flex-none px-6 py-4 text-sm font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-blue-500 transition-all duration-200"
                    data-tab="surveys">
                    <i class="fas fa-clipboard-list mr-2"></i>
                    Tinjauan
                </button>
                {{-- <button onclick="showTab('analytics')"
                    class="tab-btn flex-1 sm:flex-none px-6 py-4 text-sm font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-blue-500 transition-all duration-200"
                    data-tab="analytics">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Analitik
                </button> --}}
            </nav>
        </div>

        <!-- Tab Contents -->
        <div class="tab-contents">
            <!-- Profile Tab -->
            <div id="profile-content" class="tab-pane">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Personal Information Card -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-user-circle text-blue-500 mr-3"></i>
                            Maklumat Peribadi
                        </h3>
                        <div class="space-y-4">
                            @php
                                $personalInfo = [
                                    'Nama Penuh' => $user->name,
                                    'Email' => $user->email,
                                    'No. Telefon' => optional($user->respondent)->phone_number ?? '-',
                                    'Umur' => optional($user->respondent)->age
                                        ? optional($user->respondent)->age . ' tahun'
                                        : '-',
                                    'Jantina' => optional($user->respondent)->gender ?? '-',
                                    'Etnik' => optional($user->respondent)->ethnicity ?? '-',
                                    'Status Perkahwinan' => optional($user->respondent)->marital_status ?? '-',
                                    'Taraf Pendidikan' => optional($user->respondent)->education_level ?? '-',
                                ];
                            @endphp
                            @foreach ($personalInfo as $label => $value)
                                <div class="flex justify-between items-center py-3 border-b border-gray-100 last:border-0">
                                    <span class="text-gray-600">{{ $label }}</span>
                                    <span class="font-medium text-gray-900 text-right">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Employment Information Card -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-briefcase text-green-500 mr-3"></i>
                            Maklumat Pekerjaan
                        </h3>
                        <div class="space-y-4">
                            @php
                                $employmentInfo = [
                                    'Lokasi' => optional($user->respondent)->location ?? '-',
                                    'Jawatan' => optional($user->respondent)->position ?? '-',
                                    'Gred' => optional($user->respondent)->grade ?? '-',
                                    'Status Perkhidmatan' => optional($user->respondent)->service_status ?? '-',
                                    'Tahun Perkhidmatan' => optional($user->respondent)->years_of_service
                                        ? optional($user->respondent)->years_of_service . ' tahun'
                                        : '-',
                                    'Pendapatan Bulanan' => optional($user->respondent)->monthly_income_self
                                        ? 'RM ' . number_format($user->respondent->monthly_income_self, 2)
                                        : '-',
                                    'Pendapatan Pasangan' => optional($user->respondent)->monthly_income_spouse
                                        ? 'RM ' . number_format($user->respondent->monthly_income_spouse, 2)
                                        : '-',
                                ];
                            @endphp
                            @foreach ($employmentInfo as $label => $value)
                                <div class="flex justify-between items-center py-3 border-b border-gray-100 last:border-0">
                                    <span class="text-gray-600">{{ $label }}</span>
                                    <span class="font-medium text-gray-900 text-right">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Surveys Tab -->
            <div id="surveys-content" class="tab-pane hidden">
                @if ($responses->isEmpty())
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-12 text-center">
                        <i class="fas fa-clipboard-list text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Tiada Tinjauan</h3>
                        <p class="text-gray-600">Responder ini belum menjawab sebarang tinjauan.</p>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach ($responses as $response)
                            <div
                                class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="text-lg font-bold">Tinjauan #{{ $response['id'] }}</h4>
                                            <p class="text-blue-100 text-sm">{{ $response['created_at'] }}</p>
                                        </div>
                                        <span
                                            class="px-3 py-1 rounded-full text-sm font-medium
                                                {{ $response['completed'] ? 'bg-green-500 text-white' : 'bg-yellow-500 text-white' }}">
                                            {{ $response['completed'] ? 'Selesai' : 'Dalam Proses' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="p-6">
                                    @if (count($response['answers']) > 0)
                                        <div class="mb-4">
                                            <h5 class="font-bold text-gray-900 mb-3">Jawapan</h5>
                                            <div class="space-y-2">
                                                @foreach ($response['answers'] as $answer)
                                                    <div
                                                        class="flex justify-between items-start py-2 border-b border-gray-100 last:border-0">
                                                        <span class="text-gray-600 text-sm">Soalan
                                                            #{{ $answer['question_id'] }}</span>
                                                        <span class="font-medium text-gray-900 text-right max-w-xs text-sm">
                                                            @if (is_array($answer['answer']))
                                                                {{ implode(', ', $answer['answer']) }}
                                                            @else
                                                                {{ $answer['answer'] }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if (count($response['scores']) > 0)
                                        <div>
                                            <h5 class="font-bold text-gray-900 mb-3">Skor</h5>
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                                @foreach ($response['scores'] as $score)
                                                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                                                        <div class="text-xs text-gray-600 mb-1">
                                                            {{ $score['category'] }}</div>
                                                        <div class="text-lg font-bold text-primary">
                                                            {{ $score['score'] }}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Analytics Tab -->
            <div id="analytics-content" class="tab-pane hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Completion Rate Chart -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Status Tinjauan</h3>
                        <div class="flex items-center justify-center">
                            <div class="relative w-48 h-48">
                                <svg class="w-48 h-48 transform -rotate-90">
                                    @php
                                        $total = $responses->count();
                                        $completed = $responses->where('completed', true)->count();
                                        $percentage = $total > 0 ? ($completed / $total) * 100 : 0;
                                    @endphp
                                    <circle cx="96" cy="96" r="80" stroke="#e5e7eb" stroke-width="12"
                                        fill="none" />
                                    <circle cx="96" cy="96" r="80" stroke="#10b981" stroke-width="12"
                                        fill="none" stroke-dasharray="{{ 2 * pi() * 80 }}"
                                        stroke-dashoffset="{{ 2 * pi() * 80 * (1 - $percentage / 100) }}"
                                        class="transition-all duration-1000" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-gray-900">{{ round($percentage) }}%</div>
                                        <div class="text-sm text-gray-600">Selesai</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Average Scores -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Skor Purata</h3>
                        @php
                            $averageScores = [];
                            foreach ($responses as $response) {
                                foreach ($response['scores'] as $score) {
                                    if (!isset($averageScores[$score['category']])) {
                                        $averageScores[$score['category']] = [];
                                    }
                                    $averageScores[$score['category']][] = $score['score'];
                                }
                            }
                        @endphp

                        @if (!empty($averageScores))
                            <div class="space-y-4">
                                @foreach ($averageScores as $category => $scores)
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-medium text-gray-700">{{ $category }}</span>
                                            <span class="text-sm font-medium text-gray-900">
                                                {{ round(array_sum($scores) / count($scores), 1) }}
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full"
                                                style="width: {{ min((array_sum($scores) / count($scores)) * 10, 100) }}%">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">Tiada data skor tersedia</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .animation-delay-2000 {
                animation-delay: 2s;
            }

            .animation-delay-4000 {
                animation-delay: 4s;
            }

            .tab-btn.active {
                color: #3b82f6;
                border-color: #3b82f6;
            }

            .tab-pane {
                animation: fadeIn 0.3s ease-in-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @media (max-width: 640px) {
                .tab-btn {
                    padding: 0.75rem 1rem;
                    font-size: 0.875rem;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            function showTab(tabName) {
                // Hide all tab panes
                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.classList.add('hidden');
                });

                // Remove active class from all tab buttons
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    btn.classList.remove('active');
                });

                // Show selected tab
                document.getElementById(tabName + '-content').classList.remove('hidden');

                // Add active class to clicked button
                event.target.classList.add('active');
            }

            function printProfile() {
                window.print();
            }

            function exportData() {
                // Implement export functionality
                alert('Export functionality will be implemented');
            }

            // Initialize with profile tab active
            document.addEventListener('DOMContentLoaded', function() {
                const profileBtn = document.querySelector('[data-tab="profile"]');
                if (profileBtn) {
                    profileBtn.classList.add('active');
                }
            });
        </script>
    @endpush
@endsection
