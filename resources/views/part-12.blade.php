<x-layout>

<x-title-section>
<x-slot:title1>BAHAGIAN L: Ujian Kecekapan Fizikal Individu (IPPT)</x-slot:title1>
<x-slot:title2>SECTION L: Individual Physical Proficiency Test (IPPT)</x-slot:title2>
<x-slot:description>Ujian Kecergasan Fizikal Individu (atau Individual Physical Proficiency Test, IPPT) merupakan penilaian direka khusus untuk anggota bomba. Ia menilai keupayaan fizikal yang diperlukan untuk melaksanakan tugas-tugas mencabar dalam operasi bomba, seperti kekuatan (mengangkat peralatan berat, memaksa masuk ke bangunan, dan membawa individu yang cedera), ketahanan (mengekalkan usaha fizikal dalam tempoh yang lama, terutama dalam situasi tekanan tinggi), ketangkasan (bergerak dengan cepat dan cekap di ruang sempit dan halangan) dan kecergasan kardiovaskular (mengekalkan kesihatan jantung dan paru-paru untuk menahan tuntutan fizikal kerja).</x-slot:description>
</x-title-section>

<br>
        <form action="" method="POST">
            @csrf
            <h2 class="text-xl font-semibold mb-4">Bangun Tubi (Bent Knee Sit-Up)</h2>

<img src="../img/L1.png" alt="Gambar" class="mx-auto max-h-[150px] mb-5">
            <div class="mb-6">
                <label for="bangun_tubi" class="block text-lg">Bilangan dalam 1 minit:</label>
                <input type="number" id="bangun_tubi" name="bangun_tubi" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <h2 class="text-xl font-semibold mt-6 mb-4">Lompat Jauh Berdiri (Standing Board Jump)</h2>

<img src="../img/L2.png" alt="Gambar" class="mx-auto max-h-[150px] mb-5">
            <div class="mb-6">
                <label for="lompat_jauh" class="block text-lg">Jarak lompatan (cm):</label>
                <input type="number" id="lompat_jauh" name="lompat_jauh" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <h2 class="text-xl font-semibold mt-6 mb-4">Mendagu (Pull-Up) bagi lelaki</h2>

<img src="../img/L3.png" alt="Gambar" class="mx-auto max-h-[150px] mb-5">
            <div class="mb-6">
                <label for="mendagu_lelaki" class="block text-lg">Bilangan:</label>
                <input type="number" id="mendagu_lelaki" name="mendagu_lelaki" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <h2 class="text-xl font-semibold mt-6 mb-4">Mendagu Condong (Inclined Pull-Up) bagi Wanita</h2>

<img src="../img/L4.png" alt="Gambar" class="mx-auto max-h-[150px] mb-5">
            <div class="mb-6">
                <label for="mendagu_wanita" class="block text-lg">Bilangan:</label>
                <input type="number" id="mendagu_wanita" name="mendagu_wanita" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <h2 class="text-xl font-semibold mt-6 mb-4">4 X 10m Lari Ulang Alik (4 X 10m Shuttle Run)</h2>

<img src="../img/L5.png" alt="Gambar" class="mx-auto max-h-[150px] mb-5">
            <div class="mb-6">
                <label for="lari_ulang_alik" class="block text-lg">Kiraan (saat):</label>
                <input type="number" id="lari_ulang_alik" name="lari_ulang_alik" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <h2 class="text-xl font-semibold mt-6 mb-4">Larian 2.4km (2.4km Run)</h2>

<img src="../img/L6.png" alt="Gambar" class="mx-auto max-h-[150px] mb-5">
            <div class="mb-6">
                <label for="lari_2_4km" class="block text-lg">Kiraan (minit, saat):</label>
                <input type="text" id="lari_2_4km" name="lari_2_4km" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

<p class="text-red-500 font-bold">*Tiada paparan skor dan status ditunjukkan bagi bahagian ini. Data yang dikumpulkan akan dianalisa kemudian</p>

<div class="mt-5">
<x-steps>
    <x-slot:active>12</x-slot:active>
</x-steps>


            <div class="mt-6">
                <a href="/part-11" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600"><< Kembali</a><button type="submit" class=" ml-10 px-10 bg-blue-600 text-white py-2 rounded-md">Hantar</button>
            </div>
        </form>
</x-layout>