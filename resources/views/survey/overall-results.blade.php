@extends('layouts.result')

@section('title', 'Laporan Penilaian Fit-to-Work Keseluruhan')

@section('content')

    <div id="document" class="min-h-screen bg-white p-6">
        <div class="max-w-6xl mx-auto bg-white">
            <div class="text-center justify-center">

                <div class="flex justify-center items-center space-x-4 mb-8 max-w-xl m-auto">
                    <img src="../img/logo 1.png"
                        class="h-16 sm:h-20 w-auto transform hover:scale-110 transition-transform duration-300"
                        alt="Logo 1" />
                    <img src="../img/logo 2.png"
                        class="h-16 sm:h-20 w-auto transform hover:scale-110 transition-transform duration-300"
                        alt="Logo 2" />
                    <img src="../img/logo 3.png"
                        class="h-16 sm:h-20 w-auto transform hover:scale-110 transition-transform duration-300"
                        alt="Logo 3" />
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
                @auth
                    @if (session()->has('survey_admin_verified_overall'))
                        <div class="bg-white rounded-lg border border-gray-200 my-3">
                            <div class="p-4 border-b border-gray-200">
                                <button type="button" id="toggleFormBtn"
                                    class="w-full text-left flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-800">
                                        <i class="fas fa-edit text-blue-500 mr-2"></i>
                                        Ulasan dan Ringkasan Penilai (Admin)
                                    </h3>
                                    <i id="toggleIcon"
                                        class="fas fa-chevron-down text-gray-500 transition-transform duration-200"></i>
                                </button>
                            </div>
                            <div id="formContent" class="p-4"
                                style="display: {{ $respondent->assessment_summary && $respondent->assessment_review ? 'none' : 'block' }};">
                                <form id="reviewForm" method="POST"
                                    action="{{ route('survey.save-review', $respondent->id ?? 1) }}">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="summary" class="block text-sm font-medium text-gray-700 mb-2">
                                            Ringkasan Penilaian:
                                        </label>
                                        <input type="text" id="summary" name="summary"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Masukkan ringkasan penilaian keseluruhan..."
                                            value="{{ $respondent->assessment_summary ?? '' }}">
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="review1" class="block text-sm font-medium text-gray-700 mb-2">
                                                Ulasan profil kesihatan fizikal, mental & emosi:
                                            </label>
                                            <input type="text" id="review1" name="review1"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="Ulasan untuk Kecergasan..."
                                                value="{{ json_decode($respondent->assessment_review ?? '[]', true)[0] ?? '' }}">
                                        </div>
                                        <div>
                                            <label for="review2" class="block text-sm font-medium text-gray-700 mb-2">
                                                Ulasan profil produktiviti kerja:
                                            </label>
                                            <input type="text" id="review2" name="review2"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="Ulasan untuk Keupayaan Kerja..."
                                                value="{{ json_decode($respondent->assessment_review ?? '[]', true)[1] ?? '' }}">
                                        </div>
                                        <div>
                                            <label for="review3" class="block text-sm font-medium text-gray-700 mb-2">
                                                Ulasan profil keupayaan kerja:
                                            </label>
                                            <input type="text" id="review3" name="review3"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="Ulasan untuk Risiko Psikologi..."
                                                value="{{ json_decode($respondent->assessment_review ?? '[]', true)[2] ?? '' }}">
                                        </div>
                                        <div>
                                            <label for="review4" class="block text-sm font-medium text-gray-700 mb-2">
                                                Ulasan REBA:
                                            </label>
                                            <input type="text" id="review4" name="review4"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="Ulasan untuk Kepenatan..."
                                                value="{{ json_decode($respondent->assessment_review ?? '[]', true)[3] ?? '' }}">
                                        </div>
                                        <div>
                                            <label for="review5" class="block text-sm font-medium text-gray-700 mb-2">
                                                Ulasan Penilaian Kendiri Muskuloskeletal:
                                            </label>
                                            <input type="text" id="review5" name="review5"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="Ulasan untuk Risiko Ergonomik..."
                                                value="{{ json_decode($respondent->assessment_review ?? '[]', true)[4] ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div class="text-sm text-gray-600">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            * Ringkasan dan ulasan perlu diisi sebelum mencetak laporan
                                        </div>
                                        <div class="flex space-x-2">
                                            <button type="button" id="cancelBtn" onclick="cancelData()"
                                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                                                Batal
                                            </button>
                                            <button type="button" id="saveBtn" onclick="saveData()"
                                                class="bg-blue-600 cursor-pointer hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                                                <i class="fas fa-save mr-2"></i>
                                                Simpan Ulasan
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                @endauth

            </div>

            <div class="p-6 bg-blue-50">
                <div class="flex justify-between items-center mb-4 space-x-4">
                    <div class="bg-blue-600 text-white px-3 py-1 rounded text-sm font-semibold">
                        STATUS KESELURUHAN
                    </div>
                    <div class="flex justify-between gap-10">
                        <div class="flex items-center space-x-2">
                            <span class="text-md font-bold">Nama Pemohon:</span>
                            <span class="font-semibold">[{{ $respondent->user->name ?? 'Tidak diketahui' }}]</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-md font-bold">Jawatan & Gred:</span>
                            <span class="font-semibold">[{{ $respondent->current_position ?? '' }}] [
                                {{ $respondent->grade ?? '' }}]</span>
                        </div>
                    </div>

                    <div class="bg-green-600 text-white px-3 py-1 rounded text-sm font-semibold">
                        STATUS: [✓] SELESAI
                    </div>
                </div>

                <div class="text-md text-gray-700">
                    <strong>Ringkasan:</strong>
                    @auth
                        @if (auth()->user()->role === 'admin' || session()->has('survey_admin_verified_overall'))
                            @if ($respondent->assessment_summary)
                                {!! nl2br(e($respondent->assessment_summary)) !!}
                            @else
                                <span class="text-red-500">*perlu diisi oleh penilai/penyelidik sebelum dapat dipaparkan
                                    keseluruhan laporan penilaian ini</span>
                            @endif
                        @else
                            {!! nl2br(e($respondent->assessment_summary ?? 'Tiada ringkasan tersedia')) !!}
                        @endif
                    @endauth
                </div>
            </div>

            <div class="p-6 text-sm">
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
                                    $answerI = $survey['I']->scores[2]->category;
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
                                Anggota Tubuh (REBA): {{ $survey['I']->scores[2]->score }}/15
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm">
                                {{ $survey['I']->scores[2]->recommendation }}</td>
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
                <div class="border border-gray-300 overflow-hidden">
                    <div class="bg-red-600 text-white p-2 px-3">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-heart w-5 h-5"></i>
                            <span class="font-bold">PROFIL KESIHATAN FIZIKAL, MENTAL & EMOSI</span>
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
                            @php
                                $ulasan = json_decode($respondent->assessment_review ?? '[]', true);
                            @endphp
                            <div class="text-sm">
                                <strong>Ulasan:</strong>
                                @auth
                                    @if (auth()->user()->role === 'admin' || session()->has('survey_admin_verified_overall'))
                                        @if ($ulasan && isset($ulasan[0]) && $ulasan[0])
                                            {{ $ulasan[0] }}
                                        @else
                                            <span class="text-red-500">*perlu diisi oleh penilai</span>
                                        @endif
                                    @else
                                        {{ $ulasan[0] ?? 'Tiada ulasan tersedia' }}
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 overflow-hidden">
                    <div class="bg-orange-600 text-white p-2 px-3">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-chart-line w-5 h-5"></i>
                            <span class="font-bold">PROFIL PRODUKTIVITI KERJA</span>
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

                        <div class="text-sm">
                            <strong>Ulasan:</strong>
                            @auth
                                @if (auth()->user()->role === 'admin' || session()->has('survey_admin_verified_overall'))
                                    @if ($ulasan && isset($ulasan[1]) && $ulasan[1])
                                        {{ $ulasan[1] }}
                                    @else
                                        <span class="text-red-500">*perlu diisi oleh penilai</span>
                                    @endif
                                @else
                                    {{ $ulasan[1] ?? 'Tiada ulasan tersedia' }}
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 px-6">
                <div class="border border-gray-300 overflow-hidden">
                    <div class="bg-blue-600 text-white p-2 px-3 text-center">
                        <span class="font-bold text-sm">PROFIL KEUPAYAAN KERJA</span>
                    </div>
                    <div class="p-4 space-y-2">
                        <div class="text-sm">
                            <span class="font-bold">Indeks Kebolehan Bekerja:</span> Skor [42] [Baik]
                        </div>
                        <div class="text-sm">
                            <span class="font-bold">Indeks Kecergasan JBPM:</span> Skor [3] [Tidak Berisiko]
                        </div>
                        <div class="text-sm">
                            <span class="font-bold">Ulasan:</span>
                            @auth
                                @if (auth()->user()->role === 'admin' || session()->has('survey_admin_verified_overall'))
                                    @if ($ulasan && isset($ulasan[2]) && $ulasan[2])
                                        {{ $ulasan[2] }}
                                    @else
                                        <span class="text-red-500">*perlu diisi oleh penilai</span>
                                    @endif
                                @else
                                    {{ $ulasan[2] ?? 'Tiada ulasan tersedia' }}
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 overflow-hidden">
                    <div class="bg-green-600 text-white p-2 px-3 text-center">
                        <span class="font-bold text-sm">PROFIL ERGONOMIK PEKERJAAN</span>
                    </div>
                    <div class="p-4 space-y-2">
                        <div class="text-sm">
                            <span class="font-bold">Penilaian Anggota Badan Keseluruhan (REBA):</span> Skor
                            [{{ $survey['I']->scores[2]->score }}] [{{ $survey['I']->scores[2]->category }}]
                        </div>
                        <div class="text-sm">
                            <span class="font-bold">Ulasan:</span>
                            @auth
                                @if (auth()->user()->role === 'admin' || session()->has('survey_admin_verified_overall'))
                                    @if ($ulasan && isset($ulasan[3]) && $ulasan[3])
                                        {{ $ulasan[3] }}
                                    @else
                                        <span class="text-red-500">*perlu diisi oleh penilai</span>
                                    @endif
                                @else
                                    {{ $ulasan[3] ?? 'Tiada ulasan tersedia' }}
                                @endif
                            @endauth
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
                            <span class="font-bold">Ulasan:</span>
                            @auth
                                @if (auth()->user()->role === 'admin' || session()->has('survey_admin_verified_overall'))
                                    @if ($ulasan && isset($ulasan[4]) && $ulasan[4])
                                        {{ $ulasan[4] }}
                                    @else
                                        <span class="text-red-500">*perlu diisi oleh penilai</span>
                                    @endif
                                @else
                                    {{ $ulasan[4] ?? 'Tiada ulasan tersedia' }}
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 text-left">
                    <div class="bg-gray-600 text-white p-2 px-3 text-center">
                        <span class="font-bold text-sm">UNTUK KEGUNAAN PEJABAT</span>
                    </div>
                    <div class="p-2">
                        <div class="text-sm">
                            <span class="font-bold">Cadangan/Tindakan</span>
                        </div>
                        <div class="h-35 bg-gray-100 mt-2 rounded"></div>
                        <div class="text-sm mt-2">
                            <span class="font-bold">Tarikh:</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function printDocument() {
            window.print();
        }

        function saveData() {
            var saveBtn = document.getElementById('saveBtn');
            var reviewForm = document.getElementById('reviewForm');

            var summary = document.getElementById('summary').value.trim();
            var review1 = document.getElementById('review1').value.trim();
            var review2 = document.getElementById('review2').value.trim();
            var review3 = document.getElementById('review3').value.trim();
            var review4 = document.getElementById('review4').value.trim();
            var review5 = document.getElementById('review5').value.trim();

            // Check if all fields are filled and meet minimum length
            if (!summary || summary.length < 5 ||
                !review1 || review1.length < 5 ||
                !review2 || review2.length < 5 ||
                !review3 || review3.length < 5 ||
                !review4 || review4.length < 5 ||
                !review5 || review5.length < 5) {
                alert(
                    'Sila isi Ringkasan Penilaian (minimum 5 aksara) dan semua 5 Ulasan (minimum 5 aksara setiap satu) sebelum menyimpan.'
                );
                return;
            }

            // Show loading state
            var originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
            saveBtn.disabled = true;

            // Create FormData
            var formData = new FormData();
            formData.append('summary', summary);
            formData.append('review1', review1);
            formData.append('review2', review2);
            formData.append('review3', review3);
            formData.append('review4', review4);
            formData.append('review5', review5);

            // Get CSRF token from meta tag
            var csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                formData.append('_token', csrfToken.getAttribute('content'));
            }

            // Send AJAX request
            fetch(reviewForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    // Check if response is ok
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Update toggle state to show form is completed
                        var formContent = document.getElementById('formContent');
                        var toggleIcon = document.getElementById('toggleIcon');
                        if (formContent) {
                            formContent.style.display = 'none';
                        }
                        if (toggleIcon) {
                            toggleIcon.classList.remove('fa-chevron-up');
                            toggleIcon.classList.add('fa-chevron-down');
                        }

                        var printButton = document.getElementById('printBtn');
                        if (printButton) {
                            printButton.style.display = 'inline-flex';
                        }

                        // Update the summary section
                        var summaryElement = document.querySelector('.text-sm.text-gray-700.mb-4');
                        if (summaryElement) {
                            var strongElement = summaryElement.querySelector('strong');
                            if (strongElement && strongElement.nextSibling) {
                                strongElement.nextSibling.textContent = summary;
                            }
                        }

                        // Update review sections - look for elements with "Ulasan:" text
                        var reviewElements = document.querySelectorAll('.text-sm');
                        var reviews = [review1, review2, review3, review4, review5];
                        var reviewIndex = 0;

                        reviewElements.forEach(function(el) {
                            var strongEl = el.querySelector('strong');
                            if (strongEl && strongEl.textContent.includes('Ulasan:')) {
                                var nextEl = strongEl.nextSibling;
                                if (nextEl && nextEl.nodeType === 3 && reviewIndex < reviews.length) {
                                    nextEl.textContent = ' ' + reviews[reviewIndex];
                                    reviewIndex++;
                                }
                            }
                        });

                        alert('Ulasan dan ringkasan berjaya disimpan!');
                    } else {
                        throw new Error(data.message || 'Ralat menyimpan ulasan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ralat menyimpan ulasan: ' + error.message + '. Sila cuba lagi.');
                })
                .finally(() => {
                    // Reset button state
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;
                });
        }

        function cancelData() {
            document.getElementById('summary').value = '';
            document.getElementById('review1').value = '';
            document.getElementById('review2').value = '';
            document.getElementById('review3').value = '';
            document.getElementById('review4').value = '';
            document.getElementById('review5').value = '';
        }

        // Add event listener when page loads
        document.addEventListener('DOMContentLoaded', function() {
            var printBtn = document.getElementById('printBtn');
            var cancelBtn = document.getElementById('cancelBtn');
            var toggleFormBtn = document.getElementById('toggleFormBtn');
            var formContent = document.getElementById('formContent');
            var toggleIcon = document.getElementById('toggleIcon');

            if (printBtn) {
                printBtn.addEventListener('click', printDocument);
            }

            if (cancelBtn) {
                cancelBtn.addEventListener('click', cancelData);
            }

            // Toggle form visibility
            if (toggleFormBtn && formContent && toggleIcon) {
                toggleFormBtn.addEventListener('click', function() {
                    if (formContent.style.display === 'none') {
                        formContent.style.display = 'block';
                        toggleIcon.classList.remove('fa-chevron-down');
                        toggleIcon.classList.add('fa-chevron-up');
                    } else {
                        formContent.style.display = 'none';
                        toggleIcon.classList.remove('fa-chevron-up');
                        toggleIcon.classList.add('fa-chevron-down');
                    }
                });
            }
        });
    </script>
@endpush
