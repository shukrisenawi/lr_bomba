<x-layout>
<x-title-section>
<x-slot:title1>BAHAGIAN B: Indek Kebolehan Bekerja</x-slot:title1>
<x-slot:title2>SECTION B: Work Ability Index (WAI)</x-slot:title2>
<x-slot:description>yang digunakan untuk menilai keupayaan seseorang dalam melakukan pekerjaan mereka. Indeks ini mengukur sejauh mana kemampuan seseorang menjalankan tugas-tugas pekerjaan harian sama ada secara fizikal mahupun mental serta bagaimana keadaan kesihatan mereka mempengaruhi kemampuan melaksanakan pekerjaan tersebut.</x-slot:description>
</x-title-section>


    <form action="" method="POST" class="max-w-4xl mx-auto space-y-6">
        @csrf
        <div class="space-y-4">
            <!-- Kebolehan Bekerja -->
            <div class="flex flex-col">
                <label for="work_ability" class="font-medium text-gray-700">1. Pada pandangan anda, sejauhmanakah kebolehan anda bekerja sekarang?</label>
                <input type="range" name="work_ability" id="work_ability" min="0" max="10" step="1" class="mt-2 w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                <div class="flex justify-between text-sm text-gray-600">
                    <span>0 = Tidak boleh bekerja langsung</span>
                    <span>10 = Boleh bekerja pada tahap terbaik</span>
                </div>
            </div>

            <x-radio-button-choose :choose="1">
                <x-slot:id>physical_demand</x-slot:id>
                <x-slot:label>2a. Bagaimana anda menilai kebolehan bekerja sekarang dengan tuntutan fizikal anda?</x-slot:label>
            </x-radio-button-choose>

            <x-radio-button-choose :choose="1">
                <x-slot:id>mental_demand</x-slot:id>
                <x-slot:label>2b. Bagaimana anda menilai kebolehan bekerja sekarang dengan tuntutan mental anda?</x-slot:label>
            </x-radio-button-choose>

            <x-radio-button :data="[7=>'Tiada', 5=>'1', 4=>'2', 3=>'3', 2=>'4', 1=>'5 dan lebih']">
                <x-slot:id>health_conditions</x-slot:id>
                <x-slot:label>3. Bilangan penyakit/masalah kesihatan yang anda alami sekarang yang telah disahkan oleh pegawai perubatan?</x-slot:label>
            </x-radio-button>

            <x-dropdown :data="[
                6=>'Tiada halangan / Saya tiada penyakit',
                5=>'Saya mampu membuat kerja saya, tapi ia menyebabkan timbul beberapa gejala/simptom',
                4=>'Saya kadang-kala perlu memperlahankan rentak kerja saya atau mengubah kaedah kerja saya',
                3=>'Saya sering perlu memperlahankan rentak kerja saya atau menukar kaedah kerja saya',
                2=>'Disebabkan keadaan saya, saya rasa saya hanya mampu melakukan kerja separuh masa',
                1=>'Pada pendapat saya, saya langsung tidak mampu untuk bekerja']">
                <x-slot:id>work_interference</x-slot:id>
                <x-slot:label>4. Adakah penyakit/masalah kesihatan mengganggu kerja anda sekarang?</x-slot:label>
            </x-dropdown>

            <x-radio-button :data="[ 5=>'Tiada', 4=>'Maksimum 9 hari', 3=>'10-24 hari', 2=>'25-99 hari', 1=>'100-354 hari']">
                <x-slot:id>days_off</x-slot:id>
                <x-slot:label>5. Berapa hari anda tidak bekerja dalam tempoh 12 bulan yang lalu kerana penyakit/masalah kesihatan yang anda alami?</x-slot:label>
            </x-radio-button>

            <x-radio-button :data="[ 1=>'Tidak mungkin', 4=>'Tidak pasti', 7=>'Agak pasti']">
                <x-slot:id>future_ability</x-slot:id>
                <x-slot:label>6. Adakah anda percaya bahawa penyakit/masalah kesihatan yang anda sedang alami sekarang, anda masih dapat melakukan pekerjaan anda untuk tempoh dua tahun lagi?</x-slot:label>
            </x-radio-button>

            <x-radio-button-choose :choose="2">
                <x-slot:id>daily_activities</x-slot:id>
                <x-slot:label>7a. Merujuk pada 3 bulan lepas, adakah anda dapat menikmati aktiviti harian biasa anda?</x-slot:label>
            </x-radio-button-choose>

            <x-radio-button-choose :choose="2">
                <x-slot:id>physical_activity</x-slot:id>
                <x-slot:label>7b. Merujuk pada 3 bulan lepas, adakah anda aktif dan cergas?</x-slot:label>
            </x-radio-button-choose>

            <x-radio-button-choose :choose="2">
                <x-slot:id>future_hope</x-slot:id>
                <x-slot:label>7c. Merujuk pada 3 bulan lepas, adakah anda merasa penuh harapan untuk masa depan?</x-slot:label>
            </x-radio-button-choose>

        </div>
