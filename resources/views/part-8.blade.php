<x-layout>
<x-title-section>
<x-slot:title1>BAHAGIAN H: Instrumen Penilaian Kepenatan</x-slot:title1>
<x-slot:title2>SECTION H: Burnout Assessment Tool (BAT)</x-slot:title2>
<x-slot:description>Alat Penilaian Keletihan (atau Burnout Assessment Tool, BAT) ialah satu soal selidik yang disahkan secara saintifik yang direka untuk menilai risiko keletihan. Ia mengukur keletihan sebagai satu sindrom dengan empat komponen teras seperti keletihan, jarak mental, kemerosotan kognitif dan emosi.</x-slot:description>
</x-title-section>
<p class="font-bold">
Kenyataan berikut berkaitan dengan situasi harian anda dan bagaimana anda mengalaminya. Sila nyatakan sejauh mana setiap kenyataan ini berlaku kepada anda.
</p><br>
        <form action="" method="POST">
            @csrf
<x-subtitle>Keletihan</x-subtitle>

            @foreach([
                'Di tempat kerja, saya rasa keletihan mental.',
                'Selepas seharian bekerja, saya sukar untuk memulihkan tenaga saya.',
                'Di tempat kerja, saya rasa keletihan fizikal.'
            ] as $index => $question)

        <x-radio-button-choose :choose="8">
            <x-slot:id>H{{ $index + 1 }}</x-slot:id>
            <x-slot:label>{{ $index + 1 }}. {{ $question }}</x-slot:label>
        </x-radio-button-choose>

            @endforeach

<x-subtitle>Jarak mental</x-subtitle>

            @foreach([
                'Saya sukar untuk mencari semangat untuk kerja saya.',
                'Saya berasa sangat tidak suka terhadap pekerjaan saya.',
                'Saya sinis tentang kerja saya memberi makna kepada orang lain.',
            ] as $index => $question)

        <x-radio-button-choose :choose="8">
            <x-slot:id>H{{ $index + 4 }}</x-slot:id>
            <x-slot:label>{{ $index + 4 }}. {{ $question }}</x-slot:label>
        </x-radio-button-choose>

            @endforeach

<x-subtitle>Kemerosotan kognitif</x-subtitle>

            @foreach([
                'Ditempat kerja, saya ada masalah untuk kekal fokus.',
                'Apabila saya sedang bekerja, saya mempunyai masalah untuk menumpukan perhatian.',
                'Saya membuat kesilapan dalam kerja kerana dalam fikiran saya ada perkara lain.',
            ] as $index => $question)

        <x-radio-button-choose :choose="8">
            <x-slot:id>H{{ $index + 7 }}</x-slot:id>
            <x-slot:label>{{ $index + 7 }}. {{ $question }}</x-slot:label>
        </x-radio-button-choose>

            @endforeach

<x-subtitle>Kemerosotan emosi</x-subtitle>

            @foreach([
                'Di tempat kerja, saya rasa tidak mampu mengawal emosi saya.',
                'Saya tidak mengenali diri saya dalam cara saya bertindak balas secara emosi di tempat kerja.',
                'Di tempat kerja, saya mungkin bertindak secara berlebihan tanpa sengaja.',
            ] as $index => $question)

        <x-radio-button-choose :choose="8">
            <x-slot:id>H{{ $index + 10 }}</x-slot:id>
            <x-slot:label>{{ $index + 10 }}. {{ $question }}</x-slot:label>
        </x-radio-button-choose>

            @endforeach
<br>
<x-reference>
<x-slot:title>Rujukan</x-slot:title>
<x-slot:description><ol class="list-decimal list-inside mb-4">
    <li class="font-bold">
        Schaufeli, W., & De Witte, H. (2023). Burnout Assessment Tool (BAT) A fresh look at burnout. In International handbook of behavioral health assessment (pp. 1-24). Cham: Springer International Publishing.
    </li>
    <li>
        Hadžibajramović, E., Schaufeli, W., & De Witte, H. (2022). Shortening of the Burnout Assessment Tool (BAT)—from 23 to 12 items using content and Rasch analysis. BMC Public Health, 22(1), 560.
    </li>
    <li>The short version BAT12 fulfils the measurement criteria according to the Rasch model after accounting for local dependency between items within each subscale. The four subscales can be combined into a single burnout score.</li>
