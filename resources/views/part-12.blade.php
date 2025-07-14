<x-layout>
            <x-steps>
    <x-slot:active>12</x-slot:active>
    </x-steps>
    <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-6">Bahagian L: Ujian Kecekapan Fizikal Individu (IPPT)</h1>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <p class="text-lg mb-4">Soal-selidik ini digunakan untuk menilai kecekapan fizikal anggota bomba berdasarkan ujian kecergasan yang dijalankan. Sila masukkan bilangan ulangan atau masa yang diperlukan bagi ujian berikut.</p>

        <form action="" method="POST">
            @csrf

            <h2 class="text-2xl font-semibold mb-4">Bangun Tubi (Bent Knee Sit-Up)</h2>

            <div class="mb-6">
                <label for="bangun_tubi" class="block text-lg">Bilangan dalam 1 minit:</label>
                <input type="number" id="bangun_tubi" name="bangun_tubi" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Lompat Jauh Berdiri (Standing Board Jump)</h2>

            <div class="mb-6">
                <label for="lompat_jauh" class="block text-lg">Jarak lompatan (cm):</label>
                <input type="number" id="lompat_jauh" name="lompat_jauh" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Mendagu (Pull-Up) bagi lelaki</h2>

            <div class="mb-6">
                <label for="mendagu_lelaki" class="block text-lg">Bilangan:</label>
                <input type="number" id="mendagu_lelaki" name="mendagu_lelaki" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Mendagu Condong (Inclined Pull-Up) bagi Wanita</h2>

            <div class="mb-6">
                <label for="mendagu_wanita" class="block text-lg">Bilangan:</label>
                <input type="number" id="mendagu_wanita" name="mendagu_wanita" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">4 X 10m Lari Ulang Alik (4 X 10m Shuttle Run)</h2>

            <div class="mb-6">
                <label for="lari_ulang_alik" class="block text-lg">Kiraan (saat):</label>
                <input type="number" id="lari_ulang_alik" name="lari_ulang_alik" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Larian 2.4km (2.4km Run)</h2>

            <div class="mb-6">
                <label for="lari_2_4km" class="block text-lg">Kiraan (minit, saat):</label>
                <input type="text" id="lari_2_4km" name="lari_2_4km" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <div class="mt-6">
                <a href="/part-11" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600"><< Kembali</a><button type="submit" class=" ml-10 px-10 bg-blue-600 text-white py-2 rounded-md">Hantar</button>
            </div>
        </form>
    </div>
</div>
</x-layout>