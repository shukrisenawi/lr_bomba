<x-layout>

<x-title-section>
<x-slot:title1>BAHAGIAN D: Impak Latihan Di Tempat Kerja</x-slot:title1>
<x-slot:title2>SECTION D: Training Impact at Work (TIAW)</x-slot:title2>
<x-slot:description>Instrumen Impak Latihan di Tempat Kerja (atau Training Impact at Work) merupakan alat penilaian yang dirancang khusus untuk mengukur keberkesanan program latihan dalam lingkungan kerja. Instrumen ini bertujuan untuk menilai sejauh mana latihan telah mencapai objektif yang ditetapkan, serta pengaruhnya terhadap prestasi individu, pasukan, dan organisasi secara keseluruhan.</x-slot:description>
</x-title-section>
<p class="font-bold">
Kenyataan berikut berkaitan impak latihan di tempat kerja. Sila nyatakan sejauh mana setiap kenyataan ini berlaku kepada anda.
</p>
<br>
        <form action="" method="POST">
            @csrf
            @foreach(["Kualiti kerja saya telah bertambah baik", "Saya membuat sedikit kesilapan di tempat kerja", "Saya melakukan kerja saya dengan lebih cepat.", "Keyakinan diri saya telah meningkat.", 'Motivasi saya untuk bekerja telah bertambah baik.', 'Kualiti kerja saya yang tidak berkaitan dengan kursus telah bertambah baik.', 'Saya mencadangkan perubahan rutin kerja yang lebih kerap.', 'Saya sering menggunakan kemahiran yang dipelajari semasa latihan.',
                'Saya berasa lebih terbuka kepada perubahan.', 'Saya mengambil kesempatan untuk mempraktikkan kemahiran baharu yang saya pelajari.', 'Rakan sekerja saya boleh belajar daripada saya.', 'Saya dapat mengingat kandungan kursus dengan baik.'] as $index => $question)

            <x-radio-button-choose :choose="3">
                <x-slot:id>D{{ $index + 1 }}</x-slot:id>
                <x-slot:label>{{ $index + 1 }}. {{ $question }}</x-slot:label>
            </x-radio-button-choose>
                @endforeach

<br>

        <x-reference>
<x-slot:title>Rujukan</x-slot:title>
<x-slot:description><ol class="list-decimal list-inside mb-4">
    <li class="font-bold">
        Abbad, G., Andrade, J. E. B., & Sallorenzo, L. H. (2004). Self-assessment of training impact at work: validation of a measurement scale. Revista Interamericana de Psicologia/Interamerican Journal of Psychology, 38(2), 277-284.
    </li>
    <li>
        A two sub-scale structure was found (a=0.86; r=.56) accounting for 60 percent of the impact variability. A single factor structure was also found and it is similarly reliable (a=.90), accounting for 45 percent of the variability. Both structures are useful, reliable and valid.
    </li>
</ol></x-slot:description>
</x-reference>

<x-accordion>
    <x-slot:title>JUMLAH SKOR TIAW:</x-slot:title>
    <x-slot:description><p class="font-bold text-red-500">
    *paparan nilai sebenar skor diperolehi dan status (lemah/sederhana/baik/cemerlang)
<br>

Rujukan julat skor dan status:<br>
7-27 Lemah &nbsp;&nbsp;&nbsp; 28-36 Sederhana  &nbsp;&nbsp;&nbsp; 37-43 Baik      &nbsp;&nbsp;&nbsp;  44-49 Cemerlang
<br><br>
SARANAN: ____________
<ul class="list-disc mx-10 text-red-500 font-bold">
    <li>Jika ‘Lemah’, saranan: Anda perlu memberikan perhatian kepada aspek penjagaan kesihatan fizikal dan mental, mengikuti lebih banyak latihan berkaitan kerja serta memberikan komitmen sepenuhnya kepada tanggungjawab kerja,</li>
    <li>Jika ‘Sederhana’, saranan: Anda perlu meningkatkan keupayaan kerja dari aspek latihan fizikal dan kemahiran teknikal yang komprehensif serta pengurusan mental dan emosi yang lebih baik.</li>
    <li>Jika ‘Baik’, saranan: Tahniah atas keupayaan kerja anda yang baik. Kekalkan pencapaian ini atau boleh terus berusaha untuk meningkatkan potensi dan pengembangan diri dengan lebih baik dalam pekerjaan.</li>
    <li>Jika ‘Cemerlang’, saranan: Tahniah atas keupayaan kerja anda yang cemerlang. Kekalkan pencapaian ini disamping boleh membantu rakan sekerja untuk meningkatkan potensi dan pengembangan diri mereka dalam pekerjaan.</li>
</ul></x-slot:description>
</x-accordion>
        <x-navigation>
            <x-slot:active>4</x-slot:active>
            <x-slot:link1>/part-3</x-slot:link1>
            <x-slot:link2>/part-5</x-slot:link2>
        </x-navigation>

        </form>
</x-layout>