</ol></x-slot:description>
</x-reference>

<x-accordion>
    <x-slot:title>JUMLAH SKOR KELETIHAN:</x-slot:title>
    <x-slot:description><p class="text-red-500 font-bold">*paparan nilai min skor diperolehi (jumlah skor bahagi 8) dan status (rendah/sederhana/tinggi/sangat tinggi)</p><br>
<p class="text-red-500 font-bold ml-5">Rujukan julat min skor dan status:<br>
1.66 dan ke bawah (rendah)<br>
1.67 - 2.99 (sederhana)<br>
3.00 - 3.99 (tinggi)<br>
4.00 dan ke atas (sangat tinggi)
</p><br>
<p class="text-red-500 font-bold">
SARANAN: ____________
<ul class="list-disc text-red-500 font-bold ml-5">
    <li>Jika ‘rendah’, saranan: Walaupun anda tidak berada dalam keadaan keletihan yang teruk, penting untuk terus menjaga kesejahteraan secara keseluruhan seperti gaya hidup yang sihat, menguruskan stres dengan baik, dan memastikan keseimbangan antara kerja dan kehidupan.</li>
    <li>Jika ‘sederhana’, saranan: Anda mengalami tekanan atau keletihan pada tahap awal yang perlu ditangani dengan segera. Mengimbangi beban kerja, mengamalkan pengurusan stres yang lebih baik, dan menjaga kesejahteraan fizikal serta mental adalah langkah yang penting untuk mengurangkan kepenatan.</li>
    <li>Jika ‘tinggi’, saranan: Anda berada dalam risiko kepenatan yang tinggi dan memerlukan perhatian segera. Mengambil langkah-langkah seperti mendapatkan bantuan profesional, rehat dan tidur yang cukup, dan mengurangkan beban kerja serta pengurusan stres dalah langkah penting dalam menangani kepenatan ini. </li>
    <li>Jika ‘sangat tinggi’, saranan: Memndangkan anda mengalami tahap kepenatan yang sangat tinggi, adalah disarankan mendapatkan bantuan professional denga segera, berehat, mengurangkan beban kerja, dan amalkan teknik pengurusan stres. Sokongan sosial, tidur yang cukup, gaya hidup sihat, serta refleksi diri dan penetapan matlamat juga penting untuk pemulihan dan pencegahan burnout.</li>
</ul></x-slot:description>
</x-accordion>
<x-accordion>
    <x-slot:title>JUMLAH SKOR JARAK MENTAL: </x-slot:title>
    <x-slot:description><p class="text-red-500 font-bold">*paparan nilai min skor diperolehi (jumlah skor bahagi 5) dan status (rendah/sederhana/tinggi/sangat tinggi)</p><br>
