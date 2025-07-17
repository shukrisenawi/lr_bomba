<x-layout>
<x-title-section>
<x-slot:title1>BAHAGIAN F: Skala Kemurungan Psikologikal Kessler 6</x-slot:title1>
<x-slot:title2>SECTION F: Kessler 6 Psychological Distress Scale (K6+)</x-slot:title2>
<x-slot:description>Skala Kemurungan Psikologikal Kessler 6 (atau Kessler 6 Psychological Distress Scale, K6+) adalah instrumen yang berpotensi untuk menyaring masalah kesihatan mental dan menilai tahap kesulitan yang dihadapi. Ia digunakan secara meluas dalam penyelidikan dan perubatan klinikal kerana ia ringkas, boleh dipercayai, dan mempunyai kesahihan. Ia sangat membantu dalam mengenal pasti individu yang mungkin memerlukan penilaian dan rawatan lanjut.</x-slot:description>
</x-title-section>
<p class="font-bold">
Sila baca setiap kenyataan dan tandakan 0, 1, 2, 3 atau 4 pada kenyataan yang menggambarkan keadaan anda dalam 30 hari yang lalu.
</p><br>
        <form action="" method="POST">
            @csrf
            @foreach([
                'Fikiran saya diganggu oleh hal yang selalunya tidak menggangu saya.',
                'Saya tiada selera untuk makan.',
                'Saya rasa saya tidak dapat menghapuskan perasaan tertekan walaupun dengan bantuan kawan-kawan saya.',
                'Saya rasa saya sebaik orang lain.',
                'Saya mempunyai masalah untuk menumpukan perhatian kepada kerja yang saya lakukan.',
                'Saya rasa tertekan.',
                'Saya rasa semua yang saya lakukan adalah satu usaha.',
                'Saya rasa mempunyai harapan yang baik untuk masa depan saya.',
                'Saya fikir hidup saya telah mengalami kegagalan.',
                'Saya merasa sangat takut.',
                'Tidur saya terganggu.',
                'Saya gembira.',
                'Saya bercakap kurang berbanding kebiasaannya.',
                'Saya berasa kesunyian.',
                'Orang di sekeliling saya tidak mesra.',
                'Saya menikmati hidup saya.',
                'Saya memaki-hamun / menyumpah.',
                'Saya berasa sedih.',
                'Saya rasa orang lain tidak sukakan saya.',
                'Saya tidak dapat meneruskan hidup.',

            ] as $index => $question)

        <x-radio-button-choose :choose="7">
            <x-slot:id>G{{ $index + 1 }}</x-slot:id>
            <x-slot:label>{{ $index + 1 }}. {{ $question }}</x-slot:label>
        </x-radio-button-choose>

            @endforeach
<br>
<x-reference>
<x-slot:title>Rujukan</x-slot:title>
<x-slot:description><ol class="list-decimal list-inside mb-4">
    <li class="font-bold">
        Fountoulakis, K., Iacovides, A., Kleanthous, S., Samolis, S., Kaprinis, S. G., Sitzoglou, K., St Kaprinis, G.  & Bech, P. (2001). Reliability, validity and psychometric properties of the Greek translation of the Center for Epidemiological Studies-Depression (CES-D) Scale. BMC psychiatry, 1, 1-10.
    </li>
    <li>
        Both Sensitivity and specificity exceed 90.00 at 23/24, Chronbach's alpha for the total scale was equal to 0.95. The test-retest reliability was satisfactory (Pearson's R between 0.45 and 0.95 for individual items and 0.71 for total score).
    </li></ol></x-slot:description>
</x-reference>
<x-accordion>
<x-slot:title>JUMLAH SKOR CES-D :</x-slot:title>
<x-slot:description>
<p class="text-red-500 font-bold">*paparan nilai skor diperolehi dan status</p><br>
<p class="text-red-500 font-bold ml-5">Rujukan julat skor dan status:<br>
22 dan ke atas (mengalami simptom kemurungan yang tinggi)<br>
15-21 (mengalami simptom kemurungan ringan/sederhana)<br>
14 dan ke bawah (tidak mengalami sebarang simptom kemurungan)
</p><br>
<p class="text-red-500 font-bold">
SARANAN: ____________
<ul class="list-disc text-red-500 font-bold ml-5">
    <li>Jika ‘mengalami simptom kemurungan yang tinggi’, saranan: Dapatkan bantuan segera daripada profesional kesihatan mental seperti psikologi klinikal atau pakar psikiatri bagi menilai simptom secara lebih mendalam untuk rawatan yang bersesuaian.</li>
    <li>Jika ‘mengalami simptom kemurungan yang ringan/sederhana’, saranan: Walaupun simptom kemurungan ini mungkin tidak terlalu serius, saranan untuk berunding dengan kaunselor atau psikologi klinikal untuk khidmat nasihat dalam merancang strategi pengurusan emosi dan sokongan yang bersesuaian.</li>
    <li>Jika ‘tidak mengalami sebarang simptom kemurungan’, saranan: Terus menjaga kesihatan mental secara keseluruhan melalui amalan gaya hidup yang sihat, menjaga hubungan sosial yang positif, dan terus memantau kesejahteraan emosi yang boleh membantu menghalang kemurungan di masa depan. </li>
</ul>
</x-slot:description>
</x-accordion>


        </form>

        <x-navigation>
            <x-slot:active>7</x-slot:active>
            <x-slot:link1>/part-6</x-slot:link1>
            <x-slot:link2>/part-8</x-slot:link2>
        </x-navigation>

</x-layout>