@extends('layouts.app')

@section('title', 'Maklumat Responder - ' . $user->name)

@section('content')
    <div>
        <div class="container mx-auto">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center">
                        <a href="{{ route('admin.responders') }}"
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 transition-all duration-200 mr-4">
                            <i class="fas fa-arrow-left text-gray-600"></i>
                        </a>
                        <div class="text-left">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                                <i class="fas fa-user text-indigo-600 mr-3"></i>
                                {{ $user->name }}
                            </h1>
                            <p class="text-gray-600">Maklumat lengkap responder dan tinjauan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                <div class="stat-card bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-clipboard-check text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Tinjauan Selesai</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $responses->where('completed', true)->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- <div class="stat-card bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                                                                                                                                                                                                                                                                        <div class="flex items-center">
                                                                                                                                                                                                                                                                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                                                                                                                                                                                                                                                                <i class="fas fa-chart-line text-2xl"></i>
                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                            <div class="ml-4">
                                                                                                                                                                                                                                                                                <p class="text-sm font-medium text-gray-600">Jumlah Tinjauan</p>
                                                                                                                                                                                                                                                                                <p class="text-2xl font-bold text-gray-900">{{ $responses->count() }}</p>
                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                    </div> -->

                <div class="stat-card bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-percentage text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Kadar Penyelesaian</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $responses->count() > 0 ? round(($responses->where('completed', true)->count() / $responses->count()) * 100) : 0 }}%
                            </p>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                            <i class="fas fa-calendar text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Tarikh Daftar</p>
                            <p class="text-lg font-bold text-gray-900">{{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <nav class="flex flex-wrap border-b border-gray-200">
                    <button type="button"
                        class="tab-btn flex-1 sm:flex-none px-6 py-3 text-sm font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-indigo-500 transition-all duration-200 active"
                        data-tab="profile">
                        <i class="fas fa-user mr-2"></i>
                        Profil
                    </button>
                    <button type="button"
                        class="tab-btn flex-1 sm:flex-none px-6 py-3 text-sm font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-indigo-500 transition-all duration-200"
                        data-tab="surveys">
                        <i class="fas fa-clipboard-list mr-2"></i>
                        Tinjauan
                    </button>
                    <!-- <button type="button"
                                                                                                                                                                                                                                                                            class="tab-btn flex-1 sm:flex-none px-6 py-3 text-sm font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-indigo-500 transition-all duration-200"
                                                                                                                                                                                                                                                                            data-tab="analytics">
                                                                                                                                                                                                                                                                            <i class="fas fa-chart-bar mr-2"></i>
                                                                                                                                                                                                                                                                            Analitik
                                                                                                                                                                                                                                                                        </button> -->
                </nav>
            </div>

            <!-- Tab Contents -->
            <div class="tab-contents">
                <!-- Profile Tab -->
                <div id="profile-content" class="tab-pane">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Personal Information Card -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
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
                                    <div
                                        class="flex justify-between items-center py-3 border-b border-gray-100 last:border-0">
                                        <span class="text-gray-600 text-left">{{ $label }}</span>
                                        <span class="font-medium text-gray-900 text-right">{{ $value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Employment Information Card -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
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
                                    <div
                                        class="flex justify-between items-center py-3 border-b border-gray-100 last:border-0">
                                        <span class="text-gray-600 text-left">{{ $label }}</span>
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
                        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                            <i class="fas fa-clipboard-list text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Tiada Tinjauan</h3>
                            <p class="text-gray-600">Responder ini belum menjawab sebarang tinjauan.</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach ($responses as $response)
                                @if (count($response['answers']) > 0)
                                    <div tabindex="0"
                                        class="my-2 bg-white text-primary-content focus:bg-white focus:text-black collapse">
                                        <div
                                            class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-4 collapse-title font-bold">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <h4 class="text-lg font-bold">
                                                        {{ getFullSectionTitle($response['survey_id']) }}</h4>
                                                </div>
                                                <div class="flex justify-between gap-5">
                                                    <span
                                                        class="text-blue-100 text-sm m-auto">{{ $response['created_at'] ?? 'N/A' }}
                                                    </span>
                                                    <span
                                                        class="px-3 py-1 rounded-full text-sm font-medium {{ $response['completed'] ? 'bg-green-500 text-white' : 'bg-yellow-500 text-white' }}">
                                                        {{ $response['completed'] ? 'Selesai' : 'Dalam Proses' }}
                                                    </span>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="collapse-content text-sm">
                                            @if (count($response['answers']) > 0)
                                                <div class="space-y-6">
                                                    @php
                                                        // Group answers by subsection
                                                        $groupedAnswers = collect($response['answers'])->groupBy(
                                                            function ($answer) {
                                                                return $answer['question_context']['subsection_name'] ??
                                                                    'Lain-lain';
                                                            },
                                                        );

                                                        // Group scores by subsection
                                                        $groupedScores = collect($response['scores'] ?? [])->groupBy(
                                                            function ($score) {
                                                                return $score['category'] ?? 'Lain-lain';
                                                            },
                                                        );
                                                    @endphp

                                                    @foreach ($groupedAnswers as $subsectionName => $answers)
                                                        <div class="subsection-group bg-gray-50 rounded-lg p-4">
                                                            <div class="flex items-center justify-between mb-4">
                                                                <div>
                                                                    @if ($subsectionName && $subsectionName !== 'Lain-lain')
                                                                        <span class="text-lg font-bold text-green-700">
                                                                            {{ $subsectionName }}
                                                                        </span>
                                                                    @else
                                                                        <span class="text-lg font-bold text-gray-700">
                                                                            Soalan Umum
                                                                        </span>
                                                                    @endif
                                                                </div>

                                                                @if ($groupedScores->has($subsectionName))
                                                                    @php
                                                                        $subsectionScores =
                                                                            $groupedScores[$subsectionName];
                                                                    @endphp
                                                                    <div class="flex flex-wrap gap-2">
                                                                        @foreach ($subsectionScores as $score)
                                                                            <div
                                                                                class="bg-white rounded-md px-3 py-1 shadow-sm">
                                                                                <span
                                                                                    class="text-sm font-bold text-blue-600">
                                                                                    {{ $score['score'] }}
                                                                                </span>
                                                                                <span class="text-xs text-gray-500 ml-1">
                                                                                    {{ $score['category'] }}
                                                                                </span>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <div class="space-y-3">
                                                                @foreach ($answers as $answer)
                                                                    <div class="bg-white rounded-lg p-4 shadow-sm">
                                                                        <div
                                                                            class="text-sm font-medium text-gray-900 mb-2 text-left">

                                                                            @php
                                                                                $fullContext =
                                                                                    $answer['question_context'][
                                                                                        'full_context'
                                                                                    ] ?? '';
                                                                                if (
                                                                                    preg_match(
                                                                                        '/Soalan\s+[A-Z]?\d+\s*:\s*(.+)$/i',
                                                                                        $fullContext,
                                                                                        $matches,
                                                                                    )
                                                                                ) {
                                                                                    echo trim($matches[1]);
                                                                                } else {
                                                                                    echo $fullContext;
                                                                                }
                                                                            @endphp
                                                                        </div>
                                                                        <div class="text-sm text-gray-700 text-left">
                                                                            <span class="font-medium">Jawapan:</span>
                                                                            @if (is_array($answer['answer']))
                                                                                {{ implode(', ', $answer['answer']) }}
                                                                            @else
                                                                                {{ $answer['answer'] }}
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            <!-- Enhanced Score Display -->
                                                            @if ($groupedScores->has($subsectionName))
                                                                <div class="mt-4 pt-3 border-t border-gray-200">
                                                                    <h5
                                                                        class="text-sm font-bold text-gray-700 mb-3 flex items-center">
                                                                        <i class="fas fa-chart-bar text-blue-500 mr-2"></i>
                                                                        Skor & Penilaian
                                                                    </h5>

                                                                    <div
                                                                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                                                        @foreach ($groupedScores[$subsectionName] as $score)
                                                                            @php
                                                                                $scoreValue = $score['score'] ?? 0;
                                                                                $maxScore = $score['max_score'] ?? 100;
                                                                                $percentage =
                                                                                    $maxScore > 0
                                                                                        ? ($scoreValue / $maxScore) *
                                                                                            100
                                                                                        : 0;

                                                                                // Determine color based on score percentage
                                                                                $colorClass = 'text-red-600';
                                                                                if ($percentage >= 80) {
                                                                                    $colorClass = 'text-green-600';
                                                                                } elseif ($percentage >= 60) {
                                                                                    $colorClass = 'text-yellow-600';
                                                                                } elseif ($percentage >= 40) {
                                                                                    $colorClass = 'text-orange-600';
                                                                                }
                                                                            @endphp

                                                                            <div
                                                                                class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-blue-500">
                                                                                <div
                                                                                    class="flex items-center justify-between mb-2">
                                                                                    <span
                                                                                        class="text-sm font-semibold text-gray-700">{{ $score['category'] }}</span>
                                                                                    <span
                                                                                        class="text-lg font-bold {{ $colorClass }}">
                                                                                        {{ $scoreValue }}/{{ $maxScore }}
                                                                                    </span>
                                                                                </div>

                                                                                <!-- Progress Bar -->
                                                                                <div
                                                                                    class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                                                                    <div class="bg-blue-600 h-2 rounded-full"
                                                                                        style="width: {{ min($percentage, 100) }}%">
                                                                                    </div>
                                                                                </div>

                                                                                <div class="text-xs text-gray-600">
                                                                                    {{ round($percentage, 1) }}% -
                                                                                    @if ($percentage >= 80)
                                                                                        <span
                                                                                            class="text-green-600 font-medium">Cemerlang</span>
                                                                                    @elseif($percentage >= 60)
                                                                                        <span
                                                                                            class="text-yellow-600 font-medium">Baik</span>
                                                                                    @elseif($percentage >= 40)
                                                                                        <span
                                                                                            class="text-orange-600 font-medium">Sederhana</span>
                                                                                    @else
                                                                                        <span
                                                                                            class="text-red-600 font-medium">Perlu
                                                                                            Perhatian</span>
                                                                                    @endif
                                                                                </div>

                                                                                @if (isset($score['recommendation']) && !empty($score['recommendation']))
                                                                                    <div
                                                                                        class="mt-2 p-2 bg-blue-50 rounded-md">
                                                                                        <div class="text-xs text-blue-800">
                                                                                            <strong>Rekomendasi:</strong>
                                                                                            {{ $score['recommendation'] }}
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Analytics Tab -->
                <div id="analytics-content" class="tab-pane hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Completion Rate Chart -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
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

                        <!-- Enhanced Average Scores -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-chart-line text-green-500 mr-2"></i>
                                Skor Purata & Analitik
                            </h3>
                            @php
                                $averageScores = [];
                                $scoreRanges = [
                                    'Cemerlang' => ['min' => 80, 'max' => 100, 'color' => 'green', 'count' => 0],
                                    'Baik' => ['min' => 60, 'max' => 79, 'color' => 'yellow', 'count' => 0],
                                    'Sederhana' => ['min' => 40, 'max' => 59, 'color' => 'orange', 'count' => 0],
                                    'Perlu Perhatian' => ['min' => 0, 'max' => 39, 'color' => 'red', 'count' => 0],
                                ];

                                foreach ($responses as $response) {
                                    foreach ($response['scores'] as $score) {
                                        if (!isset($averageScores[$score['category']])) {
                                            $averageScores[$score['category']] = [];
                                        }
                                        $averageScores[$score['category']][] = $score['score'];

                                        // Categorize score
                                        $scoreValue = $score['score'] ?? 0;
                                        foreach ($scoreRanges as $range => $details) {
                                            if ($scoreValue >= $details['min'] && $scoreValue <= $details['max']) {
                                                $scoreRanges[$range]['count']++;
                                                break;
                                            }
                                        }
                                    }
                                }
                            @endphp

                            @if (!empty($averageScores))
                                <div class="space-y-4">
                                    @foreach ($averageScores as $category => $scores)
                                        @php
                                            $avgScore = round(array_sum($scores) / count($scores), 1);
                                            $colorClass = 'text-red-600';
                                            if ($avgScore >= 80) {
                                                $colorClass = 'text-green-600';
                                            } elseif ($avgScore >= 60) {
                                                $colorClass = 'text-yellow-600';
                                            } elseif ($avgScore >= 40) {
                                                $colorClass = 'text-orange-600';
                                            }
                                        @endphp
                                        <div class="border rounded-lg p-3">
                                            <div class="flex justify-between items-center mb-2">
                                                <span
                                                    class="text-sm font-semibold text-gray-700">{{ $category }}</span>
                                                <span class="text-lg font-bold {{ $colorClass }}">
                                                    {{ $avgScore }}
                                                </span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full"
                                                    style="width: {{ min($avgScore * 1.25, 100) }}%"></div>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                Berdasarkan {{ count($scores) }} penilaian
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Score Distribution -->
                                <div class="mt-6 pt-4 border-t">
                                    <h4 class="text-sm font-bold text-gray-700 mb-3">Taburan Skor</h4>
                                    <div class="grid grid-cols-2 gap-2">
                                        @foreach ($scoreRanges as $range => $details)
                                            @if ($details['count'] > 0)
                                                <div class="text-center p-2 rounded-md bg-{{ $details['color'] }}-50">
                                                    <div class="text-lg font-bold text-{{ $details['color'] }}-600">
                                                        {{ $details['count'] }}
                                                    </div>
                                                    <div class="text-xs text-{{ $details['color'] }}-700">
                                                        {{ $range }}
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-500 text-center py-8">Tiada data skor tersedia</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .stat-card {
                transition: transform 0.2s ease-in-out;
            }

            .stat-card:hover {
                transform: translateY(-2px);
            }

            .tab-btn.active {
                color: #4f46e5;
                border-color: #4f46e5;
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
            function showTab(tabName, event) {
                try {
                    // Hide all tab panes
                    document.querySelectorAll('.tab-pane').forEach(pane => {
                        pane.classList.add('hidden');
                    });

                    // Remove active class from all tab buttons
                    document.querySelectorAll('.tab-btn').forEach(btn => {
                        btn.classList.remove('active');
                    });

                    // Show selected tab
                    const targetTab = document.getElementById(tabName + '-content');
                    if (targetTab) {
                        targetTab.classList.remove('hidden');
                    }

                    // Add active class to clicked button
                    if (event && event.target) {
                        event.target.classList.add('active');
                    } else {
                        // Fallback: find button by data-tab attribute
                        const button = document.querySelector(`[data-tab="${tabName}"]`);
                        if (button) {
                            button.classList.add('active');
                        }
                    }
                } catch (error) {
                    console.error('Error switching tabs:', error);
                }
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
                try {
                    const profileBtn = document.querySelector('[data-tab="profile"]');
                    if (profileBtn) {
                        profileBtn.classList.add('active');
                        // Ensure profile content is visible
                        const profileContent = document.getElementById('profile-content');
                        if (profileContent) {
                            profileContent.classList.remove('hidden');
                        }
                    }

                    // Add click event listeners to tab buttons
                    document.querySelectorAll('.tab-btn').forEach(btn => {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            const tabName = this.getAttribute('data-tab');
                            if (tabName) {
                                showTab(tabName, e);
                            }
                        });
                    });
                } catch (error) {
                    console.error('Error initializing tabs:', error);
                }
            });
        </script>
    @endpush
@endsection
