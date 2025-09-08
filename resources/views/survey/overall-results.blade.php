@extends('layouts.result')

@section('title', 'Laporan Penilaian Fit-to-Work Keseluruhan')

@section('content')

    <div class="min-h-screen bg-gray-100 p-6">
        <div class="max-w-6xl mx-auto bg-white shadow-lg">
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

            <div class="p-6 bg-blue-50">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-blue-600 text-white px-3 py-1 rounded text-sm font-semibold">
                        STATUS KESELURUHAN
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm">Nama Pemohon:</span>
                        <span class="font-semibold">Ahmad bin Ali</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm">Jawatan & Gred:</span>
                        <span class="font-semibold">[Pb43] [KB12]</span>
                    </div>
                    <div class="bg-green-600 text-white px-3 py-1 rounded text-sm font-semibold">
                        STATUS: [✓] FIT-TO-WORK
                    </div>
                </div>
                <div class="text-sm text-gray-700 mb-4">
                    <strong>Ringkasan:</strong> Hasil penilaian menunjukkan keupayaan dan produktiviti kerja yang sangat
                    baik, namun terdapat aspek
                    sederhana dalam kesihatan fizikal, mental, dan emosi yang perlu diberi perhatian. Isu ergonomik ringan
                    telah
                    dikenalpasti.
                </div>
            </div>

            <div class="p-6">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="border border-gray-300 px-4 py-2 text-left">KATEGORI</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">STATUS</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">SKOR</th>
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
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-check-circle w-5 h-5 text-green-500"></i>
                                    <span class="ml-1 text-sm">Baik</span>
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center font-semibold">85</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm">Status fizikal, mental dan emosi pada
                                tahap sederhana.</td>
                        </tr>
                        <tr class="bg-gray-100-50">
                            <td class="border border-gray-300 px-4 py-2">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-chart-line w-4 h-4 text-blue-500"></i>
                                    <span>Keupayaan Kerja</span>
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-check-circle w-5 h-5 text-green-500"></i>
                                    <span class="ml-1 text-sm">Baik</span>
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center font-semibold">78</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm">Keupayaan kerja yang baik</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-brain w-4 h-4 text-purple-500"></i>
                                    <span>Risiko Psikologi</span>
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle w-5 h-5 text-yellow-500"></i>
                                    <span class="ml-1 text-sm">Sederhana</span>
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center font-semibold">16/60</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm">Gejala ringan/ sederhana dikesan, perlu
                                diberi perhatian</td>
                        </tr>
                        <tr class="bg-gray-100-50">
                            <td class="border border-gray-300 px-4 py-2">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-user w-4 h-4 text-gray-500"></i>
                                    <span>Kepenatam</span>
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-times-circle w-5 h-5 text-red-500"></i>
                                    <span class="ml-1 text-sm">Tinggi</span>
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center font-semibold">65/100</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm">Mengalami risiko kependatan, perlu
                                perhatian segera</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-chart-line w-4 h-4 text-orange-500"></i>
                                    <span>Risiko Ergonomik</span>
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle w-5 h-5 text-yellow-500"></i>
                                    <span class="ml-1 text-sm">Rendah</span>
                                </div>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center font-semibold">3/15</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm">Postur berisiko rendah, namun terdapat
                                masalah kecil VSD</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-6 bg-blue-50">
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
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">Risiko Psikologi</td>
                            <td class="border border-gray-300 px-4 py-2">Khidmat nasihat kaunseling berkesinambungan
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">Kaunselor</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">2 Minggu/ 2 Minggu selepas</td>
                        </tr>
                        <tr class="bg-gray-100-50">
                            <td class="border border-gray-300 px-4 py-2">Kepenatan</td>
                            <td class="border border-gray-300 px-4 py-2">Sesi kaunseling pengurusan kaunseling</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">HR/Penyelja</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">2 Minggu/ 2 Minggu selepas</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">Risiko Ergonomik</td>
                            <td class="border border-gray-300 px-4 py-2">Latihan ergonomik/ teknik postur yang betul
                                semasa bekerja</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">Penyelja</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">1 Minggu/ 4 Minggu selepas</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-6 bg-yellow-50">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-calendar w-5 h-5 text-blue-600"></i>
                    <span class="font-semibold">Tarikh Penilaian Seterusnya Dijadualkan: [1 Disember 2025]</span>
                </div>
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
                            <span class="font-semibold">BMI:</span> Tahap Sihat: [24.7] [Berat badan berlebihan]
                        </div>
                        <div class="text-sm">
                            <span class="font-semibold">BMI:</span> [26.1] [Berat badan berlebihan]
                        </div>
                        <div class="text-sm">
                            <span class="font-semibold">Tahap Pernafasan:</span> Baik
                        </div>
                        <div class="space-y-2">
                            <div class="text-sm"><strong>Skala Kesiler 6 (Tekanan Psikologi):</strong> Skor [8] [Tidak
                                mengalami tekanan psikologi]</div>
                            <div class="text-sm"><strong>Skala Simptom Kemrunangan (CES-D):</strong> Skor [10]
                                [Mengalami kemrunangan]</div>
                            <div class="text-sm"><strong>Skala Penilaian Kepenatan:</strong> Skor [3.10] [Tinggi]</div>
                            <div class="text-sm"><strong>Ulasan:</strong> [Sangat tinggi tahap] sekerangapa pada tahap
                                yang sederhana]</div>
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
                            <span class="font-semibold">Prestasi Kerja Keseluruhan Individu:</span> Skor [8.33]
                            [Tinggi]
                        </div>
                        <div class="text-sm">
                            <span class="font-semibold">Prestasi Kontekstual:</span> Skor [8.10] [Sederhana]
                        </div>
                        <div class="text-sm">
                            <span class="font-semibold">Prilaku Kerja Produktif:</span> Skor [3.49] [Tinggi]
                        </div>
                        <div class="text-sm">
                            <span class="font-semibold">Impak Kesihatan Ke Atas Tempat Kerja:</span> Skor [55] [Sangat
                            Berkesan]
                        </div>
                        <div class="text-sm">
                            <span class="font-semibold">Skala Kerja:</span> Skor [51] [Berkesam]
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
                <div class="border border-gray-300 rounded-lg overflow-hidden">
                    <div class="bg-blue-600 text-white p-3 text-center">
                        <span class="font-semibold text-sm">PROFIL ERGONOMIK KERJA</span>
                    </div>
                    <div class="p-4 space-y-2">
                        <div class="text-xs">
                            <span class="font-semibold">Indeks Kebolehan Kerja:</span> Skor [42] [Baik]
                        </div>
                        <div class="text-xs">
                            <span class="font-semibold">Indeks Risiko Ergonomik:</span> Skor [3] [Tidak Berisiko]
                        </div>
                        <div class="text-xs">
                            <span class="font-semibold">Ulasan:</span> [Mempunyai keupayaan kerja yang baik dari segi
                            penilaian kerja fizikal dan mental]
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 rounded-lg overflow-hidden">
                    <div class="bg-green-600 text-white p-3 text-center">
                        <span class="font-semibold text-sm">PROFIL KESIHATAN (SEROLOGI)</span>
                    </div>
                    <div class="p-4 space-y-2">
                        <div class="text-xs">
                            <span class="font-semibold">Penilaian Anggota Badan Keseluruhan (REBA):</span> Skor [4]
                            [Sederhana]
                        </div>
                        <div class="text-xs">
                            <span class="font-semibold">Ulasan:</span> [Risiko rendah, perubahan mungkin diperlukan]
                        </div>
                        <div class="text-xs">
                            <span class="font-semibold">Penilaian Kendiri Muskuloskeletal:</span>
                        </div>
                        <div class="text-xs">
                            <span class="font-semibold">Ulasan:</span> [Postur berada dalam keadaan risiko MSD,
                            tambahbaik berisiko MSD]
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 rounded-lg">
                    <div class="bg-gray-100-200 h-32 flex items-center justify-center">
                        <i class="fas fa-map-marker w-8 h-8 text-gray-400"></i>
                    </div>
                    <div class="p-2">
                        <div class="text-xs text-center">
                            <span class="font-semibold">Cadangan/Tindakan</span>
                        </div>
                        <div class="h-16 bg-gray-100-100 mt-2 rounded"></div>
                        <div class="text-xs text-center mt-2">
                            <span class="font-semibold">Tarikh:</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-100-100 p-4 text-center text-sm text-gray-600">
                <p>Institut Penyelidikan Jasmani & Psikologi • Universiti Putra Malaysia</p>
                <p>Laporan ini adalah sulit dan tidak boleh disebarkan tanpa kebenaran bertulis</p>
            </div>
        </div>
    </div>

@endsection
