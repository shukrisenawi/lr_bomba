<x-layout>
        <x-steps>
    <x-slot:active>4</x-slot:active>
    </x-steps>
    <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-6">Bahagian D: Impak Latihan di Tempat Kerja</h1>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <p class="text-lg mb-4">Soal-selidik ini digunakan untuk menilai impak latihan yang telah dijalankan terhadap prestasi kerja anda. Sila tandakan sejauh mana setiap kenyataan berikut berlaku kepada anda.</p>

        <form action="" method="POST">
            @csrf

            <h2 class="text-2xl font-semibold mb-4">Kualiti kerja saya telah bertambah baik</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="D1" value="1" class="mr-2" />
                    <span>Sangat tidak setuju (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D1" value="2" class="mr-2" />
                    <span>Tidak setuju (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D1" value="3" class="mr-2" />
                    <span>Tidak pasti (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D1" value="4" class="mr-2" />
                    <span>Setuju (4)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D1" value="5" class="mr-2" />
                    <span>Sangat setuju (5)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya membuat sedikit kesilapan di tempat kerja</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="D2" value="1" class="mr-2" />
                    <span>Sangat tidak setuju (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D2" value="2" class="mr-2" />
                    <span> Tidak setuju (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D2" value="3" class="mr-2" />
                    <span>Tidak pasti (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D2" value="4" class="mr-2" />
                    <span>Setuju (4)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D2" value="5" class="mr-2" />
                    <span>Sangat setuju (5)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya melakukan kerja saya dengan lebih cepat</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="D3" value="1" class="mr-2" />
                    <span>Sangat tidak setuju (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D3" value="2" class="mr-2" />
                    <span> Tidak setuju (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D3" value="3" class="mr-2" />
                    <span>Tidak pasti (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D3" value="4" class="mr-2" />
                    <span>Setuju (4)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D3" value="5" class="mr-2" />
                    <span>Sangat setuju (5)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Keyakinan diri saya telah meningkat</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="D4" value="1" class="mr-2" />
                    <span>Sangat tidak setuju (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D4" value="2" class="mr-2" />
                    <span> Tidak setuju (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D4" value="3" class="mr-2" />
                    <span>Tidak pasti (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D4" value="4" class="mr-2" />
                    <span>Setuju (4)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D4" value="5" class="mr-2" />
                    <span>Sangat setuju (5)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Motivasi saya untuk bekerja telah bertambah baik</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="D5" value="1" class="mr-2" />
                    <span>Sangat tidak setuju (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D5" value="2" class="mr-2" />
                    <span> Tidak setuju (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D5" value="3" class="mr-2" />
                    <span>Tidak pasti (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D5" value="4" class="mr-2" />
                    <span>Setuju (4)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D5" value="5" class="mr-2" />
                    <span>Sangat setuju (5)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Kualiti kerja saya yang tidak berkaitan dengan kursus telah bertambah baik</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="D6" value="1" class="mr-2" />
                    <span>Sangat tidak setuju (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D6" value="2" class="mr-2" />
                    <span> Tidak setuju (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D6" value="3" class="mr-2" />
                    <span>Tidak pasti (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D6" value="4" class="mr-2" />
                    <span>Setuju (4)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D6" value="5" class="mr-2" />
                    <span>Sangat setuju (5)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya mencadangkan perubahan rutin kerja yang lebih kerap</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="D7" value="1" class="mr-2" />
                    <span>Sangat tidak setuju (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D7" value="2" class="mr-2" />
                    <span> Tidak setuju (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D7" value="3" class="mr-2" />
                    <span>Tidak pasti (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D7" value="4" class="mr-2" />
                    <span>Setuju (4)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D7" value="5" class="mr-2" />
                    <span>Sangat setuju (5)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya sering menggunakan kemahiran yang dipelajari semasa latihan</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="D8" value="1" class="mr-2" />
                    <span>Sangat tidak setuju (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D8" value="2" class="mr-2" />
                    <span> Tidak setuju (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D8" value="3" class="mr-2" />
                    <span>Tidak pasti (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D8" value="4" class="mr-2" />
                    <span>Setuju (4)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D8" value="5" class="mr-2" />
                    <span>Sangat setuju (5)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya berasa lebih terbuka kepada perubahan</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="D9" value="1" class="mr-2" />
                    <span>Sangat tidak setuju (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D9" value="2" class="mr-2" />
                    <span> Tidak setuju (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D9" value="3" class="mr-2" />
                    <span>Tidak pasti (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D9" value="4" class="mr-2" />
                    <span>Setuju (4)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D9" value="5" class="mr-2" />
                    <span>Sangat setuju (5)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya mengambil kesempatan untuk mempraktikkan kemahiran baharu yang saya pelajari</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="D10" value="1" class="mr-2" />
                    <span>Sangat tidak setuju (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D10" value="2" class="mr-2" />
                    <span> Tidak setuju (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D10" value="3" class="mr-2" />
                    <span>Tidak pasti (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D10" value="4" class="mr-2" />
                    <span>Setuju (4)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="D10" value="5" class="mr-2" />
                    <span>Sangat setuju (5)</span>
                </label>
            </div>

            <div class="mt-6">
               <br><br>
             <a href="/part-3" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600"><< Kembali</a>
        <a href="/part-5" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">Seterusnya>></a>
            </div>
        </form>
    </div>
</div>
</x-layout>