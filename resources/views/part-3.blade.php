<x-layout>
<x-title-section>
<x-slot:title1>BAHAGIAN C: Soal-selidik Kandungan Kerja</x-slot:title1>
<x-slot:title2>SECTION C: Job Content Questionnaire (JCQ)</x-slot:title2>
<x-slot:description>Soal-selidik Kandungan Kerja (atau Job Content Questionnaire, JCQ) ialah satu instrumen kendiri yang direka untuk mengukur ciri-ciri sosial dan psikologi pekerjaan. Ia digunakan secara meluas dalam penyelidikan kesihatan pekerjaan untuk menilai tekanan kerja dan potensi akibat kesihatannya.</x-slot:description>
</x-title-section>
<p class="font-bold mb-10">Kenyataan berikut berkaitan dengan situasi harian anda dan bagaimana anda mengalaminya. Sila nyatakan sejauh mana setiap kenyataan ini berlaku kepada anda.</p>

        <form action="#" method="POST">
            @csrf

<x-subtitle>Diskresi Kemahiran</x-subtitle>

            <div class="mx-5">
                @foreach(['Pekerjaan saya perlukan saya belajar benda baru', 'Pekerjaan saya memerlukan saya untuk menjadi kreatif', 'Pekerjaan saya memerlukan tahap kemahiran yang tinggi', 'Saya dapat melakukan pelbagai benda berbeza dalam pekerjaan saya', 'Saya berpeluang untuk membangunkan kebolehan istimewa saya sendiri'] as $index => $question)

            <x-radio-button-choose :choose="3">
                <x-slot:id>C{{ $index + 1 }}</x-slot:id>
                <x-slot:label>{{ $index + 1 }}. {{ $question }}</x-slot:label>
            </x-radio-button-choose>
                @endforeach
            </div>

<x-subtitle>Kuasa Membuat Keputusan</x-subtitle>

            <div class="mx-5">
                @foreach(['Pekerjaan saya membolehkan saya membuat banyak keputusan sendiri', 'Dalam pekerjaan saya, saya mempunyai sedikit kebebasan untuk membuat keputusan tentang bagaimana saya membuat kerja', 'Saya mempunyai banyak yang ingin dikatakan tentang apa yang berlaku dengan kerja saya'] as $index => $question)

            <x-radio-button-choose :choose="3">
                <x-slot:id>C{{ $index + 6 }}</x-slot:id>
                <x-slot:label>{{ $index + 6 }}. {{ $question }}</x-slot:label>
            </x-radio-button-choose>
                @endforeach
            </div>


<x-subtitle>Tuntutan Psikologi</x-subtitle>

            <div class="mx-5">
                @foreach(['Pekerjaan saya memerlukan saya bekerja dengan sangat cepat', 'Pekerjaan saya memerlukan saya bekerja dengan sangat keras', 'Saya bebas daripada tuntutan bercanggah yang dibuat oleh orang lain', 'Pekerjaan saya memerlukan penumpuan perhatian yang tinggi dalam jangka masa panjang', 'Pekerjaan saya sangat sibuk', 'Menunggu kerja daripada orang lain atau jabatan lain seringkali memperlahankan kerja saya', 'Tugas saya sering terganggu sebelum saya dapat menyelesaikannya, menyebabkan saya perlu kembali kepadanya kemudian'] as $index => $question)

            <x-radio-button-choose :choose="3">
                <x-slot:id>C{{ $index + 9 }}</x-slot:id>
                <x-slot:label>{{ $index + 9 }}. {{ $question }}</x-slot:label>
            </x-radio-button-choose>
                @endforeach
            </div>

<x-subtitle>Sokongan Sosial Rakan Sejawat</x-subtitle>

            <div class="mx-5">
                @foreach(['Orang-orang yang saya bekerja bersama kompeten dalam melakukan tugas mereka', 'Orang-orang yang saya bekerja bersama mengambil berat tentang saya', 'Orang-orang yang saya bekerja bersama membantu dalam menyiapkan kerja'] as $index => $question)

            <x-radio-button-choose :choose="3">
                <x-slot:id>C{{ $index + 16 }}</x-slot:id>
                <x-slot:label>{{ $index + 16 }}. {{ $question }}</x-slot:label>
            </x-radio-button-choose>
                @endforeach
            </div>

<x-subtitle>Sokongan Sosial Penyelia</x-subtitle>

            <div class="mx-5">
                @foreach(['Penyelia saya memberi perhatian kepada apa yang saya katakan', 'Penyelia saya membantu saya dalam menyiapkan kerja', 'Penyelia saya berjaya dalam menggalakkan kerjasama antara pekerja'] as $index => $question)

            <x-radio-button-choose :choose="3">
                <x-slot:id>C{{ $index + 19 }}</x-slot:id>
                <x-slot:label>{{ $index + 19 }}. {{ $question }}</x-slot:label>
            </x-radio-button-choose>
                @endforeach
            </div>
        </form>
        <br>
<x-reference>
<x-slot:title>Rujukan</x-slot:title>
<x-slot:description><ol class="list-decimal list-inside mb-4">
    <li class="font-bold">
        Edimansyah, B. A., Rusli, B. N., Naing, L., & Mazalisah, M. (2006). Reliability and construct validity of the Malay version of the Job Content Questionnaire (JCQ). Southeast Asian Journal of Tropical Medicine and Public Health, 37(2), 412.
    </li>
    <li>
        The Cronbach’s alpha coefficients were acceptable for decision latitude (0.74), psychological job demand (0.61) and social support (0.79). Exploratory factor analysis showed the first factor was associated with the scales of social support (0.54 to 0.84). The second factor was associated with all items of psychological job demand scale (0.41 to 0.65). The third factor more accurately reflects the decision latitude scale (0.38 to 0.70).
    </li>
</ol></x-slot:description>
</x-reference>
<br>
<strong>JUMLAH SKOR _____ </strong>

        <x-navigation>
            <x-slot:active>3</x-slot:active>
            <x-slot:link1>/part-2</x-slot:link1>
            <x-slot:link2>/part-4</x-slot:link2>
        </x-navigation>
</x-layout>