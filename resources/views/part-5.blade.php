<x-layout>
<x-title-section>
<x-slot:title1>BAHAGIAN E: Soal-selidik Prestasi Keja Individu</x-slot:title1>
<x-slot:title2>SECTION E: Individual Work Performance Questionnaire (IWPQ)</x-slot:title2>
<x-slot:description>Soal-selidik Prestasi Kerja Individu (atau Individual Work Performance Questionnaire, IWPQ) adalah berdasarkan penilaian kepada enpat dimensi prestasi kerja individu yang terdiri daripada prestasi tugas, prestasi konteksual, prestasi adaptif, dan tingkah laku kerja kontraproduktif.</x-slot:description>
</x-title-section>
<p class="font-bold">
Menggunakan skala di bawah, sila nyatakan bagi setiap pernyataan berikut sejauh mana ia kini sepadan dengan salah satu sebab mengapa anda melakukan pekerjaan khusus ini.
</p>

        <form action="" method="POST">
            @csrf
<x-subtitle>Prestasi Tugas</x-subtitle>

            <div class="mx-5">
                @foreach([
                    'Saya dapat merancang kerja saya supaya saya dapat menyelesaikannya tepat pada waktunya',
                    'Saya ingat hasil kerja yang perlu saya capai',
                    'Saya dapat menetapkan keutamaan',
                    'Saya dapat melaksanakan kerja saya dengan cekap',
                    'Saya menguruskan masa saya dengan baik'
                ] as $index => $question)

            <x-radio-button-choose :choose="4">
                <x-slot:id>E{{ $index + 1 }}</x-slot:id>
                <x-slot:label>{{ $index + 1 }}. {{ $question }}</x-slot:label>
            </x-radio-button-choose>

                @endforeach
            </div>

<x-subtitle>Prestasi Konteksual</x-subtitle>

            <div class="mx-5">
                @foreach([
                    'Atas inisiatif saya sendiri, saya memulakan tugas baharu apabila tugas lama saya selesai',
                    'Saya mengambil tugas yang mencabar apabila ia tersedia',
                    'Saya berusaha mengemas kini pengetahuan berkaitan pekerjaan saya',
                    'Saya berusaha mengemas kini kemahiran kerja saya',
                    'Saya menghasilkan penyelesaian kreatif untuk masalah baharu',
                    'Saya mengambil tanggungjawab tambahan',
                    'Saya sentiasa mencari cabaran baharu dalam kerja saya',
                    'Saya aktif mengambil bahagian dalam mesyuarat dan/atau perundingan'
                ] as $index => $question)

            <x-radio-button-choose :choose="4">
                <x-slot:id>E{{ $index + 6 }}</x-slot:id>
                <x-slot:label>{{ $index + 6 }}. {{ $question }}</x-slot:label>
            </x-radio-button-choose>

                @endforeach
            </div>

            <x-subtitle>Perilaku Kerja Tidak Produktif</x-subtitle>

            <div class="mx-5">
                @foreach([
                    'Saya mengadu mengenai isu-isu kecil berkaitan kerja di tempat kerja',
                    'Saya memperbesarkan masalah di tempat kerja melebihi sepatutnya',
                    'Saya lebih fokus pada aspek negatif situasi di tempat kerja berbanding aspek positifnya',
                    'Saya bercakap dengan rakan sekerja tentang aspek negatif kerja saya',
                    'Saya bercakap dengan orang di luar organisasi tentang aspek negatif kerja saya'
                ] as $index => $question)

            <x-radio-button-choose :choose="5">
                <x-slot:id>E{{ $index + 14 }}</x-slot:id>
                <x-slot:label>{{ $index + 14 }}. {{ $question }}</x-slot:label>
            </x-radio-button-choose>
                @endforeach
            </div>

<br>
        <x-reference>
<x-slot:title>Rujukan</x-slot:title>
<x-slot:description><ol class="list-decimal list-inside mb-4">
    <li class="font-bold">
        Platania, S., Morando, M., Gruttadauria, S. V., & Koopmans, L. (2023). The individual work performance questionnaire: Psychometric properties of the Italian version. European Journal of Investigation in Health, Psychology and Education, 14(1), 49-63.
    </li>
    <li>
        Cronbach’s Alpha was computed for each factor to test reliability and showed good internal consistency of the scale: Task performance 0.75, Contextual performance 0.88 and CWB 0.77. Composite reliability and average variance extracted from the IWPQ were CR 0.88, AVE 0.59 for Task Performance, CR 0.89, AVE 0.52 for Contextual Performance, and CR 0.81, AVE 0.52 for CWB.
    </li>