<p class="text-red-500 font-bold ml-5">Rujukan julat min skor dan status:<br>
1.00 dan ke bawah (rendah)<br>
1.01 - 2.65 (sederhana)<br>
2.66 - 3.99 (tinggi)<br>
4.00 dan ke atas (sangat tinggi)
</p><br>
<p class="text-red-500 font-bold">
SARANAN: ____________
<ul class="list-disc text-red-500 font-bold ml-5">
    <li>Jika ‘rendah’, saranan: Anda mengalami keterikatan emosi yang kuat dengan kerja, yang boleh membawa kepada keletihan. Untuk mengatasinya, tetapkan batasan kerja, amalkan relaksasi, cari sokongan sosial, lakukan refleksi diri, dan dapatkan bantuan profesional jika perlu. Keseimbangan kerja-hidup adalah penting untuk kesejahteraan mental dan fizikal.</li>
    <li>Jika ‘sederhana’, saranan: Walaupun berada pada tahap awal burnout, adalah perlu untuk mengambil tindakan bagi mengatasi keadaan ini seperti pengurusan stres melalui teknik relaksasi, tidur yang berkualiti, pengurusan masa dan keseimbangan antara kerja dan kehidupan. Sokongan sosial, pengurusan emosi, dan aktiviti fizikal juga penting untuk memperbaiki keadaan mental. Rehat yang cukup dan pemakanan sihat turut membantu, bersama dengan pemantauan berkala terhadap tahap stres.</li>
    <li>Jika ‘tinggi’, saranan: Anda mengalami keletihan teruk dan tekanan mental yang tinggi. Justeru sokongan profesional yang berterusan, pengurusan stres intensif, rehat sepenuhnya, peningkatan kualiti tidur, pengurangan beban kerja, sokongan sosial yang kuat, keseimbangan kerja-hidup yang lebih baik, aktiviti fizikal dan rekreasi, pemakanan sihat, aktiviti menenangkan, dan peningkatan kesedaran diri adalah diperlukan pada waktu ini.</li>
    <li>Jika ‘sangat tinggi’, saranan: Anda mengalami tahap keletihan yang sangat serius dengan tekanan mental yang amat tinggi. Dapatkan sokongan profesional segera seperti pakar psikiatri atau kaunselor, rehat sepenuhnya dan cuti jangka panjang, pengurusan stres terapeutik, pemulihan melalui tidur yang berkualiti, pengurangan beban kerja dan tanggungjawab, peningkatan sokongan sosial yang kuat, aktiviti rekreasi dan fizikal, pemakanan sihat, aktiviti menenangkan, pemantauan kesedaran diri, dan perubahan gaya hidup secara menyeluruh dan sepenuhnya.</li>
</ul></x-slot:description>
</x-accordion>
<x-accordion>
    <x-slot:title>JUMLAH SKOR KEMEROSOTAN KOGNITIF:</x-slot:title>
    <x-slot:description><p class="text-red-500 font-bold">*paparan nilai min skor diperolehi (jumlah skor bahagi 5) dan status (rendah/sederhana/tinggi/sangat tinggi)</p><br>
<p class="text-red-500 font-bold ml-5">Rujukan julat min skor dan status:<br>
1.66 dan ke bawah (rendah)<br>
1.67 - 2.33 (sederhana)<br>
2.34 - 3.32 (tinggi)<br>
3.33 dan ke atas (sangat tinggi)
</p><br>
<p class="text-red-500 font-bold">
SARANAN: ____________
<ul class="list-disc text-red-500 font-bold ml-5">
    <li>Jika ‘rendah’, saranan: Anda tidak mengalami gangguan kognitif yang signifikan, tetapi mungkin berada pada tahap awal keletihan mental. Disarankan untuk meneruskan pengurusan stres, menjaga kualiti tidur, mengekalkan keseimbangan kerja-hidup, meningkatkan aktiviti fizikal dan mental, mengamalkan pemakanan sihat, mendapatkan sokongan sosial dan mengurus masa dengan lebih baik.</li>
    <li>Jika ‘sederhana’, saranan: Anda mengalami sedikit kesulitan kognitif akibat tekanan atau keletihan awal. Disarankan untuk mengamalkan pengurusan stres intensif, meningkatkan kualiti tidur dan rehat, mengurus masa dengan lebih baik, melakukan aktiviti fizikal, mengamalkan pemakanan seimbang, melakukan latihan kognitif, meningkatkan sokongan sosial dan mengurangkan beban kerja,</li>
    <li>Jika ‘tinggi’, saranan: Anda mengalami gangguan kognitif yang serius akibat keletihan mental berpanjangan. Anda memerlukan sokongan profesional segera seperti pakar psikologi atau psikiatri, peningkatan kualiti tidur yang kritikal, pengurusan stres yang mendalam, rehat penuh atau cuti, pengurangan beban kerja, sokongan sosial yang kuat, aktiviti fizikal dan mental serta diet seimbang melalui pemantauan berkala. Intervensi intensif dan perubahan gaya hidup menyeluruh diperlukan untuk pemulihan fungsi kognitif.</li>
    <li>Jika ‘sangat tinggi’, saranan: Anda mengalami gangguan kognitif serius akibat keletihan, dengan kesukaran dalam tumpuan, ingatan, dan pemprosesan maklumat. Anda perlu mendapatkan sokongan profesional segera seperti pakar psikologi atau psikiatri, rehat penuh dan pemulihan, pengurusan stres intensif, peningkatan kualiti tidur, sokongan sosial yang kuat, pengurangan beban kerja dan tanggungjawab, aktiviti fizikal yang teratur, diet sihat untuk sokongan otak, aktiviti mental untuk merangsang otak, serta peningkatan kesedaran diri dan pemantauan berkala. Intervensi yang cepat dan menyeluruh, sokongan profesional, dan perubahan gaya hidup yang ketara adalah penting untuk pemulihan kognitif yang berkesan.</li>