<x-reference>
<x-slot:title>Rujukan</x-slot:title>
<x-slot:description><ol class="list-decimal list-inside mb-4">
    <li>Athanasou, J. (2024). Introduction to the Work Ability Index—A Guide for Rehabilitation Practitioners. Qeios, 1-17.<br>The coefficient alphas ranged from.573 to.9 with a median of.724 and a mean of.736 (95% CI=.027).</li>
    <li>Lavasani, Seyed & Wahiza, Nor. (2016). Work Ability Index: Validation and Model Comparison of the Malaysian Work Ability Index (WAI). Disability, CBR & Inclusive Development. 27. 37. 10.5463/dcid.v27i2.427.<br>This study has provided the first Malay version of WAI and has paved the way for future studies</li>
</ol></x-slot:description>
</x-reference>
<x-accordion>
    <x-slot:title>JUMLAH SKOR WAI :</x-slot:title>
    <x-slot:description><p class="font-bold text-red-500">
    *paparan nilai sebenar skor diperolehi dan status (lemah/sederhana/baik/cemerlang)
<br>

Rujukan julat skor dan status:<br>
6-27 Lemah &nbsp;&nbsp;&nbsp; 28-36 Sederhana  &nbsp;&nbsp;&nbsp; 37-43 Baik  &nbsp;&nbsp;&nbsp;  44-49 Cemerlang
<br><br>
SARANAN: ____________
<ul class="list-disc mx-10 text-red-500 font-bold">
    <li>Jika ‘Lemah’, saranan: Anda perlu memberikan perhatian kepada aspek penjagaan kesihatan fizikal dan mental, mengikuti lebih banyak latihan berkaitan kerja serta memberikan komitmen sepenuhnya kepada tanggungjawab kerja,</li>
    <li>Jika ‘Sederhana’, saranan: Anda perlu meningkatkan keupayaan kerja dari aspek latihan fizikal dan kemahiran teknikal yang komprehensif serta pengurusan mental dan emosi yang lebih baik.</li>
    <li>Jika ‘Baik’, saranan: Tahniah atas keupayaan kerja anda yang baik. Kekalkan pencapaian ini atau boleh terus berusaha untuk meningkatkan potensi dan pengembangan diri dengan lebih baik dalam pekerjaan.</li>
    <li>Jika ‘Cemerlang’, saranan: Tahniah atas keupayaan kerja anda yang cemerlang. Kekalkan pencapaian ini disamping boleh membantu rakan sekerja untuk meningkatkan potensi dan pengembangan diri mereka dalam pekerjaan.</li>
</ul></x-slot:description>
</x-accordion>


</p>
        <x-navigation>
            <x-slot:active>2</x-slot:active>
            <x-slot:link1>/part-1</x-slot:link1>
            <x-slot:link2>/part-3</x-slot:link2>
        </x-navigation>

    </form>
</x-layout>