</ol></x-slot:description>
</x-reference>
<x-accordion>
<x-slot:title>JUMLAH SKOR PRESTASI TUGAS :</x-slot:title>
<x-slot:description><p class="text-red-500 font-bold">*paparan nilai min skor diperolehi (jumlah skor bahagi 5) dan status (sangat rendah/rendah/sederhana/tinggi/sangat tinggi)</p></x-slot:description>
</x-accordion>
<x-accordion>
<x-slot:title>JUMLAH SKOR PRESTASI KONTEKSUAL :</x-slot:title>
<x-slot:description><p class="text-red-500 font-bold">*paparan nilai min skor diperolehi (jumlah skor bahagi 8) dan status (sangat rendah/rendah/sederhana/tinggi/sangat tinggi)</p></x-slot:description>
</x-accordion>

<x-accordion>
<x-slot:title>JUMLAH SKOR PERILAKU KERJA TIDAK PRODUKTIF :</x-slot:title>
<x-slot:description><p class="text-red-500 font-bold">*paparan nilai min skor diperolehi (jumlah skor bahagi 5) dan status (sangat rendah/rendah/sederhana/tinggi/sangat tinggi)</p></x-slot:description>
</x-accordion>

<x-accordion>
<x-slot:title>JUMLAH SKOR KESELURUHAN :</x-slot:title>
<x-slot:description>
<p class="text-red-500 font-bold">*paparan nilai min skor diperolehi (campur semua jumlah min skor bahagi 3) dan status (sangat rendah/rendah/sederhana/tinggi/sangat tinggi)</p><br>
<p class="text-red-500 font-bold ml-5">
    Rujukan julat min skor dan status:<br>
2.00 dan ke bawah (sangat rendah)<br>
2.01 - 2.49 (rendah)<br>
2.50 - 3.16 (sederhana)<br>
3.17 - 3.49 (tinggi)<br>
3.50 dan ke atas (sangat tinggi)<br>

</p><br>
<p class="text-red-500 font-bold">
    SARANAN: ____________
    <ul class="list-disc text-red-500 font-bold ml-5">
<li>Jika ‘sangat rendah’, saranan: Perbincangan segera dengan pihak majikan perlu dibuat untuk mengenalpasti isu berkaitan dan mencari kaedah penyelesaian yang bersesuaian seperti pelaksanaan program sokongan (latihan, bimbingan, perubahan tugas), penetapan matlamat yang jelas, dan pemantauan berterusan bagi meningkatkan prestasi kerja.</li>
<li>Jika ‘rendah’, saranan: Memerlukan tindakan pembaikan untuk meningkatkan prestasi kerja. Ini melibatkan sesi maklum balas konstruktif dengan pihak majikan, penyediaan rancangan pembangunan individu, peluang latihan atau pengawasan tambahan, dan sokongan berterusan.</li>
<li>Jika ‘sederhana’, saranan: Prestasi kerja boleh dipertingkatkan. Berbincang bersama pihak majikan bagi mengenalpasti kekuatan dan kelemahan. Ikuti latihan yang bersesuaian bagi pembangunan kerjaya yang berterusan.
</li>
<li>Jika ‘tinggi’, saranan: Prestasi kerja berpotensi untuk mencapai tahap cemerlang. Pengiktirafan dari majikan adalah amat dialu-alukan sebagai satu mekanisma motivasi diri di samping memberi peluang tanggungjawab baharu bagi pembangunan kerjaya melalui projek khas atau latihan lanjutan. Anda boleh menjadi mentor dan contoh kepada rakan sekerja lain.</li>
<li>Jika ‘sangat tinggi’, saranan: Tahniah, prestasi kerja melebihi jangkaan dengan profesionalisme tinggi. Pengiktirafan melalui ganjaran, peluang kepimpinan dan pertimbangkan promosi kerjaya atau kenaikan gaji oleh majikan untuk mengekalkan motivasi mereka amatlah disarankan.  Sebagai pekerja yang cemerlang, anda boleh menjadi mentor dalam membantu rakan sekerja meningkatkan prestasi kerja menjadi lebih baik.</li>
    </ul>
</p>

</x-slot:description>
</x-accordion>



        <x-navigation>
            <x-slot:active>5</x-slot:active>
            <x-slot:link1>/part-4</x-slot:link1>
            <x-slot:link2>/part-6</x-slot:link2>
        </x-navigation>

        </form>
</x-layout>