</ul></x-slot:description>
</x-accordion>
<x-accordion>
    <x-slot:title>JUMLAH SKOR KEMEROSOTAN EMOSI: </x-slot:title>
    <x-slot:description><p class="text-red-500 font-bold">*paparan nilai min skor diperolehi (jumlah skor bahagi 5) dan status (rendah/sederhana/tinggi/sangat tinggi)</p><br>
<p class="text-red-500 font-bold ml-5">Rujukan julat min skor dan status:<br>
1.00 dan ke bawah (rendah)<br>
1.01 - 2.00 (sederhana)<br>
2.01 - 3.00 (tinggi)<br>
3.01 dan ke atas(sangat tinggi)
</p><br>
<p class="text-red-500 font-bold">
SARANAN: ____________
<ul class="list-disc text-red-500 font-bold ml-5">
    <li>Jika ‘rendah’, saranan: Anda masih mampu menguruskan emosi dengan baik dan tidak mengalami kesan emosi yang ketara akibat keletihan atau tekanan. Walau bagaimanapun, untuk mengekalkan kestabilan emosi dan mencegah peningkatan kesan keletihan di masa hadapan, anda disarankan untuk mengamalkan pengurusan stres secara berterusan, melakukan aktiviti fizikal, menjaga keseimbangan kerja-hidup, melibatkan diri dalam aktiviti sosial dan rekreasi, memantau emosi secara berkala, menguruskan konflik dan cabaran secara positif, mengamalkan pemakanan sihat serta mendapatkan tidur yang cukup dan berkualiti.</li>
    <li>Jika ‘sederhana’, saranan: Anda mengalami kesukaran mengurus emosi akibat stres atau keletihan. Disarankan untuk mengamalkan pengurusan stres melalui meditasi dan relaksasi, meningkatkan kualiti tidur, terlibat dalam aktiviti sosial dan rekreasi, mengurus konflik secara positif, berkongsi perasaan, menetapkan matlamat realistik, melakukan aktiviti fizikal, meningkatkan kesedaran diri, mencari aktiviti menenangkan, dan mendapatkan sokongan profesional jika perlu. Langkah-langkah ini penting untuk mencegah gangguan emosi yang lebih serius dan meningkatkan kesejahteraan mental jangka panjang.</li>
    <li>Jika ‘tinggi’, saranan: Anda mengalami gangguan emosi yang signifikan akibat tekanan atau keletihan. Justeru sokongan profesional segera seperti kaunselor, ahli psikologi, atau psikiatri, pengurusan stres intensif, rehat sepenuhnya, peningkatan kualiti tidur, aktiviti fizikal yang menenangkan, sokongan sosial yang kuat, penetapan batasan yang sehat, aktiviti menenangkan, pengenalan dan pengurusan emosi yang berkesan adalah amat diperlukan untuk pemulihan sepenuhnya.</li>
    <li>Jika ‘sangat tinggi’, saranan: Anda mengalami gangguan emosi teruk akibat keletihan, menyebabkan sangat tertekan, cemas, atau tidak mampu menguruskan perasaan. Anda memerlukan sokongan profesional segera seperti kaunselor, ahli psikologi, atau psikiatri, rehat sepenuhnya, pengurusan stres intensif, peningkatan kualiti tidur, sokongan sosial yang kukuh, aktiviti fizikal menenangkan, teknik pengurusan emosi, batasan yang jelas, aktiviti menenangkan, dan pemantauan kesihatan emosi berkala. </li>
