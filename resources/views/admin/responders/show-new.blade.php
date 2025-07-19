@extends('layouts.app')

@section('title', 'Maklumat Responder - ' . $user->name)

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center">
                        <a href="{{ route('admin.responders') }}" class="btn btn-ghost btn-circle mr-4">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                                {{ $user->name }}
                            </h1>
                            <p class="text-gray-600">Maklumat lengkap responder dan tinjauan</p>
                        </div>
                    </div>
                    {{-- <div class="flex gap-3">
                        <button class="btn btn-outline btn-primary" onclick="printProfile()">
                            <i class="fas fa-print mr-2"></i>
                            Cetak
                        </button>
                        <button class="btn btn-primary" onclick="sendEmail()">
                            <i class="fas fa-envelope mr-2"></i>
                            Email
                        </button>
                    </div> --}}
                </div>
            </div>

            <!-- Profile Overview Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="flex-shrink-0">
                        <div
                            class="w-24 h-24 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white text-3xl font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="flex-1 text-center md:text-left">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-3">
                            <span class="badge badge-primary">{{ $user->respondent->gender ?? '-' }}</span>
                            <span class="badge badge-secondary">{{ $user->respondent->age ?? '-' }} tahun</span>
                            <span class="badge badge-accent">{{ $user->respondent->location ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="text-center md:text-right">
                        <div class="stats stats-vertical shadow">
                            <div class="stat">
                                <div class="stat-title">Tinjauan Selesai</div>
                                <div class="stat-value text-primary">{{ $responses->where('completed', true)->count() }}
                                </div>
                            </div>
                            <div class="stat">
                                <div class="stat-title">Jumlah Tinjauan</div>
                                <div class="stat-value">{{ $responses->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="tabs tabs-boxed bg-white shadow-lg rounded-xl mb-6">
                <button class="tab tab-active" onclick="showTab('profile')">
                    <i class="fas fa-user mr-2"></i>
                    Profil
                </button>
                <button class="tab" onclick="showTab('surveys')">
                    <i class="fas fa-clipboard-list mr-2"></i>
                    Tinjauan
                </button>
                <button class="tab" onclick="showTab('analytics')">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Analitik
                </button>
            </div>

            <!-- Profile Tab -->
            <div id="profile-tab" class="tab-content">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-user-circle text-blue-500 mr-3"></i>
                            Maklumat Peribadi
                        </h3>
                        <div class="space-y-4">
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="text-gray-600">Nama Penuh</span>
                                <span class="font-medium text-gray-900">{{ $user->name }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="text-gray-600">Email</span>
                                <span class="font-medium text-gray-900">{{ $user->email }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="text-gray-600">No. Telefon</span>
                                <span class="font-medium text-gray-900">{{ $user->respondent->phone_number ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="text-gray-600">Umur</span>
                                <span class="font-medium text-gray-900">{{ $user->respondent->age ?? '-' }} tahun</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="text-gray-600">Jantina</span>
                                <span class="font-medium text-gray-900">{{ $user->respondent->gender ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="text-gray-600">Etnik</span>
                                <span class="font-medium text-gray-900">{{ $user->respondent->ethnicity ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="text-gray-600">Status Perkahwinan</span>
                                <span
                                    class="font-medium text-gray-900">{{ $user->respondent->marital_status ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between py-3">
                                <span class="text-gray-600">Taraf Pendidikan</span>
                                <span
                                    class="font-medium text-gray-900">{{ $user->respondent->education_level ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Employment Information -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-briefcase text-green-500 mr-3"></i>
                            Maklumat Pekerjaan
                        </h3>
                        <div class="space-y-4">
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="text-gray-600">Lokasi</span>
                                <span class="font-medium text-gray-900">{{ $user->respondent->location ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="text-gray-600">Jawatan</span>
                                <span class="font-medium text-gray-900">{{ $user->respondent->position ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="text-gray-600">Gred</span>
                                <span class="font-medium text-gray-900">{{ $user->respondent->grade ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="text-gray-600">Status Perkhidmatan</span>
                                <span
                                    class="font-medium text-gray-900">{{ $user->respondent->service_status ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="text-gray-600">Tahun Perkhidmatan</span>
                                <span class="font-medium text-gray-900">{{ $user->respondent->years_of_service ?? '-' }}
                                    tahun</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <span class="text-gray-600">Pendapatan Bulanan</span>
                                <span class="font-medium text-gray-900">RM
                                    {{ number_format($user->respondent->monthly_income_self ?? 0, 2) }}</span>
                            </div>
                            <div class="flex justify-between py-3">
                                <span class="text-gray-600">Pendapatan Pasangan</span>
                                <span class="font-medium text-gray-900">RM
                                    {{ number_format($user->respondent->monthly_income_spouse ?? 0, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Surveys Tab -->
            <div id="surveys-tab" class="tab-content hidden">
                <div class="space-y-6">
                    @forelse($responses as $response)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h4 class="text-lg font-bold">Tinjauan #{{ $response['id'] }}</h4>
                                        <p class="text-blue-100">{{ $response['created_at'] }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="badge {{ $response['completed'] ? 'badge-success' : 'badge-warning' }}">
                                            {{ $response['completed'] ? 'Selesai' : 'Dalam Proses' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6">
                                @if (count($response['answers']) > 0)
                                    <div class="mb-4">
                                        <h5 class="font-bold text-gray-900 mb-3">Jawapan</h5>
                                        <div class="space-y-3">
                                            @foreach ($response['answers'] as $answer)
                                                <div
                                                    class="flex justify-between items-start py-2 border-b border-gray-100">
                                                    <span class="text-gray-600">Soalan
                                                        #{{ $answer['question_id'] }}</span>
                                                    <span class="font-medium text-gray-900 text-right max-w-xs">
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
                                                <div class="text-center p-4 bg-gray-50 rounded-lg">
                                                    <div class="text-sm text-gray-600 mb-1">{{ $score['category'] }}</div>
                                                    <div class="text-2xl font-bold text-primary">{{ $score['score'] }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                            <i class="fas fa-clipboard-list text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Tiada Tinjauan</h3>
                            <p class="text-gray-600">Responder ini belum menjawab sebarang tinjauan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Analytics Tab -->
            <div id="analytics-tab" class="tab-content hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Survey Completion Chart -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Status Tinjauan</h3>
                        <div class="flex items-center justify-center">
                            <div class="relative w-48 h-48">
                                <svg class="w-48 h-48 transform -rotate-90">
                                    <circle cx="96" cy="96" r="80" stroke="#e5e7eb" stroke-width="12"
                                        fill="none" />
                                    <circle cx="96" cy="96" r="80" stroke="#10b981" stroke-width="12"
                                        fill="none" stroke-dasharray="{{ 2 * pi() * 80 }}"
                                        stroke-dashoffset="{{ 2 * pi() * 80 * (1 - $responses->where('completed', true)->count() / max($responses->count(), 1)) }}" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-900">
                                            {{ $responses->where('completed', true)->count() }}</div>
                                        <div class="text-sm text-gray-600">Selesai</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Average Scores -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Skor Purata</h3>
                        <div class="space-y-4">
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

                            @foreach ($averageScores as $category => $scores)
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">{{ $category }}</span>
                                        <span
                                            class="text-sm font-medium text-gray-900">{{ round(array_sum($scores) / count($scores), 1) }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full"
                                            style="width: {{ (array_sum($scores) / count($scores)) * 10 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .tab-content {
                transition: all 0.3s ease-in-out;
            }

            .tab-active {
                background-color: #3b82f6 !important;
                color: white !important;
            }

            @media print {

                .tabs,
                .btn,
                .flex.justify-between {
                    display: none !important;
                }

                .tab-content {
                    display: block !important;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            function showTab(tabName) {
                // Hide all tabs
                document.querySelectorAll('.tab-content').forEach(tab => {
                    tab.classList.add('hidden');
                });

                // Remove active class from all tabs
                document.querySelectorAll('.tab').forEach(tab => {
                    tab.classList.remove('tab-active');
                });

                // Show selected tab
                document.getElementById(tabName + '-tab').classList.remove('hidden');

                // Add active class to clicked tab
                event.target.classList.add('tab-active');
            }

            function printProfile() {
                window.print();
            }

            function sendEmail() {
                alert('Email functionality will be implemented');
            }
        </script>
    @endpush
@endsection
