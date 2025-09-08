@extends('layouts.result')

@section('title', 'Laporan Penilaian Fit-to-Work Keseluruhan')

@section('content')

    <div className="min-h-screen bg-gray p-6">
        <div className="max-w-6xl mx-auto bg-white shadow-lg">
            <div className="bg-gradient-to-r from-red-600 to-red-700 text-white p-6">
                <div className="flex items-center justify-between">
                    <div className="flex items-center space-x-4">
                        <div className="w-16 h-16 bg-white rounded-lg flex items-center justify-center">
                            <span className="text-red-600 font-bold text-lg">UPM</span>
                        </div>
                        <div>
                            <h1 className="text-sm font-semibold">INSTITUT PENYELIDIKAN</h1>
                            <h2 className="text-sm font-semibold">JASMANI & PSIKOLOGI</h2>
                            <p className="text-xs opacity-90">Universiti Putra Malaysia</p>
                        </div>
                    </div>
                    <div className="flex items-center space-x-4">
                        <div className="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                            <Activity className="w-6 h-6 text-white" />
                        </div>
                        <div className="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                            <User className="w-6 h-6 text-white" />
                        </div>
                        <div className="text-right">
                            <p className="text-xs opacity-90">CONTOH</p>
                        </div>
                    </div>
                </div>
            </div>

            <div className="bg-blue-900 text-white p-4 text-center">
                <h3 className="text-lg font-bold">LAPORAN PENILAIAN FIT-TO-WORK</h3>
                <p className="text-sm">Jabatan Bomba & Penyelamat Malaysia (JBPM)</p>
            </div>

            <div className="p-6 bg-blue-50">
                <div className="flex items-center space-x-4 mb-4">
                    <div className="bg-blue-600 text-white px-3 py-1 rounded text-sm font-semibold">
                        STATUS KESELURUHAN
                    </div>
                    <div className="flex items-center space-x-2">
                        <span className="text-sm">Nama Pemohon:</span>
                        <span className="font-semibold">Ahmad bin Ali</span>
                    </div>
                    <div className="flex items-center space-x-2">
                        <span className="text-sm">Jawatan & Gred:</span>
                        <span className="font-semibold">[Pb43] [KB12]</span>
                    </div>
                    <div className="bg-green-600 text-white px-3 py-1 rounded text-sm font-semibold">
                        STATUS: [✓] FIT-TO-WORK
                    </div>
                </div>
                <div className="text-sm text-gray-700 mb-4">
                    <strong>Ringkasan:</strong> Hasil penilaian menunjukkan keupayaan dan produktiviti kerja yang sangat
                    baik, namun terdapat aspek
                    sederhana dalam kesihatan fizikal, mental, dan emosi yang perlu diberi perhatian. Isu ergonomik ringan
                    telah
                    dikenalpasti.
                </div>
            </div>

            <div className="p-6">
                <table className="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr className="bg-blue-600 text-white">
                            <th className="border border-gray-300 px-4 py-2 text-left">KATEGORI</th>
                            <th className="border border-gray-300 px-4 py-2 text-center">STATUS</th>
                            <th className="border border-gray-300 px-4 py-2 text-center">SKOR</th>
                            <th className="border border-gray-300 px-4 py-2 text-left">BUTIRAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td className="border border-gray-300 px-4 py-2">
                                <div className="flex items-center space-x-2">
                                    <Heart className="w-4 h-4 text-red-500" />
                                    <span>Kecergasan</span>
                                </div>
                            </td>
                            <td className="border border-gray-300 px-4 py-2 text-center">
                                <div className="flex items-center justify-center">
                                    <CheckCircle className="w-5 h-5 text-green-500" />
                                    <span className="ml-1 text-sm">Baik</span>
                                </div>
                            </td>
                            <td className="border border-gray-300 px-4 py-2 text-center font-semibold">85</td>
                            <td className="border border-gray-300 px-4 py-2 text-sm">Status fizikal, mental dan emosi pada
                                tahap sederhana.</td>
                        </tr>
                        <tr className="bg-gray-50">
                            <td className="border border-gray-300 px-4 py-2">
                                <div className="flex items-center space-x-2">
                                    <TrendingUp className="w-4 h-4 text-blue-500" />
                                    <span>Keupayaan Kerja</span>
                                </div>
                            </td>
                            <td className="border border-gray-300 px-4 py-2 text-center">
                                <div className="flex items-center justify-center">
                                    <CheckCircle className="w-5 h-5 text-green-500" />
                                    <span className="ml-1 text-sm">Baik</span>
                                </div>
                            </td>
                            <td className="border border-gray-300 px-4 py-2 text-center font-semibold">78</td>
                            <td className="border border-gray-300 px-4 py-2 text-sm">Keupayaan kerja yang baik</td>
                        </tr>
                        <tr>
                            <td className="border border-gray-300 px-4 py-2">
                                <div className="flex items-center space-x-2">
                                    <Brain className="w-4 h-4 text-purple-500" />
                                    <span>Risiko Psikologi</span>
                                </div>
                            </td>
                            <td className="border border-gray-300 px-4 py-2 text-center">
                                <div className="flex items-center justify-center">
                                    <AlertTriangle className="w-5 h-5 text-yellow-500" />
                                    <span className="ml-1 text-sm">Sederhana</span>
                                </div>
                            </td>
                            <td className="border border-gray-300 px-4 py-2 text-center font-semibold">16/60</td>
                            <td className="border border-gray-300 px-4 py-2 text-sm">Gejala ringan/ sederhana dikesan, perlu
                                diberi perhatian</td>
                        </tr>
                        <tr className="bg-gray-50">
                            <td className="border border-gray-300 px-4 py-2">
                                <div className="flex items-center space-x-2">
                                    <User className="w-4 h-4 text-gray-500" />
                                    <span>Kepenatam</span>
                                </div>
                            </td>
                            <td className="border border-gray-300 px-4 py-2 text-center">
                                <div className="flex items-center justify-center">
                                    <XCircle className="w-5 h-5 text-red-500" />
                                    <span className="ml-1 text-sm">Tinggi</span>
                                </div>
                            </td>
                            <td className="border border-gray-300 px-4 py-2 text-center font-semibold">65/100</td>
                            <td className="border border-gray-300 px-4 py-2 text-sm">Mengalami risiko kependatan, perlu
                                perhatian segera</td>
                        </tr>
                        <tr>
                            <td className="border border-gray-300 px-4 py-2">
                                <div className="flex items-center space-x-2">
                                    <TrendingUp className="w-4 h-4 text-orange-500" />
                                    <span>Risiko Ergonomik</span>
                                </div>
                            </td>
                            <td className="border border-gray-300 px-4 py-2 text-center">
                                <div className="flex items-center justify-center">
                                    <AlertTriangle className="w-5 h-5 text-yellow-500" />
                                    <span className="ml-1 text-sm">Rendah</span>
                                </div>
                            </td>
                            <td className="border border-gray-300 px-4 py-2 text-center font-semibold">3/15</td>
                            <td className="border border-gray-300 px-4 py-2 text-sm">Postur berisiko rendah, namun terdapat
                                masalah kecil VSD</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div className="p-6 bg-blue-50">
                <table className="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr className="bg-blue-600 text-white">
                            <th className="border border-gray-300 px-4 py-2 text-left">RISIKO</th>
                            <th className="border border-gray-300 px-4 py-2 text-left">TINDAKAN</th>
                            <th className="border border-gray-300 px-4 py-2 text-center">TANGGUNGJAWAB</th>
                            <th className="border border-gray-300 px-4 py-2 text-center">TEMPOH TARIKH SEMAK</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td className="border border-gray-300 px-4 py-2">Risiko Psikologi</td>
                            <td className="border border-gray-300 px-4 py-2">Khidmat nasihat kaunseling berkesinambungan
                            </td>
                            <td className="border border-gray-300 px-4 py-2 text-center">Kaunselor</td>
                            <td className="border border-gray-300 px-4 py-2 text-center">2 Minggu/ 2 Minggu selepas</td>
                        </tr>
                        <tr className="bg-gray-50">
                            <td className="border border-gray-300 px-4 py-2">Kepenatan</td>
                            <td className="border border-gray-300 px-4 py-2">Sesi kaunseling pengurusan kaunseling</td>
                            <td className="border border-gray-300 px-4 py-2 text-center">HR/Penyelja</td>
                            <td className="border border-gray-300 px-4 py-2 text-center">2 Minggu/ 2 Minggu selepas</td>
                        </tr>
                        <tr>
                            <td className="border border-gray-300 px-4 py-2">Risiko Ergonomik</td>
                            <td className="border border-gray-300 px-4 py-2">Latihan ergonomik/ teknik postur yang betul
                                semasa bekerja</td>
                            <td className="border border-gray-300 px-4 py-2 text-center">Penyelja</td>
                            <td className="border border-gray-300 px-4 py-2 text-center">1 Minggu/ 4 Minggu selepas</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div className="p-6 bg-yellow-50">
                <div className="flex items-center space-x-2">
                    <Calendar className="w-5 h-5 text-blue-600" />
                    <span className="font-semibold">Tarikh Penilaian Seterusnya Dijadualkan: [1 Disember 2025]</span>
                </div>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6">
                {/* Health Profile */}
                <div className="border border-gray-300 rounded-lg overflow-hidden">
                    <div className="bg-red-600 text-white p-3">
                        <div className="flex items-center space-x-2">
                            <Heart className="w-5 h-5" />
                            <span className="font-semibold">PROFIL KESIHATAN FIZIKAL, MENTAL & EMOSI</span>
                        </div>
                    </div>
                    <div className="p-4 space-y-3">
                        <div className="text-sm">
                            <span className="font-semibold">BMI:</span> Tahap Sihat: [24.7] [Berat badan berlebihan]
                        </div>
                        <div className="text-sm">
                            <span className="font-semibold">BMI:</span> [26.1] [Berat badan berlebihan]
                        </div>
                        <div className="text-sm">
                            <span className="font-semibold">Tahap Pernafasan:</span> Baik
                        </div>
                        <div className="space-y-2">
                            <div className="text-sm"><strong>Skala Kesiler 6 (Tekanan Psikologi):</strong> Skor [8] [Tidak
                                mengalami tekanan psikologi]</div>
                            <div className="text-sm"><strong>Skala Simptom Kemrunangan (CES-D):</strong> Skor [10]
                                [Mengalami kemrunangan]</div>
                            <div className="text-sm"><strong>Skala Penilaian Kepenatan:</strong> Skor [3.10] [Tinggi]</div>
                            <div className="text-sm"><strong>Ulasan:</strong> [Sangat tinggi tahap] sekerangapa pada tahap
                                yang sederhana]</div>
                        </div>
                    </div>
                </div>

                <div className="border border-gray-300 rounded-lg overflow-hidden">
                    <div className="bg-orange-600 text-white p-3">
                        <div className="flex items-center space-x-2">
                            <TrendingUp className="w-5 h-5" />
                            <span className="font-semibold">PROFIL PRODUKTIVITI KERJA</span>
                        </div>
                    </div>
                    <div className="p-4 space-y-3">
                        <div className="text-sm">
                            <span className="font-semibold">Prestasi Kerja Keseluruhan Individu:</span> Skor [8.33]
                            [Tinggi]
                        </div>
                        <div className="text-sm">
                            <span className="font-semibold">Prestasi Kontekstual:</span> Skor [8.10] [Sederhana]
                        </div>
                        <div className="text-sm">
                            <span className="font-semibold">Prilaku Kerja Produktif:</span> Skor [3.49] [Tinggi]
                        </div>
                        <div className="text-sm">
                            <span className="font-semibold">Impak Kesihatan Ke Atas Tempat Kerja:</span> Skor [55] [Sangat
                            Berkesan]
                        </div>
                        <div className="text-sm">
                            <span className="font-semibold">Skala Kerja:</span> Skor [51] [Berkesam]
                        </div>
                    </div>
                </div>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
                <div className="border border-gray-300 rounded-lg overflow-hidden">
                    <div className="bg-blue-600 text-white p-3 text-center">
                        <span className="font-semibold text-sm">PROFIL ERGONOMIK KERJA</span>
                    </div>
                    <div className="p-4 space-y-2">
                        <div className="text-xs">
                            <span className="font-semibold">Indeks Kebolehan Kerja:</span> Skor [42] [Baik]
                        </div>
                        <div className="text-xs">
                            <span className="font-semibold">Indeks Risiko Ergonomik:</span> Skor [3] [Tidak Berisiko]
                        </div>
                        <div className="text-xs">
                            <span className="font-semibold">Ulasan:</span> [Mempunyai keupayaan kerja yang baik dari segi
                            penilaian kerja fizikal dan mental]
                        </div>
                    </div>
                </div>

                <div className="border border-gray-300 rounded-lg overflow-hidden">
                    <div className="bg-green-600 text-white p-3 text-center">
                        <span className="font-semibold text-sm">PROFIL KESIHATAN (SEROLOGI)</span>
                    </div>
                    <div className="p-4 space-y-2">
                        <div className="text-xs">
                            <span className="font-semibold">Penilaian Anggota Badan Keseluruhan (REBA):</span> Skor [4]
                            [Sederhana]
                        </div>
                        <div className="text-xs">
                            <span className="font-semibold">Ulasan:</span> [Risiko rendah, perubahan mungkin diperlukan]
                        </div>
                        <div className="text-xs">
                            <span className="font-semibold">Penilaian Kendiri Muskuloskeletal:</span>
                        </div>
                        <div className="text-xs">
                            <span className="font-semibold">Ulasan:</span> [Postur berada dalam keadaan risiko MSD,
                            tambahbaik berisiko MSD]
                        </div>
                    </div>
                </div>

                <div className="border border-gray-300 rounded-lg">
                    <div className="bg-gray-200 h-32 flex items-center justify-center">
                        <MapPin className="w-8 h-8 text-gray-400" />
                    </div>
                    <div className="p-2">
                        <div className="text-xs text-center">
                            <span className="font-semibold">Cadangan/Tindakan</span>
                        </div>
                        <div className="h-16 bg-gray-100 mt-2 rounded"></div>
                        <div className="text-xs text-center mt-2">
                            <span className="font-semibold">Tarikh:</span>
                        </div>
                    </div>
                </div>
            </div>

            <div className="bg-gray-100 p-4 text-center text-sm text-gray-600">
                <p>Institut Penyelidikan Jasmani & Psikologi • Universiti Putra Malaysia</p>
                <p>Laporan ini adalah sulit dan tidak boleh disebarkan tanpa kebenaran bertulis</p>
            </div>
        </div>
    </div>

@endsection
