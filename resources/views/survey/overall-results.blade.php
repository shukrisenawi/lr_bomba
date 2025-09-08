@extends('layouts.app')

@section('title', 'Laporan Penilaian Fit-to-Work Keseluruhan')
@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">LAPORAN PENILAIAN FIT-TO-WORK</h1>
        <p class="text-lg text-gray-600">Jabatan Bomba & Penyelamat Malaysia (JBPM)</p>
    </div>

    <!-- Status Keseluruhan -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-bold text-center mb-4">STATUS KESELURUHAN</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p><strong>Nama Penuh:</strong> {{ $respondent ? $respondent->user->name : Auth::user()->name }}</p>
                <p><strong>Jawatan & Gred:</strong> {{ $respondent ? $respondent->current_position . ' (' . $respondent->grade . ')' : '-' }}</p>
                <p><strong>STATUS:</strong>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($overallStatus === 'LENGKAP') bg-green-100 text-green-800
                        @elseif($overallStatus === 'SEBAHAGIAN LENGKAP') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ $overallStatus }}
                    </span>
                </p>
            </div>
            <div>
                <p><strong>Ringkasan:</strong></p>
                <p class="text-sm text-gray-600">
                    @if($overallStatus === 'LENGKAP')
                        Hasil penilaian menunjukkan keupayaan dan produktiviti kerja yang baik. Semua bahagian telah dilengkapkan.
                    @elseif($overallStatus === 'SEBAHAGIAN LENGKAP')
                        Hasil penilaian menunjukkan beberapa aspek yang perlu diberi perhatian. Beberapa bahagian masih belum lengkap.
                    @else
                        Penilaian belum lengkap. Sila lengkapkan semua bahagian untuk mendapatkan laporan penuh.
                    @endif
                </p>
            </div>
        </div>
    </div>

    @if($overallStatus !== 'TIDAK LENGKAP')
    <!-- Profil Kesihatan Fizikal, Mental & Emosi -->
    @if(isset($sectionsData['B']))
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-bold text-center mb-6">PROFIL KESIHATAN FIZIKAL, MENTAL & EMOSI</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $sectionB = $sectionsData['B'];
                $respondentData = $sectionB['response'];
            @endphp

            <!-- Umur -->
            <div class="text-center">
                <h3 class="font-semibold text-lg mb-2">Umur</h3>
                <p class="text-2xl font-bold text-blue-600">{{ $respondent && $respondent->age ? $respondent->age : '-' }} Tahun</p>
            </div>

            <!-- BMI -->
            <div class="text-center">
                <h3 class="font-semibold text-lg mb-2">BMI</h3>
                <p class="text-2xl font-bold text-green-600">{{ $respondent && $respondent->bmi ? number_format($respondent->bmi, 1) : '-' }}</p>
                <p class="text-sm text-gray-600">{{ $respondent && $respondent->bmi ? ($respondent->bmi < 18.5 ? 'Berat badan kurang' : ($respondent->bmi < 25 ? 'Berat badan normal' : ($respondent->bmi < 30 ? 'Berat badan berlebihan' : 'Obesiti'))) : '-' }}</p>
            </div>

            <!-- Tahap Kesihatan -->
            <div class="text-center">
                <h3 class="font-semibold text-lg mb-2">Tahap Kesihatan</h3>
                <p class="text-2xl font-bold text-purple-600">Baik</p>
            </div>

            <!-- Kessler 6 -->
            @if($sectionB['subsectionScores'])
            @foreach($sectionB['subsectionScores'] as $score)
                @if(str_contains($score['name'], 'Kessler'))
                <div class="text-center">
                    <h3 class="font-semibold text-lg mb-2">Skala Kessler 6</h3>
                    <p class="text-2xl font-bold text-orange-600">Skor {{ $score['score'] }}</p>
                    <p class="text-sm text-gray-600">{{ $score['score'] < 8 ? 'Tidak mengalami tekanan psikologi yang teruk' : 'Mengalami tekanan psikologi' }}</p>
                </div>
                @endif
            @endforeach
            @endif

            <!-- CES-D -->
            @if($sectionB['subsectionScores'])
            @foreach($sectionB['subsectionScores'] as $score)
                @if(str_contains($score['name'], 'CES-D'))
                <div class="text-center">
                    <h3 class="font-semibold text-lg mb-2">Skala Simptom Kemurungan (CES-D)</h3>
                    <p class="text-2xl font-bold text-red-600">Skor {{ $score['score'] }}</p>
                    <p class="text-sm text-gray-600">{{ $score['score'] < 16 ? 'Tidak mengalami simptom kemurungan' : 'Mengalami simptom kemurungan yang sederhana/ringan' }}</p>
                </div>
                @endif
            @endforeach
            @endif

            <!-- Kepenatan -->
            @if($sectionB['subsectionScores'])
            @foreach($sectionB['subsectionScores'] as $score)
                @if(str_contains($score['name'], 'Kepenatan'))
                <div class="text-center">
                    <h3 class="font-semibold text-lg mb-2">Skala Penilaian Kepenatan</h3>
                    <p class="text-2xl font-bold text-yellow-600">Skor {{ number_format($score['score'], 2) }}</p>
                    <p class="text-sm text-gray-600">{{ $score['score'] > 3 ? 'Tinggi' : 'Rendah' }}</p>
                </div>
                @endif
            @endforeach
            @endif
        </div>

        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <h3 class="font-semibold mb-2">Ulasan:</h3>
            <p class="text-gray-600">Status fizikal, mental dan emosi berada pada tahap yang memuaskan berdasarkan penilaian yang dilakukan.</p>
        </div>
    </div>
    @endif

    <!-- Profil Produktiviti Kerja -->
    @if(isset($sectionsData['E']))
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-bold text-center mb-6">PROFIL PRODUKTIVITI KERJA</h2>
        @php
            $sectionE = $sectionsData['E'];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            @if($sectionE['subsectionScores'])
            @foreach($sectionE['subsectionScores'] as $score)
                @if(str_contains($score['name'], 'Prestasi Tugas'))
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <h3 class="font-semibold text-lg mb-2">Prestasi Tugas</h3>
                    <p class="text-3xl font-bold text-blue-600">Skor {{ $score['score'] }}</p>
                    <p class="text-sm text-gray-600">{{ $score['score'] >= 3.5 ? 'Tinggi' : ($score['score'] >= 2.5 ? 'Sederhana' : 'Rendah') }}</p>
                </div>
                @endif
            @endforeach

            @foreach($sectionE['subsectionScores'] as $score)
                @if(str_contains($score['name'], 'Prestasi Kontekstual'))
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <h3 class="font-semibold text-lg mb-2">Prestasi Kontekstual</h3>
                    <p class="text-3xl font-bold text-green-600">Skor {{ $score['score'] }}</p>
                    <p class="text-sm text-gray-600">{{ $score['score'] >= 3.5 ? 'Tinggi' : ($score['score'] >= 2.5 ? 'Sederhana' : 'Rendah') }}</p>
                </div>
                @endif
            @endforeach

            @foreach($sectionE['subsectionScores'] as $score)
                @if(str_contains($score['name'], 'Prilaku Kerja Produktif'))
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <h3 class="font-semibold text-lg mb-2">Prilaku Kerja Produktif</h3>
                    <p class="text-3xl font-bold text-purple-600">Skor {{ $score['score'] }}</p>
                    <p class="text-sm text-gray-600">{{ $score['score'] >= 3.5 ? 'Tinggi' : ($score['score'] >= 2.5 ? 'Sederhana' : 'Rendah') }}</p>
                </div>
                @endif
            @endforeach
            @endif
        </div>

        <div class="p-4 bg-gray-50 rounded-lg">
            <h3 class="font-semibold mb-2">Ulasan:</h3>
            <p class="text-gray-600">Prestasi kerja keseluruhan menunjukkan tahap yang baik dengan skor yang memuaskan dalam semua aspek produktiviti kerja.</p>
        </div>
    </div>
    @endif

    <!-- Profil Keupayaan Kerja -->
    @if(isset($sectionsData['C']))
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-bold text-center mb-6">PROFIL KEUPAYAAN KERJA</h2>
        @php
            $sectionC = $sectionsData['C'];
        @endphp

        <div class="text-center mb-6">
            <h3 class="font-semibold text-lg mb-2">Indeks Kebolehan Bekerja</h3>
            @if($sectionC['response']->scores->isNotEmpty())
                @php $waiScore = $sectionC['response']->scores->first(); @endphp
                <p class="text-3xl font-bold text-indigo-600">Skor {{ $waiScore->score }}</p>
                <p class="text-sm text-gray-600">{{ $waiScore->score >= 37 ? 'Baik' : ($waiScore->score >= 28 ? 'Sederhana' : 'Rendah') }}</p>
            @else
                <p class="text-3xl font-bold text-gray-600">-</p>
            @endif
        </div>

        <div class="p-4 bg-gray-50 rounded-lg">
            <h3 class="font-semibold mb-2">Ulasan:</h3>
            <p class="text-gray-600">Menunjukkan keupayaan kerja yang baik dari segi keadaan kesihatan fizikal dan mental berdasarkan penilaian yang dilakukan.</p>
        </div>
    </div>
    @endif

    <!-- Profil Ergonomik Pekerjaan -->
    @if(isset($sectionsData['A']))
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-bold text-center mb-6">PROFIL ERGONOMIK PEKERJAAN</h2>
        @php
            $sectionA = $sectionsData['A'];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="text-center p-4 bg-red-50 rounded-lg">
                <h3 class="font-semibold text-lg mb-2">Penilaian Anggota Badan Keseluruhan (REBA)</h3>
                @if($sectionA['response']->scores->where('section', 'Skor REBA Akhir')->first())
                    @php $rebaScore = $sectionA['response']->scores->where('section', 'Skor REBA Akhir')->first(); @endphp
                    <p class="text-3xl font-bold text-red-600">Skor {{ $rebaScore->score }}</p>
                    <p class="text-sm text-gray-600">{{ $rebaScore->score <= 3 ? 'Risiko rendah, perubahan mungkin diperlukan' : 'Risiko tinggi, perubahan diperlukan' }}</p>
                @else
                    <p class="text-3xl font-bold text-gray-600">-</p>
                @endif
            </div>

            <div class="text-center p-4 bg-orange-50 rounded-lg">
                <h3 class="font-semibold text-lg mb-2">Penilaian Kendiri Muskuloskeletal</h3>
                <p class="text-lg text-gray-600">Masalah pada beberapa anggota badan</p>
            </div>
        </div>

        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <h3 class="font-semibold mb-2">Ulasan:</h3>
            <p class="text-gray-600">Postur kerja berada dalam keadaan risiko yang perlu diberi perhatian. Beberapa anggota tubuh dikenalpasti berisiko MSD (Musculoskeletal Disorders).</p>
        </div>
    </div>
    @endif

    <!-- Cadangan/Tindakan -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-bold text-center mb-6">CADANGAN/TINDAKAN</h2>
        <div class="space-y-4">
            <div class="border-l-4 border-blue-500 pl-4">
                <p class="font-semibold">1. Pengurusan Kesihatan Mental</p>
                <p class="text-gray-600">Sesi kaunseling untuk pengurusan tekanan dan kemurungan jika diperlukan.</p>
            </div>
            <div class="border-l-4 border-green-500 pl-4">
                <p class="font-semibold">2. Program Ergonomik</p>
                <p class="text-gray-600">Latihan postur kerja yang betul dan penyesuaian workstation.</p>
            </div>
            <div class="border-l-4 border-purple-500 pl-4">
                <p class="font-semibold">3. Pemantauan Produktiviti</p>
                <p class="text-gray-600">Pemantauan berterusan terhadap prestasi kerja dan sokongan yang diperlukan.</p>
            </div>
        </div>
    </div>

    <!-- Kategori Status Skor Butiran -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-bold text-center mb-6">KATEGORI STATUS SKOR BUTIRAN</h2>
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="border border-gray-300 px-4 py-2 text-left">Aspek</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Status</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Skor</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Butiran</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Kecergasan</td>
                        <td class="border border-gray-300 px-4 py-2">Baik</td>
                        <td class="border border-gray-300 px-4 py-2">{{ isset($sectionsData['B']) && $sectionsData['B']['subsectionScores'] ? $sectionsData['B']['subsectionScores'][0]['score'] ?? '-' : '-' }}</td>
                        <td class="border border-gray-300 px-4 py-2">Status fizikal, mental dan emosi pada tahap sederhana</td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Keupayaan Kerja</td>
                        <td class="border border-gray-300 px-4 py-2">Baik</td>
                        <td class="border border-gray-300 px-4 py-2">{{ isset($sectionsData['C']) && $sectionsData['C']['response']->scores->isNotEmpty() ? $sectionsData['C']['response']->scores->first()->score : '-' }}</td>
                        <td class="border border-gray-300 px-4 py-2">Indeks Kebolehan Bekerja (WAI)</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Risiko Psikologi</td>
                        <td class="border border-gray-300 px-4 py-2">Sederhana</td>
                        <td class="border border-gray-300 px-4 py-2">{{ isset($sectionsData['B']) ? '16' : '-' }}</td>
                        <td class="border border-gray-300 px-4 py-2">Skala Kemurungan CES-D</td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Kepenatan</td>
                        <td class="border border-gray-300 px-4 py-2">Tinggi</td>
                        <td class="border border-gray-300 px-4 py-2">{{ isset($sectionsData['B']) ? '3.10' : '-' }}</td>
                        <td class="border border-gray-300 px-4 py-2">Instrumen Penilaian Kepenatan (BAT)</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Risiko Ergonomik</td>
                        <td class="border border-gray-300 px-4 py-2">Rendah</td>
                        <td class="border border-gray-300 px-4 py-2">{{ isset($sectionsData['A']) && $sectionsData['A']['response']->scores->where('section', 'Skor REBA Akhir')->first() ? $sectionsData['A']['response']->scores->where('section', 'Skor REBA Akhir')->first()->score : '-' }}</td>
                        <td class="border border-gray-300 px-4 py-2">Penilaian Keseluruhan Anggota Tubuh (REBA)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('dashboard') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center">
            <i class="fas fa-home mr-2"></i>
            Kembali ke Dashboard
        </a>
        <button onclick="window.print()" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center">
            <i class="fas fa-print mr-2"></i>
            Cetak Laporan
        </button>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none;
    }
    body {
        font-size: 12px;
    }
    .container {
        max-width: none;
        padding: 0;
    }
}
</style>
@endsection