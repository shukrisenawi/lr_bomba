<x-layout>
<x-title-section>
<x-slot:title1>BAHAGIAN G: Skala Kemurungan CES-D</x-slot:title1>
<x-slot:title2>SECTION G: Depression Scale CES-D</x-slot:title2>
<x-slot:description>Skala Kemurungan Kajian Epidemiologi Pusat (CES-D) (atau Depression Scale CES-D) ialah satu soal selidik kendiri yang digunakan secara meluas untuk menilai simptom kemurungan dalam populasi umum. Ia terdiri daripada 20 item yang menanyakan tentang kekerapan pelbagai simptom kemurungan sepanjang minggu lepas.</x-slot:description>
</x-title-section>
<p class="font-bold">
Di bawah adalah senarai sebahagian perkara yang anda mungkin rasa atau lakukan. Tandakan (√) pada kenyataan yang paling tepat dengan diri anda.
</p><br>
        <form action="" method="POST">
            @csrf
            @foreach([
                'Berapa kerap anda merasa gugup?',
                'Berapa kerap anda merasa putus asa?',
                'Berapa kerap anda merasa gelisah atau tidak tenteram?',
                'Berapa kerap anda merasa begitu tertekan sehingga tiada apa yang dapat menggembirakan anda?',
                'Berapa kerap anda merasa bahawa segala-galanya adalah usaha?',
                'Berapa kerap anda merasa tidak berharga?',
            ] as $index => $question)

        <x-radio-button-choose :choose="6">
            <x-slot:id>F{{ $index + 1 }}</x-slot:id>
            <x-slot:label>{{ $index + 1 }}. {{ $question }}</x-slot:label>
        </x-radio-button-choose>

            @endforeach
            <br>
<x-reference>
<x-slot:title>Rujukan</x-slot:title>
<x-slot:description><ol class="list-decimal list-inside mb-4">
    <li class="font-bold">
        Lins, G. O. D. A., Lima, N. A. D. S., Sousa, G. S. D., Guimarães, F. J., Frazão, I. D. S., & Perrelli, J. G. A. (2021). Validity and reliability of Kessler Psychological Distress Scale for Brazilian elderly: a cross-sectional study. Revista Brasileira de Enfermagem, 74(Suppl 2), e20200365.
    </li>
    <li>
        The total internal consistency of K10 was α=0.844, which shows high reliability. The K10 scale proved to be valid and reliable for verifying mental distress in elderly people in PHC.
    </li></ol></x-slot:description>
</x-reference>
<x-accordion>
<x-slot:title>JUMLAH SKOR K6+ :</x-slot:title>
<x-slot:description>
<p class="text-red-500 font-bold">*paparan nilai skor diperolehi dan status</p><br>
<p class="text-red-500 font-bold">Rujukan julat skor dan status:<br>
13 dan ke atas (ada mengalami gangguan psikologi yang teruk)<br>
12 dan ke bawah (tiada mengalami gangguan psikologi yang teruk)
</p><br>
<p class="text-red-500 font-bold">
SARANAN: ____________
<ul class="list-disc text-red-500 font-bold ml-5">
    <li>Jika ‘gangguan psikologi yang teruk’, saranan: Sila rujuk dengan pegawai perubatan bagi mendapatkan penilaian lanjut berkaitan keadaan anda.</li>
    <li>Jika ‘tiada gangguan psikologi yang teruk’, saranan: Walaupun anda tidak mengalami gangguan psikologi yang teruk, teruskan penjagaan diri dengan tidur cukup, makan sihat, dan bersenam. Kekalkan hubungan sosial, uruskan tekanan, dan lakukan aktiviti yang anda nikmati. Tetapkan matlamat realistik, amalkan pemikiran positif, dan dapatkan bantuan profesional jika perlu. Teruskan pendidikan kesihatan mental untuk kesejahteraan berterusan.</li>
</ul>
</p>
</x-slot:description>
</x-accordion>

        <x-navigation>
            <x-slot:active>6</x-slot:active>
            <x-slot:link1>/part-5</x-slot:link1>
            <x-slot:link2>/part-7</x-slot:link2>
        </x-navigation>
        </form>
</x-layout>