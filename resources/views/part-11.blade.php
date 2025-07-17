<x-layout>


<x-title-section>
<x-slot:title1>BAHAGIAN K: Soal-selidik Analisis Kerja (JAQ)</x-slot:title1>
<x-slot:title2>SECTION K: Job Analysis Questionnaire (JAQ)</x-slot:title2>
<x-slot:description>Soal Selidik Analisis Kerja (SSAK) ialah satu instrument berstruktur yang digunakan untuk mengumpul maklumat terperinci mengenai tugas, tanggungjawab, dan keperluan sesuatu pekerjaan. Ia merupakan satu pendekatan sistematik untuk memahami tugas, kemahiran, pengetahuan, dan kebolehan  yang diperlukan untuk melaksanakan sesuatu pekerjaan dengan berkesan.</x-slot:description>
</x-title-section>
        <form action="" method="POST">
            @csrf

            <h2 class="text-xl font-semibold mb-4">Ringkasan berkaitan pekerjaan</h2>
            <div class="mb-6">
                <label for="pekerjaan" class="block font-semibold">Secara amnya, pekerjaan saya ini adalah...</label>
                <input type="text" id="pekerjaan" name="pekerjaan" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <h2 class="font-semibold mt-6 mb-4">Syarat kelayakan minimum untuk pekerjaan ini yang anda tahu?
(tahap pendidikan, kercegasan fizikal, tinggi, berat, kemahiran bahasa, kesihatan, latihan khas dll)
</h2>
            <div class="space-y-4 mb-6">
                <textarea id="kelayakan" name="kelayakan" class="w-full p-2 border border-gray-300 rounded-md" rows="4" required></textarea>
            </div>

            <h2 class="font-semibold mt-6 mb-4">Senarai tugas utama anda?</h2>
            <div class="space-y-4 mb-6 flex flex-col flex-wrap md:flex-row gap-2 justify-center">
                @for ($i = 1; $i <= 15; $i++)
                <div class="flex flex-col border border-gray-300 shadow-lg md:w-[48%] rounded-2xl p-5 ">
                    <label for="tugas{{ $i }}">Tugas utama {{ $i }}:</label>
                    <input type="text" id="tugas{{ $i }}" name="tugas{{ $i }}" class="w-full p-2 border border-gray-300 rounded-md" required>
                    <label for="masa{{ $i }}" class="mt-2">Peruntukan masa (jam) sehari:</label>
                    <input type="number" id="masa{{ $i }}" name="masa{{ $i }}" class="w-full p-2 border border-gray-300 rounded-md" required>
                </div>
                @endfor
            </div>
            <div class="space-y-4 mb-6">
                    <x-radio-button :data="[1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10, 11=>11, 12=>12, 13=>13, 14=>14, 15=>15]">
                        <x-slot:id>mencabar</x-slot:id>
                        <x-slot:label><span class="font-semibold mt-6 mb-4">Apakah tugasan yang paling mencabar dari senarai ini? (pilih satu)</span></x-slot:label>
                    </x-radio-button>
            </div>

            <div class="space-y-4 mb-6">
                    <x-checkbox :data="[1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10, 11=>11, 12=>12, 13=>13, 14=>14, 15=>15]">
                        <x-slot:id>latihan</x-slot:id>
                        <x-slot:label><span class="font-semibold mt-6 mb-4">Tandakan tugasan yang dianggap sebagai latihan atau persediaan yang baik untuk pekerjaan anda ini? (boleh lebih dari satu)</span></x-slot:label>
                    </x-checkbox>
            </div>



            <div class="space-y-4 mb-6">
                    <x-checkbox :data="[1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10, 11=>11, 12=>12, 13=>13, 14=>14, 15=>15]">
                        <x-slot:id>sokongan</x-slot:id>
                        <x-slot:label><span class="font-semibold mt-6 mb-4">Tugasan mana (jika ada) yang menyediakan sokongan sandaran jika pekerja berkenaan tidak hadir?</span></x-slot:label>
                    </x-checkbox>
            </div>

            <h2 class="text-xl font-semibold mt-6 mb-4">Keperluan Pekerjaan</h2>
            <div class="mb-6">
                <label for="keperluan" class="font-semibold mt-6 mb-4">Apakah pendidikan/latihan yang diperlukan untuk layak sepenuhnya bagi pekerjaan ini? Jika ya, bagaimana pengetahuan/latihan ini biasanya diperolehi?</label>
                <textarea id="keperluan" name="keperluan" class="w-full p-2 border border-gray-300 rounded-md" rows="4" required></textarea>
            </div>

            <h2 class="font-semibold mt-6 mb-4">Apakah kemahiran/ pengetahuan khusus yang diperlukan untuk melaksanakan pekerjaan ini?</h2>
            <div class="mb-6">
                <textarea id="kemahiran" name="kemahiran" class="w-full p-2 border border-gray-300 rounded-md" rows="4" required></textarea>
            </div>

            <h2 class="text-xl font-semibold mt-6 mb-4">Tuntutan Mental</h2>
            <div class="mb-6">
                <label for="tuntutan_mental" class="block text-lg">Sila nyatakan tuntutan mental yang diperlukan dalam pekerjaan ini dari segi tahap konsentrasi dan tempoh usaha.</label>
                <textarea id="tuntutan_mental" name="tuntutan_mental" class="w-full p-2 border border-gray-300 rounded-md" rows="4" required></textarea>
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Tuntutan Fizikal</h2>
            <div class="mb-6">
                <label for="tuntutan_fizikal" class="block text-lg">Senaraikan tuntutan fizikal dalam tugasan kerja yang dilakukan mengikut tahap kekerapan.</label>
                <textarea id="tuntutan_fizikal" name="tuntutan_fizikal" class="w-full p-2 border border-gray-300 rounded-md" rows="4" required></textarea>
            </div>


        </form>

<x-reference>
<x-slot:title>Rujukan</x-slot:title>
<x-slot:description><ol class="list-decimal list-inside mb-4">
    <li>JAQ is a qualitative tool used to gather data about a job, rather than a quantitative tool with a scoring system. The information collected is used to make informed decisions about various aspects of the job and its classification.</li>
</ol></x-slot:description>
</x-reference><br>
<p class="text-red-500 font-bold">*Tiada paparan skor dan status ditunjukkan bagi bahagian ini. Data yang dikumpulkan akan dianalisa kemudian</p>

<x-navigation>
    <x-slot:active>11</x-slot:active>
    <x-slot:link1>/part-10</x-slot:link1>
    <x-slot:link2>/part-12</x-slot:link2>
</x-navigation>

</x-layout>