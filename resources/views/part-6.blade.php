<x-layout>
            <x-steps>
    <x-slot:active>6</x-slot:active>
    </x-steps>
    <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-6">Bahagian F: Skala Kemurungan Psikologikal Kessler 6 (K6+)</h1>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <p class="text-lg mb-4">Soal-selidik ini digunakan untuk menilai tahap kesulitan yang dihadapi dalam 30 hari yang lalu. Sila tandakan sejauh mana setiap kenyataan ini berlaku kepada anda.</p>

        <form action="" method="POST">
            @csrf

            <h2 class="text-2xl font-semibold mb-4">Berapa kerap anda merasa gugup?</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="F1" value="0" class="mr-2" />
                    <span>Tidak pernah (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F1" value="1" class="mr-2" />
                    <span>Jarang-jarang (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F1" value="2" class="mr-2" />
                    <span>Kadang-kadang (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F1" value="3" class="mr-2" />
                    <span>Kerap (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F1" value="4" class="mr-2" />
                    <span>Sepanjang masa (4)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Berapa kerap anda merasa putus asa?</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="F2" value="0" class="mr-2" />
                    <span>Tidak pernah (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F2" value="1" class="mr-2" />
                    <span>Jarang-jarang (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F2" value="2" class="mr-2" />
                    <span>Kadang-kadang (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F2" value="3" class="mr-2" />
                    <span>Kerap (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F2" value="4" class="mr-2" />
                    <span>Sepanjang masa (4)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Berapa kerap anda merasa gelisah atau tidak tenteram?</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="F3" value="0" class="mr-2" />
                    <span>Tidak pernah (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F3" value="1" class="mr-2" />
                    <span>Jarang-jarang (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F3" value="2" class="mr-2" />
                    <span>Kadang-kadang (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F3" value="3" class="mr-2" />
                    <span>Kerap (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F3" value="4" class="mr-2" />
                    <span>Sepanjang masa (4)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Berapa kerap anda merasa begitu tertekan sehingga tiada apa yang dapat menggembirakan anda?</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="F4" value="0" class="mr-2" />
                    <span>Tidak pernah (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F4" value="1" class="mr-2" />
                    <span>Jarang-jarang (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F4" value="2" class="mr-2" />
                    <span>Kadang-kadang (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F4" value="3" class="mr-2" />
                    <span>Kerap (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F4" value="4" class="mr-2" />
                    <span>Sepanjang masa (4)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Berapa kerap anda merasa bahawa segala-galanya adalah usaha?</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="F5" value="0" class="mr-2" />
                    <span>Tidak pernah (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F5" value="1" class="mr-2" />
                    <span>Jarang-jarang (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F5" value="2" class="mr-2" />
                    <span>Kadang-kadang (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F5" value="3" class="mr-2" />
                    <span>Kerap (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F5" value="4" class="mr-2" />
                    <span>Sepanjang masa (4)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Berapa kerap anda merasa tidak berharga?</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="F6" value="0" class="mr-2" />
                    <span>Tidak pernah (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F6" value="1" class="mr-2" />
                    <span>Jarang-jarang (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F6" value="2" class="mr-2" />
                    <span>Kadang-kadang (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F6" value="3" class="mr-2" />
                    <span>Kerap (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="F6" value="4" class="mr-2" />
                    <span>Sepanjang masa (4)</span>
                </label>
            </div>

            <div class="mt-6">
                 <br><br>
             <a href="/part-5" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600"><< Kembali</a>
        <a href="/part-7" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">Seterusnya>></a>
            </div>
        </form>
    </div>
</div>
</x-layout>