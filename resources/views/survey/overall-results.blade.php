@extends('layouts.result')

@section('title', 'Laporan Penilaian Fit-to-Work Keseluruhan')

@section('content')

    <div id="document" class="min-h-screen bg-white p-6">
        <div class="max-w-6xl mx-auto bg-white">
            <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center">
                            <span class="text-red-600 font-bold text-lg">UPM</span>
                        </div>
                        <div>
                            <h1 class="text-sm font-semibold">INSTITUT PENYELIDIKAN</h1>
                            <h2 class="text-sm font-semibold">JASMANI & PSIKOLOGI</h2>
                            <p class="text-xs opacity-90">Universiti Putra Malaysia</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-line w-6 h-6 text-white"></i>
                        </div>
                        <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user w-6 h-6 text-white"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-xs opacity-90">CONTOH</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-blue-900 text-white p-4 text-center">
                <h3 class="text-lg font-bold">LAPORAN PENILAIAN FIT-TO-WORK</h3>
                <p class="text-sm">Jabatan Bomba & Penyelamat Malaysia (JBPM)</p>
            </div>

            <div class="p-4 bg-gray-50 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <a href="{{ route('dashboard') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                    </a>
                    <button id="printBtn"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors flex items-center cursor-pointer">
                        <i class="fas fa-print mr-2"></i> Print
                    </button>
                </div>
            </div>

            <div class="p-6 bg-blue-50">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-blue-600 text-white px-3 py-1 rounded text-sm font-semibold">
                        STATUS KESELURUHAN
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm">Nama Pemohon:</span>
                        <span class="font-semibold">{{ $respondent->user->name ?? 'Tidak diketahui' }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm">Jawatan & Gred:</span>
                        <span class="font-semibold">{{ $respondent->current_position ?? '' }}
                            {{ $respondent->grade ?? '' }}</span>
                    </div>
                    <div class="bg-green-600 text-white px-3 py-1 rounded text-sm font-semibold">
                        STATUS: {{ $overallStatus === 'LENGKAP' ? '[✓] SELESAI' : '[!] BELUM LENGKAP' . $overallStatus }}
                    </div>
                </div>
                <div class="text-sm text-gray-700 mb-4">
                    <strong>Ringkasan:</strong> *perlu diisi oleh penilai/penyelidik sebelum dapat dipaparkan keseluruhan
                    laporan penilaian ini
                </div>
            </div>

            <div class="p-6">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="border border-gray-300 px-4 py-2 text-left">KATEGORI</th>
                            <th class="border border-gray-300 px-4 py-2 text-center w-50">STATUS</th>
                            <th class="border border-gray-300 px-4 py-2 text-center w-50">SKOR</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">BUTIRAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-heart w-4 h-4 text-red-500"></i>
                                    <span>Kecergasan</span>
                                </div>
                            </td>

                            <td class="border border-gray-300 px-4 py-2 text-left">
                                @php
                                    $answerL = $survey['L']->answers[0]->answer;
                                    if (
                                        strtoupper($answerL) == 'CEMERLANG' ||
                                        strtoupper($answerL) == 'BAIK' ||
                                        strtoupper($answerL) == 'LULUS'
                                    ) {
                                        $color1 = 'green';
                                    } elseif (strtoupper($answerL) == 'GAGAL') {
                                        $color1 = 'red';
                                    } else {
                                        $color1 = 'gray';
                                    }

                                @endphp
                                <i class="fas fa-circle w-5 h-5 text-{{ $color1 }}-500"></i>
                                <span class="ml-1 text-sm">
                                    <?= $answerL ?></span>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center font-semibold">
                                {{ isset($sectionsData['A']) ? $sectionsData['A']['response']->scores->where('section', 'A')->first()->score ?? 'N/A' : 'N/A' }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm">Ujian UKTK (untuk Pegawai Gred KB1 - KB4
                                Tahun 2025)</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-chart-line w-4 h-4 text-blue-500"></i>
                                    <span>Keupayaan Kerja</span>
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-left">
                                @php
                                    $answerB = $survey['B']->scores[0]->category;
                                    if (strtoupper($answerB) == 'LEMAH') {
                                        $color2 = 'red';
                                    } elseif (strtoupper($answerB) == 'SEDERHANA') {
                                        $color2 = 'orange';
                                    } elseif (strtoupper($answerB) == 'BAIK' || strtoupper($answerB) == 'CEMERLANG') {
                                        $color2 = 'green';
                                    } else {
                                        $color2 = 'gray';
                                    }

                                @endphp
                                <i class="fas fa-circle w-5 h-5 text-{{ $color2 }}-500"></i>
                                <span class="ml-1 text-sm">
                                    <?= $answerB ?></span>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center font-semibold">
                                Indek Kebolehan Bekerja
                                (WAI): {{ $survey['B']->scores[0]->score }}/49
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm">
                                {{ $survey['B']->scores[0]->recommendation }}</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-brain w-4 h-4 text-purple-500"></i>
                                    <span>Risiko Psikologi</span>
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-left">
                                @php
                                    $answerG = $survey['G']->scores[0]->category;
                                    if (strtoupper($answerG) == 'TIDAK MENGALAMI SEBARANG SIMPTOM KEMURUNGAN') {
                                        $labelG = 'Tiada Simpton';
                                        $color3 = 'green';
                                    } elseif (
                                        strtoupper($answerG) == 'MENGALAMI SIMPTOM KEMURUNGAN YANG RINGAN/SEDERHANA'
                                    ) {
                                        $labelG = 'Ringan/Sederhana';
                                        $color3 = 'orange';
                                    } elseif (strtoupper($answerG) == 'MENGALAMI SIMPTOM KEMURUNGAN YANG TINGGI') {
                                        $labelG = 'Tinggi';
                                        $color3 = 'red';
                                    } else {
                                        $labelG = '-';
                                        $color3 = 'gray';
                                    }

                                @endphp
                                <i class="fas fa-circle w-5 h-5 text-{{ $color3 }}-500"></i>
                                <span class="ml-1 text-sm">
                                    <?= $labelG ?></span>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center font-semibold">
                                Skala Kemurungan CES-D:
                                {{ $survey['G']->scores[0]->score }}/60
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm">
                                {{ $survey['G']->scores[0]->recommendation }}
                            </td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-user w-4 h-4 text-gray-500"></i>
                                    <span>Kepenatan</span>
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-left">
                                @php
                                    $answerH = $survey['H']->scores[4]->category;
                                    if (strtoupper($answerH) == 'RENDAH') {
                                        $color4 = 'green';
                                    } elseif (strtoupper($answerH) == 'SEDERHANA') {
                                        $color4 = 'orange';
                                    } elseif (
                                        strtoupper($answerH) == 'TINGGI' ||
                                        strtoupper($answerH) == 'SANGAT TINGGI'
                                    ) {
                                        $color4 = 'red';
                                    } else {
                                        $color4 = 'gray';
                                    }

                                @endphp
                                <i class="fas fa-circle w-5 h-5 text-{{ $color4 }}-500"></i>
                                <span class="ml-1 text-sm">
                                    <?= $answerH ?></span>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center font-semibold">
                                Instrumen Penilaian Kepenatan
                                (BAT): {{ $survey['H']->scores[4]->score }}/5.00
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm">
                                {{ $survey['H']->scores[4]->recommendation }}</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-chart-line w-4 h-4 text-orange-500"></i>
                                    <span>Risiko Ergonomik</span>
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-left">
                                @php
                                    $answerI = $survey['I']->scores[0]->category;
                                    if (
                                        strtoupper($answerI) == 'TIADA RISIKO' ||
                                        strtoupper($answerI) == 'RISIKO RENDAH, PERUBAHAN MUNGKIN DIPERLUKAN'
                                    ) {
                                        $color5 = 'green';
                                    } elseif (
                                        strtoupper($answerI) ==
                                        'RISIKO SEDERHANA, SIASATAN LANJUT, PERUBAHAN PERLU DIBUAT DALAM MASA TERDEKAT'
                                    ) {
                                        $color5 = 'orange';
                                    } elseif (
                                        strtoupper($answerI) == 'RISIKO TINGGI, SIASAT DAN LAKSANAKAN PERUBAHAN' ||
                                        strtoupper($answerI) == 'RISIKO SANGAT TINGGI, LAKSANAKAN PERUBAHAN SEGERA'
                                    ) {
                                        $color5 = 'red';
                                    } else {
                                        $labelI = '-';
                                        $color5 = 'gray';
                                    }

                                @endphp
                                <i class="fas fa-circle w-5 h-5 text-{{ $color5 }}-500"></i>
                                <span class="ml-1 text-sm">
                                    <?= $answerI ?></span>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center font-semibold">
                                Penilaian Keseluruhan
                                Anggota Tubuh (REBA): {{ $survey['I']->scores[0]->score }}/15
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm">
                                {{ $survey['I']->scores[0]->recommendation }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-6 bg-blue-50 text-sm">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="border border-gray-300 px-4 py-2 text-left">RISIKO</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">TINDAKAN</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">TANGGUNGJAWAB</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">TEMPOH TARIKH SEMAK</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            function tindakan($risiko)
                            {
                                if ($risiko == 1) {
                                    return 'Ulang ujian berkaitan sehingga lulus';
                                } elseif ($risiko == 2) {
                                    return 'Intervensi kesihatan fizikal/mental/kerja';
                                }
                                return '-';
                            }
                            function tanggungjawab($risiko)
                            {
                                if ($risiko == 1) {
                                    return 'Kaunselor';
                                } elseif ($risiko == 2) {
                                    return 'Penyelia';
                                }
                                return '-';
                            }
                        @endphp
                        @if (strtoupper($answerL) == 'GAGAL')
                            @php
                                if (strtoupper($answerL) == 'GAGAL') {
                                    $risiko = 0;
                                }
                            @endphp
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">Kecergasan</td>
                                <td class="border border-gray-300 px-4 py-2">{{ tindakan(0) }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">{{ tindakan(0) }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">6 atau 12 bulan dari tarikh
                                    tindakan diambil</td>
                            </tr>
                        @endif
                        @if (strtoupper($answerB) == 'LEMAH' || strtoupper($answerB) == 'SEDERHANA')
                            @php
                                if (strtoupper($answerB) == 'LEMAH') {
                                    $risiko = 0;
                                } else {
                                    $risiko = 1;
                                }
                            @endphp
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">Keupayaan Kerja</td>
                                <td class="border border-gray-300 px-4 py-2">{{ tindakan($risiko) }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">{{ tindakan($risiko) }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">6 atau 12 bulan dari tarikh
                                    tindakan diambil</td>
                            </tr>
                        @endif
                        @if (strtoupper($answerG) == 'MENGALAMI SIMPTOM KEMURUNGAN YANG RINGAN/SEDERHANA' ||
                                strtoupper($answerG) == 'MENGALAMI SIMPTOM KEMURUNGAN YANG TINGGI')
                            @php
                                if (strtoupper($answerG) == 'MENGALAMI SIMPTOM KEMURUNGAN YANG RINGAN/SEDERHANA') {
                                    $risiko = 0;
                                } else {
                                    $risiko = 1;
                                }
                            @endphp
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">Risiko Psikologi</td>
                                <td class="border border-gray-300 px-4 py-2">{{ tindakan($risiko) }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">{{ tindakan($risiko) }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">6 atau 12 bulan dari tarikh
                                    tindakan diambil</td>
                            </tr>
                        @endif
                        @if (strtoupper($answerH) == 'SEDERHANA' || strtoupper($answerH) == 'TINGGI' || strtoupper($answerH) == 'SANGAT TINGGI')
                            @php
                                if (strtoupper($answerH) == 'SEDERHANA') {
                                    $risiko = 0;
                                } else {
                                    $risiko = 1;
                                }
                            @endphp
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">Kepenatan</td>
                                <td class="border border-gray-300 px-4 py-2">{{ tindakan($risiko) }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">{{ tindakan($risiko) }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">6 atau 12 bulan dari tarikh
                                    tindakan diambil</td>
                            </tr>
                        @endif
                        @if (strtoupper($answerI) == 'RISIKO SEDERHANA, SIASATAN LANJUT, PERUBAHAN PERLU DIBUAT DALAM MASA TERDEKAT' ||
                                strtoupper($answerI) == 'RISIKO TINGGI, SIASAT DAN LAKSANAKAN PERUBAHAN' ||
                                strtoupper($answerI) == 'RISIKO SANGAT TINGGI, LAKSANAKAN PERUBAHAN SEGERA')
                            @php
                                if (
                                    strtoupper($answerI) ==
                                    'RISIKO SEDERHANA, SIASATAN LANJUT, PERUBAHAN PERLU DIBUAT DALAM MASA TERDEKAT'
                                ) {
                                    $risiko = 0;
                                } else {
                                    $risiko = 1;
                                }
                            @endphp
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">Risiko Ergonomik</td>
                                <td class="border border-gray-300 px-4 py-2">{{ tindakan($risiko) }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">{{ tindakan($risiko) }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">6 atau 12 bulan dari tarikh
                                    tindakan diambil</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6">
                <div class="border border-gray-300 rounded-lg overflow-hidden">
                    <div class="bg-red-600 text-white p-3">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-heart w-5 h-5"></i>
                            <span class="font-semibold">PROFIL KESIHATAN FIZIKAL, MENTAL & EMOSI</span>
                        </div>
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="text-sm">
                            <span class="font-bold">Umur:</span>
                            [{{ $respondent->age ? $respondent->age . ' Tahun' : 'Tidak diketahui' }}]
                        </div>
                        <div class="text-sm">
                            <span class="font-bold">BMI:</span> {{ $respondent->bmi ?? 'N/A' }}
                            [{{ $respondent->health ?? 'Tidak diketahui' }}]
                        </div>
                        <div class="text-sm">
                            <span class="font-bold">Tahap Kesihatan:</span>
                            @if ($respondent->health_issues)
                                <ul class="list-disc list-inside">
                                    @foreach (json_decode($respondent->health_issues, true) as $issue)
                                        <li>{{ $issue }}</li>
                                    @endforeach
                                </ul>
                            @elseif ($respondent->other_health_issue)
                                {{ $respondent->other_health_issue }}
                            @else
                                Baik
                            @endif
                        </div>
                        <div class="space-y-2">
                            <div class="text-sm"><strong>Skala Kesiler 6 (Tekanan Psikologi):</strong> Skor
                                [{{ $survey['F']->scores[0]->score }}] [{{ $survey['F']->scores[0]->category }}]
                            </div>
                            <div class="text-sm"><strong>Skala Simptom Kemrunangan (CES-D):</strong> Skor
                                [{{ $survey['G']->scores[0]->score }}] [{{ $survey['G']->scores[0]->category }}]</div>
                            <div class="text-sm"><strong>Skala Penilaian Kepenatan:</strong> Skor
                                [{{ $survey['H']->scores[4]->score }}] [{{ $survey['H']->scores[4]->category }}]
                            </div>
                            <div class="text-sm"><strong>Ulasan:</strong> -</div>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 rounded-lg overflow-hidden">
                    <div class="bg-orange-600 text-white p-3">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-chart-line w-5 h-5"></i>
                            <span class="font-semibold">PROFIL PRODUKTIVITI KERJA</span>
                        </div>
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="text-sm">
                            <span class="font-bold">Prestasi Kerja Keseluruhan Individu:</span> Skor
                            [{{ $survey['E']->scores[3]->score }}] [{{ $survey['E']->scores[3]->category }}]
                            <ul class="list-disc list-inside ml-4">
                                <li><span class="font-semibold">Prestasi Tugas :</span> Skor
                                    [{{ $survey['E']->scores[0]->score }}] [{{ $survey['E']->scores[0]->category }}]</li>
                                <li><span class="font-semibold">Prestasi Konteksual :</span> Skor
                                    [{{ $survey['E']->scores[1]->score }}] [{{ $survey['E']->scores[1]->category }}]</li>
                                <li><span class="font-semibold">Perilaku Kerja Produktif :</span> Skor
                                    [{{ $survey['E']->scores[2]->score }}] [{{ $survey['E']->scores[2]->category }}]</li>
                            </ul>
                        </div>
                        <div class="text-sm">
                            <span class="font-bold">Impak Latihan Di Tempat Kerja:</span> Skor
                            [{{ $survey['D']->scores[0]->score }}] [{{ $survey['D']->scores[0]->category }}]
                            <ul class="list-disc list-inside ml-4">
                                <li><span class="font-semibold">Prestasi Kerja :</span> Skor
                                    [{{ $survey['D']->scores[1]->score }}] [{{ $survey['D']->scores[1]->category }}]</li>
                                <li><span class="font-semibold">Sikap :</span> Skor
                                    [{{ $survey['D']->scores[2]->score }}] [{{ $survey['D']->scores[2]->category }}]</li>
                            </ul>
                        </div>
                        <div class="text-sm">
                            <span class="font-bold">Penilaian Kandungan Kerja:</span>
                            [{{ $sectionCStatus['status'] ?? 'Pekerjaan Aktif' }}]
                            <ul class="list-disc list-inside ml-4">
                                <li><span class="font-semibold">Tuntutan Psikologi :</span> Skor
                                    [{{ $survey['C']->scores[0]->score }}]
                                    @if (isset($medianScores['Tuntutan Psikologi']))
                                        @if ($survey['C']->scores[0]->score > $medianScores['Tuntutan Psikologi'])
                                            [Di atas median]
                                        @elseif($survey['C']->scores[0]->score < $medianScores['Tuntutan Psikologi'])
                                            [Di bawah median]
                                        @else
                                            [Sama dengan median]
                                        @endif
                                    @else
                                        [{{ $survey['C']->scores[0]->category }}]
                                    @endif
                                </li>
                                <li><span class="font-semibold">Kawalan Keputusan :</span> Skor
                                    [{{ $survey['C']->scores[1]->score }}]
                                    @if (isset($medianScores['Kawalan Keputusan']))
                                        @if ($survey['C']->scores[1]->score > $medianScores['Kawalan Keputusan'])
                                            [Di atas median]
                                        @elseif($survey['C']->scores[1]->score < $medianScores['Kawalan Keputusan'])
                                            [Di bawah median]
                                        @else
                                            [Sama dengan median]
                                        @endif
                                    @else
                                        [{{ $survey['C']->scores[1]->category }}]
                                    @endif
                                </li>
                                <li><span class="font-semibold">Sokongan Sosial :</span> Skor
                                    [{{ $survey['C']->scores[2]->score }}]
                                    @if (isset($medianScores['Sokongan Sosial']))
                                        @if ($survey['C']->scores[2]->score > $medianScores['Sokongan Sosial'])
                                            [Di atas median]
                                        @elseif($survey['C']->scores[2]->score < $medianScores['Sokongan Sosial'])
                                            [Di bawah median]
                                        @else
                                            [Sama dengan median]
                                        @endif
                                    @else
                                        [{{ $survey['C']->scores[2]->category }}]
                                    @endif
                                </li>
                            </ul>
                        </div>

                        <div class="text-sm"><strong>Ulasan : </strong> -</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
                <div class="border border-gray-300 rounded-lg overflow-hidden">
                    <div class="bg-blue-600 text-white p-3 text-center">
                        <span class="font-semibold text-sm">PROFIL KEUPAYAAN KERJA</span>
                    </div>
                    <div class="p-4 space-y-2">
                        <div class="text-sm">
                            <span class="font-bold">Indeks Kebolehan Bekerja:</span> Skor [42] [Baik]
                        </div>
                        <div class="text-sm">
                            <span class="font-bold">Indeks Kecergasan JBPM:</span> Skor [3] [Tidak Berisiko]
                        </div>
                        <div class="text-sm">
                            <span class="font-bold">Ulasan:</span> -
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 rounded-lg overflow-hidden">
                    <div class="bg-green-600 text-white p-3 text-center">
                        <span class="font-semibold text-sm">PROFIL ERGONOMIK PEKERJAAN</span>
                    </div>
                    <div class="p-4 space-y-2">
                        <div class="text-sm">
                            <span class="font-bold">Penilaian Anggota Badan Keseluruhan (REBA):</span> Skor
                            [{{ $survey['I']->scores[2]->score }}] [{{ $survey['I']->scores[2]->category }}]
                        </div>
                        <div class="text-sm">
                            <span class="font-bold">Ulasan:</span> -
                        </div>
                        <div class="text-sm">
                            <span class="font-bold">Penilaian Kendiri Muskuloskeletal:</span>
                            @php
                                $sectionJData = $survey['J'] ?? null;
                                $problematicParts = [];
                                if ($sectionJData && isset($sectionJData->answers)) {
                                    foreach ($sectionJData->answers as $answer) {
                                        if (in_array($answer->question_id, ['J1', 'J2', 'J3', 'J4'])) {
                                            $answerData = json_decode($answer->answer, true);
                                            if (is_array($answerData)) {
                                                $problematicParts = array_merge($problematicParts, $answerData);
                                            }
                                        }
                                    }
                                    $problematicParts = array_unique($problematicParts);
                                }
                                $partsText = !empty($problematicParts)
                                    ? '[Masalah pada ' . strtolower(implode(', ', $problematicParts)) . ']'
                                    : '[Tiada masalah dilaporkan]';
                            @endphp
                            {!! $partsText !!}
                        </div>
                        <div class="text-sm">
                            <span class="font-bold">Ulasan:</span>-
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 rounded-lg">
                    <div class="bg-gray-200 h-32 flex items-center justify-center">
                        <i class="fas fa-map-marker w-8 h-8 text-gray-400"></i>
                    </div>
                    <div class="p-2">
                        <div class="text-xs text-center">
                            <span class="font-semibold">Cadangan/Tindakan</span>
                        </div>
                        <div class="h-16 bg-gray-100 mt-2 rounded"></div>
                        <div class="text-xs text-center mt-2">
                            <span class="font-semibold">Tarikh:</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-100 p-4 text-center text-sm text-gray-600">
                <p>Institut Penyelidikan Jasmani & Psikologi • Universiti Putra Malaysia</p>
                <p>Laporan ini adalah sulit dan tidak boleh disebarkan tanpa kebenaran bertulis</p>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function printDocument() {
            window.print();
        }

        // Add event listener when page loads
        document.addEventListener('DOMContentLoaded', function() {
            var printBtn = document.getElementById('printBtn');
            if (printBtn) {
                printBtn.addEventListener('click', printDocument);
                console.log('Print button event listener added');
            } else {
                console.error('Print button not found');
            }
        });
    </script>
@endsection
