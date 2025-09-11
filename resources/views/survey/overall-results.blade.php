@extends('layouts.result')

@section('title', 'Laporan Penilaian Fit-to-Work Keseluruhan')

@section('content')

    <div id="document" class="min-h-screen bg-gray-100 p-6">
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

            <div class="p-4 bg-gray-50 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <a href="{{ route('dashboard') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                    </a>
                    <button id="printBtn" onclick="printDocument()"
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
                        STATUS: {{ $overallStatus === 'LENGKAP' ? '[✓] FIT-TO-WORK' : '[!] ' . $overallStatus }}
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
                            <td class="border border-gray-300 px-4 py-2 text-center font-semibold">
                                {{ isset($sectionsData['A']) ? $sectionsData['A']['response']->scores->where('section', 'A')->first()->score ?? 'N/A' : 'N/A' }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm">Status fizikal, mental dan emosi pada
                                tahap sederhana.</td>
                        </tr>
                        <tr class="bg-gray-50">
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
                            <td class="border border-gray-300 px-4 py-2 text-center font-semibold">
                                {{ isset($sectionsData['B']) ? $sectionsData['B']['response']->scores->where('section', 'B')->first()->score ?? 'N/A' : 'N/A' }}
                            </td>
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
                            <td class="border border-gray-300 px-4 py-2 text-center font-semibold">
                                {{ isset($sectionsData['C']) ? $sectionsData['C']['response']->scores->where('section', 'C')->first()->score ?? 'N/A' : 'N/A' }}/60
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm">Gejala ringan/ sederhana dikesan, perlu
                                diberi perhatian</td>
                        </tr>
                        <tr class="bg-gray-50">
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
                            <td class="border border-gray-300 px-4 py-2 text-center font-semibold">
                                {{ isset($sectionsData['D']) ? $sectionsData['D']['response']->scores->where('section', 'D_Keseluruhan')->first()->score ?? 'N/A' : 'N/A' }}/100
                            </td>
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
                            <td class="border border-gray-300 px-4 py-2 text-center font-semibold">
                                {{ isset($sectionsData['F']) ? $sectionsData['F']['response']->scores->where('section', 'F')->first()->score ?? 'N/A' : 'N/A' }}/15
                            </td>
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
                        <tr class="bg-gray-50">
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
                            <span class="font-semibold">BMI:</span> Tahap Sihat: {{ $respondent->bmi ?? 'N/A' }}
                            [{{ $respondent->health ?? 'Tidak diketahui' }}]
                        </div>
                        <div class="text-sm">
                            <span class="font-semibold">BMI:</span> {{ $respondent->bmi ?? 'N/A' }}
                            [{{ $respondent->health ?? 'Tidak diketahui' }}]
                        </div>
                        <div class="text-sm">
                            <span class="font-semibold">Tahap Pernafasan:</span> Baik
                        </div>
                        <div class="space-y-2">
                            <div class="text-sm"><strong>Skala Kesiler 6 (Tekanan Psikologi):</strong> Skor [8] [Tidak
                                mengalami tekanan psikologi]</div>
                            <div class="text-sm"><strong>Skala Simptom Kemrunangan (CES-D):</strong> Skor [10]
                                [Mengalami kemrunangan]</div>
                            <div class="text-sm"><strong>Skala Penilaian Kepenatan:</strong> Skor [3.10]
                                [{{ isset($sectionsData['E']) && isset($sectionsData['E']['subsectionScores'][0]) ? $sectionsData['E']['subsectionScores'][0]['category'] : 'Tidak diketahui' }}]
                            </div>
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
                            <span class="font-semibold">Prestasi Kerja Keseluruhan Individu:</span> Skor
                            {{ isset($sectionsData['E']) && isset($sectionsData['E']['subsectionScores'][0]) ? $sectionsData['E']['subsectionScores'][0]['score'] : 'N/A' }}
                            [{{ isset($sectionsData['E']) && isset($sectionsData['E']['subsectionScores'][0]) ? $sectionsData['E']['subsectionScores'][0]['category'] : 'Tidak diketahui' }}]
                        </div>
                        <div class="text-sm">
                            <span class="font-semibold">Prestasi Kontekstual:</span> Skor [8.10] [Sederhana]
                        </div>
                        <div class="text-sm">
                            <span class="font-semibold">Prilaku Kerja Produktif:</span> Skor [3.49]
                            [{{ isset($sectionsData['E']) && isset($sectionsData['E']['subsectionScores'][0]) ? $sectionsData['E']['subsectionScores'][0]['category'] : 'Tidak diketahui' }}]
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
                            <span class="font-semibold">Penilaian Anggota Badan Keseluruhan (REBA):</span> Skor
                            {{ isset($sectionsData['A']) ? $sectionsData['A']['response']->scores->where('section', 'Skor REBA Akhir')->first()->score ?? 'N/A' : 'N/A' }}
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
    console.log('Print function called');

    // Hide elements that shouldn't be printed
    const elementsToHide = document.querySelectorAll('a[href], button:not(#printBtn)');
    elementsToHide.forEach(el => el.style.display = 'none');

    // Add print-specific styles
    const printStyles = document.createElement('style');
    printStyles.innerHTML = `
        @media print {
            @page {
                size: A4;
                margin: 20mm 15mm 20mm 15mm;
            }
            body { margin: 0; background: white !important; font-size: 12px; }
            .min-h-screen { min-height: auto !important; }
            * { -webkit-print-color-adjust: exact !important; color-adjust: exact !important; }
            a[href], button { display: none !important; }
            .bg-gradient-to-r { background: linear-gradient(to right, #dc2626, #dc2626) !important; }
            .bg-blue-900 { background-color: #1e3a8a !important; }
            .bg-blue-600 { background-color: #2563eb !important; }
            .bg-green-600 { background-color: #16a34a !important; }
            .bg-yellow-50 { background-color: #fefce8 !important; }
            .bg-blue-50 { background-color: #eff6ff !important; }
            .bg-red-600 { background-color: #dc2626 !important; }
            .bg-orange-600 { background-color: #ea580c !important; }
            .bg-gray-200 { background-color: #e5e7eb !important; }
            .bg-gray-100 { background-color: #f3f4f6 !important; }
            .text-white { color: white !important; }
            .max-w-6xl { max-width: 100% !important; }
            .p-6 { padding: 1rem !important; }
            .p-4 { padding: 0.75rem !important; }
            .p-3 { padding: 0.5rem !important; }
            .px-4 { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
            .py-2 { padding-top: 0.25rem !important; padding-bottom: 0.25rem !important; }
            .px-3 { padding-left: 0.5rem !important; padding-right: 0.5rem !important; }
            .py-1 { padding-top: 0.125rem !important; padding-bottom: 0.125rem !important; }
            .text-lg { font-size: 1rem !important; }
            .text-sm { font-size: 0.875rem !important; }
            .text-xs { font-size: 0.75rem !important; }
            .grid-cols-1 { grid-template-columns: 1fr !important; }
            .lg\\:grid-cols-2 { grid-template-columns: 1fr !important; }
            .lg\\:grid-cols-3 { grid-template-columns: 1fr !important; }
            .gap-6 { gap: 1rem !important; }
            .space-x-4 > * + * { margin-left: 0.75rem !important; }
            .space-x-2 > * + * { margin-left: 0.5rem !important; }
            .space-y-3 > * + * { margin-top: 0.5rem !important; }
            .space-y-2 > * + * { margin-top: 0.25rem !important; }
            .w-16 { width: 3rem !important; }
            .h-16 { height: 3rem !important; }
            .w-12 { width: 2.5rem !important; }
            .h-12 { height: 2.5rem !important; }
            .w-5 { width: 1.25rem !important; }
            .h-5 { height: 1.25rem !important; }
            .w-4 { width: 1rem !important; }
            .h-4 { height: 1rem !important; }
            .w-6 { width: 1.5rem !important; }
            .h-6 { height: 1.5rem !important; }
            .w-8 { width: 2rem !important; }
            .h-8 { height: 2rem !important; }
            .h-32 { height: 6rem !important; }
            .h-16 { height: 4rem !important; }
            table { font-size: 0.75rem !important; width: 100% !important; table-layout: fixed !important; }
            th, td { padding: 0.25rem !important; word-wrap: break-word !important; }
            th:nth-child(1), td:nth-child(1) { width: 25% !important; }
            th:nth-child(2), td:nth-child(2) { width: 15% !important; }
            th:nth-child(3), td:nth-child(3) { width: 15% !important; }
            th:nth-child(4), td:nth-child(4) { width: 45% !important; }
            .border-collapse { border-collapse: collapse !important; }
            .border { border: 1px solid #d1d5db !important; }
        }
    `;
    document.head.appendChild(printStyles);

    // Print the document
    window.print();

    // Restore hidden elements after printing
    setTimeout(() => {
        elementsToHide.forEach(el => el.style.display = '');
        document.head.removeChild(printStyles);
    }, 1000);

    console.log('Print initiated');
}

// Add event listener when page loads
document.addEventListener('DOMContentLoaded', function() {
    var printBtn = document.getElementById('printBtn');
    if (printBtn) {
        printBtn.addEventListener('click', function(e) {
            e.preventDefault();
            printDocument();
        });
        console.log('Print button event listener added');
    } else {
        console.error('Print button not found');
    }
});
</script>
@endsection
