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
                                        'Tinggi' => optional($user->respondent)->height . ' cm' ?? '-',
                                        'Berat' => optional($user->respondent)->weight . ' kg' ?? '-',
                                        'BMI' => optional($user->respondent)->bmi . ' kg/m<sup>2</sup>' ?? '-',
                                    ];
                                @endphp
                                @foreach ($personalInfo as $label => $value)
                                    <div
                                        class="flex justify-between items-center py-3 border-b border-gray-100 last:border-0">
                                        <span class="text-gray-600 text-left">{{ $label }}</span>
                                        <span class="font-medium text-gray-900 text-right">{!! $value !!}</span>
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
                                        'Tempoh Perkhidmatan' => optional($user->respondent)->years_of_service
                                            ? optional($user->respondent)->years_of_service
                                            : '-',
                                        'Pendapatan Bulanan' => optional($user->respondent)->monthly_income_self
                                            ? 'RM ' . number_format($user->respondent->monthly_income_self, 2)
                                            : '-',
                                        'Pendapatan Pasangan' => optional($user->respondent)->monthly_income_spouse
                                            ? 'RM ' . number_format($user->respondent->monthly_income_spouse, 2)
                                            : '-',
                                        'Pendapatan Isi Rumah' => optional($user->respondent)->household_income
                                            ? 'RM ' . number_format($user->respondent->household_income, 2)
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
                                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-briefcase text-green-500 mr-3"></i>
                                    Maklumat Kesihatan
                                </h3>
                                @php
                                    $masalah = optional($user->respondent)->health_issue
                                        ? json_decode(optional($user->respondent)->health_issue)
                                        : '-';
                                    $lain = '';

                                    $keyLain = 'Lain-lain';
                                    if (in_array($keyLain, $masalah)) {
                                        if (!optional($user->respondent)->other_health_issue) {
                                            $lain = $keyLain;
                                        } else {
                                            $lain =
                                                'Lain-lain (' . optional($user->respondent)->other_health_issue . ')';
                                        }

                                        foreach ($masalah as $key => $val) {
                                            if ($val == $keyLain) {
                                                $masalah[$key] = $lain;
                                            }
                                        }
                                    }
                                    $healthtInfo = [
                                        'Kesihatan' => optional($user->respondent)->health ?? '-',
                                        'Kumpulan Darah' => optional($user->respondent)->blood_type ?? '-',
                                        'Masalah Kesihatan' => implode(', ', $masalah),
                                    ];
                                @endphp
                                @foreach ($healthtInfo as $label => $value)
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
                                                    <h4 class="text-lg font-bold text-left">
                                                        {{ getFullSectionTitle($response['survey_id']) }}</h4>
                                                </div>
                                                <div class="flex justify-between gap-5">
                                                    <span
                                                        class="text-blue-100 text-sm m-auto">{{ $response['created_at'] ?? 'N/A' }}
                                                    </span>
                                                    <span
                                                        class="px-3 h-[30px] py-1 rounded-full text-sm font-medium {{ $response['completed'] ? 'bg-green-500 text-white' : 'bg-yellow-500 text-white' }}">
                                                        {{ $response['completed'] ? 'Selesai' : 'Dalam Proses' }}
                                                    </span>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="collapse-content text-sm">
                                            <!-- Section Scores Display -->
                                            @if (count($response['scores']) > 0)
                                                <div class="mb-6 rounded-lg p-4">
                                                    <div class="grid grid-cols-1 gap-3">
                                                        @foreach ($response['scores'] as $sectionData)
                                                            <div
                                                                class="bg-white rounded-lg p-3 shadow-sm border-l-4 border-blue-500">
                                                                <div class="font-bold text-gray-800 mb-2">
                                                                    {{ $sectionData['section_title'] }}
                                                                </div>
                                                                <div class="space-y-1">
                                                                    @foreach ($sectionData['scores'] as $score)
                                                                        @if ($score['category'])
                                                                            <div class="flex justify-between items-center">

                                                                                <span
                                                                                    class="text-sm text-gray-600 font-bold">
                                                                                    {{ $score['category'] }}:
                                                                                </span>

                                                                                <span class="font-bold text-blue-600">
                                                                                    {{ number_format($score['score'], 2) }}
                                                                                </span>
                                                                            </div>
                                                                        @else
                                                                            <div class="text-right -mt-6">
                                                                                <span class="font-bold text-blue-600">
                                                                                    {{ number_format($score['score'], 2) }}
                                                                                </span>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                                @if (isset($sectionData['scores'][0]['recommendation']) && $sectionData['scores'][0]['recommendation'])
                                                                    <div class="mt-2 pt-2 border-t border-gray-200">
                                                                        <span class="text-sm text-gray-500">
                                                                            {{ $sectionData['scores'][0]['recommendation'] }}
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

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
                                                    @endphp

                                                    @foreach ($groupedAnswers as $subsectionName => $answers)
                                                        <div class="subsection-group bg-gray-50 rounded-lg p-4">
                                                            <div class="flex items-center justify-between mb-4">
                                                                <div>
                                                                    @if ($subsectionName && $subsectionName !== 'Lain-lain')
                                                                        <span class="text-lg font-bold text-green-700">
                                                                            {{ $subsectionName }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="space-y-3">
                                                                @foreach ($answers as $answer)
                                                                    <div class="bg-white rounded-lg p-2 shadow-sm">
                                                                        @if (!empty($answer['question_context']['image']))
                                                                            <div class="mb-2 text-center">
                                                                                <img src="{{ asset($answer['question_context']['image']) }}"
                                                                                    alt="Question Image"
                                                                                    class="mx-auto max-h-48 object-contain" />
                                                                            </div>
                                                                        @endif
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
                                                                            @php
                                                                                $answerValue = $answer['answer'] ?? '';
                                                                                $isJson = false;
                                                                                $decodedAnswer = null;

                                                                                if (is_string($answerValue)) {
                                                                                    $decodedAnswer = json_decode(
                                                                                        $answerValue,
                                                                                        true,
                                                                                    );
                                                                                    $isJson =
                                                                                        json_last_error() ===
                                                                                            JSON_ERROR_NONE &&
                                                                                        is_array($decodedAnswer);
                                                                                }
                                                                            @endphp

                                                                            @if ($isJson && is_array($decodedAnswer))
                                                                                <ul
                                                                                    class="list-disc list-inside space-y-1 mt-2">
                                                                                    @foreach ($decodedAnswer as $item)
                                                                                        <li class="text-gray-700">
                                                                                            {{ is_array($item) ? implode(', ', $item) : htmlspecialchars((string) $item) }}
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            @elseif (is_array($answerValue))
                                                                                <ul
                                                                                    class="list-disc list-inside space-y-1 mt-2">
                                                                                    @foreach ($answerValue as $item)
                                                                                        <li class="text-gray-700">
                                                                                            {{ is_array($item) ? implode(', ', $item) : htmlspecialchars((string) $item) }}
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            @else
                                                                                <span
                                                                                    class="text-gray-700">{{ $answerValue }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
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