</ul></x-slot:description>
</x-accordion>
<x-accordion>
    <x-slot:title>JUMLAH SKOR KESELURUHAN BAT12: </x-slot:title>
    <x-slot:description><p class="text-red-500 font-bold">*paparan nilai min skor diperolehi (jumlah skor bahagi 5) dan status (rendah/sederhana/tinggi/sangat tinggi)</p><br>
<p class="text-red-500 font-bold ml-5">Rujukan julat min skor dan status:<br>
1.50 dan ke bawah (rendah)<br>
1.51 - 2.35 (sederhana)<br>
2.36- 3.17 (tinggi)<br>
3.18 dan ke atas(sangat tinggi)
</p><br>
<p class="text-red-500 font-bold">
SARANAN: ____________
<ul class="list-disc text-red-500 font-bold ml-5">
    <li>Jika ‘rendah’, saranan: Anda mungkin mengalami masalah keletihan, kesukaran menumpukan perhatian, dan prestasi kognitif yang terjejas. Anda memerlukan rehat berkala dan tidur yang berkualiti (7-9 jam),  mengenal pasti punca tekanan dan menguruskannya dengan baik, mengurangkan gangguan digital dan fizikal dengan memberikan fokus pada satu tugasan pada satu masa serta mengamalkan gaya hidup sihat dengan pemakanan seimbang, hidrasi yang mencukupi, dan aktiviti fizikal secara berkala. Selain itu, pihak pengurusan juga perlu menyemak beban kerja, memastikan persekitaran kerja yang kondusif, dan menyediakan program sokongan kesejahteraan untuk pekerja.</li>
    <li>Jika ‘sederhana’, saranan: Anda sedang mengalami cabaran yang boleh menjejaskan tahap keletihan, tumpuan, dan prestasi kognitif. Anda perlu mengenal pasti punca tekanan kerja dan kaedah menguruskannya, minta sokongan daripada penyelia atau rakan sekerja, jaga keseimbangan kerja dan hidup, mengatur rutin harian supaya tidak terbeban dan pantau emosi dan prestasi kerja secara berkala. Pihak pengurusan juga perlu memantau pekerja dan menyediakan sokongan awal untuk mencegah masalah ini daripada menjadi lebih serius, demi kesejahteraan dan produktiviti pekerja.</li>
    <li>Jika ‘tinggi’, saranan: Anda mungkin mengalami tahap burnout yang ketara dan berpotensi menjejaskan kesihatan fizikal, mental serta prestasi kerja. Anda perlu berbincang dengan penyelia/pengurusan mengenai beban kerja, disarankan mengambil cuti atau rehat untuk pemulihan, mendapatkan sokongan profesional (kaunseling), memfokuskan kepada kesejahteraan mental melalui senaman atau meditasi serta menjaga keseimbangan kerja-hidup dengan hadkan kerja di luar waktu pejabat.</li>
    <li>Jika ‘sangat tinggi’, saranan: Anda kemungkinan besar sedang mengalami burnout yang teruk dan memerlukan perhatian segera. Ini bukan lagi sekadar tekanan kerja biasa, tetapi satu tahap keletihan yang serius yang boleh menjejaskan kesihatan fizikal dan mental secara signifikan. Anda disarankan untuk mengambil cuti panjang dan rehat dari kerja untuk memulihkan diri, dapatkan bantuan profesional (kaunselor, ahli psikologi, atau ahli terapi) untuk strategi mengatasi burnout, dan nasihat doktor untuk kesihatan fizikal, berkomunikasi dengan pihak pengurusan/majikan untuk penyesuaian kerja sementara atau pelan kembali bekerja, kekalkan gaya hidup sihat (senaman, diet), kurangkan pendedahan kepada tekanan, dan libatkan diri dalam aktiviti menenangkan serta pertimbangkan untuk menilai semula matlamat kerjaya jika perlu. </li>
</ul></x-slot:description>
</x-accordion>


        </form>

        <x-navigation>
            <x-slot:active>8</x-slot:active>
            <x-slot:link1>/part-7</x-slot:link1>
            <x-slot:link2>/part-9</x-slot:link2>
        </x-navigation>
</x-layout>