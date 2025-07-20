@extends('layouts.app')

@section('title', 'Senarai Responder - Admin')

@section('content')
    <div>
        <div class="container mx-auto">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">
                            <i class="fas fa-users text-indigo-600 mr-3"></i>
                            Senarai Responder
                        </h1>
                        <p class="text-gray-600">Kelola dan pantau semua responder sistem</p>
                    </div>
                    {{-- <div class="flex gap-3">
                        <button class="btn btn-outline btn-primary" onclick="exportData()">
                            <i class="fas fa-download mr-2"></i>
                            Export
                        </button>
                        <button class="btn btn-primary" onclick="refreshData()">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Refresh
                        </button>
                    </div> --}}
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="stat-card bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Responder</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format(count($responders)) }}</p>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Selesai Tinjauan</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ collect($responders)->sum('completed_surveys') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-clock text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Dalam Proses</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ collect($responders)->sum('total_surveys') - collect($responders)->sum('completed_surveys') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- <div class="stat-card bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-calendar-alt text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Bulan Ini</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ collect($responders)->where('created_at', '>=', now()->startOfMonth())->count() }}
                            </p>
                        </div>
                    </div>
                </div> --}}
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cari Responder</label>
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Cari nama, email, atau lokasi..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>

                    {{-- <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jantina</label>
                        <select id="genderFilter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            <option value="">Semua</option>
                            <option value="Lelaki">Lelaki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                        <select id="locationFilter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            <option value="">Semua Lokasi</option>
                            @foreach (collect($responders)->pluck('location')->unique()->sort() as $location)
                                <option value="{{ $location }}">{{ $location }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                </div>
            </div>

            <!-- Responsive Table -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="respondersTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Bil
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Responder
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Hubungi
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Lokasi
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status Tinjauan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tarikh Daftar
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tindakan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="respondersTableBody">
                            @forelse($responders as $index => $responder)
                                <tr class="hover:bg-gray-50 transition-colors duration-200 responder-row"
                                    data-gender="{{ $responder['gender'] }}" data-location="{{ $responder['location'] }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-left">
                                                <div class="text-sm font-medium text-gray-900">{{ $responder['name'] }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $responder['age'] }} tahun</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left">
                                        <div class="text-sm text-gray-900">{{ $responder['email'] }}</div>
                                        <div class="text-sm text-gray-500">{{ $responder['phone'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $responder['location'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-1">
                                                <div class="flex justify-between text-sm">
                                                    <span class="text-gray-600">Selesai</span>
                                                    <span
                                                        class="font-medium">{{ $responder['completed_surveys'] }}/{{ $responder['total_surveys'] }}</span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                                    <div class="bg-green-500 h-2 rounded-full transition-all duration-300"
                                                        style="width: {{ $responder['total_surveys'] > 0 ? ($responder['completed_surveys'] / $responder['total_surveys']) * 100 : 0 }}%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($responder['created_at'])->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.responder.show', $responder['id']) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye mr-1"></i>
                                                Lihat
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="text-center">
                                            <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tiada responder ditemui</h3>
                                            <p class="text-gray-500">Tiada responder yang berdaftar dalam sistem buat masa
                                                ini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-200">
                    <div class="text-sm text-gray-700">
                        Menunjukkan <span class="font-medium">1</span> hingga <span
                            class="font-medium">{{ min(10, count($responders)) }}</span> daripada <span
                            class="font-medium">{{ count($responders) }}</span> responder
                    </div>
                    <div class="flex gap-2">
                        <button class="btn btn-sm btn-outline">Sebelum</button>
                        <button class="btn btn-sm btn-primary">1</button>
                        <button class="btn btn-sm btn-outline">Seterusnya</button>
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

            @media (max-width: 768px) {
                .container {
                    padding-left: 1rem;
                    padding-right: 1rem;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Search functionality
            document.getElementById('searchInput').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('.responder-row');

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });

            // Filter functionality
            document.getElementById('genderFilter').addEventListener('change', filterTable);
            document.getElementById('locationFilter').addEventListener('change', filterTable);

            function filterTable() {
                const genderFilter = document.getElementById('genderFilter').value;
                const locationFilter = document.getElementById('locationFilter').value;
                const rows = document.querySelectorAll('.responder-row');

                rows.forEach(row => {
                    const gender = row.dataset.gender;
                    const location = row.dataset.location;

                    const genderMatch = !genderFilter || gender === genderFilter;
                    const locationMatch = !locationFilter || location === locationFilter;

                    row.style.display = genderMatch && locationMatch ? '' : 'none';
                });
            }

            // Export functionality
            function exportData() {
                // Add export functionality here
                alert('Export functionality will be implemented');
            }

            function refreshData() {
                location.reload();
            }
        </script>
    @endpush
@endsection
