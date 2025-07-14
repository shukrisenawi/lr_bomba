<x-layout>
            <x-steps>
    <x-slot:active>7</x-slot:active>
    </x-steps>
    <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-6">Bahagian G: Skala Kemurungan CES-D</h1>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <p class="text-lg mb-4">Soal-selidik ini digunakan untuk menilai simptom kemurungan dalam minggu lepas. Sila tandakan sejauh mana setiap kenyataan berikut berlaku kepada anda.</p>

        <form action="" method="POST">
            @csrf

            <h2 class="text-2xl font-semibold mb-4">Fikiran saya diganggu oleh hal yang selalunya tidak menggangu saya.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="G1" value="0" class="mr-2" />
                    <span>Jarang/Kurang dari 1 hari (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G1" value="1" class="mr-2" />
                    <span>Kadang-kadang/1-2 hari (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G1" value="2" class="mr-2" />
                    <span>Kerap kali/3-4 hari (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G1" value="3" class="mr-2" />
                    <span>Pada setiap masa/5-7 hari (3)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya tiada selera untuk makan.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="G2" value="0" class="mr-2" />
                    <span>Jarang/Kurang dari 1 hari (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G2" value="1" class="mr-2" />
                    <span>Kadang-kadang/1-2 hari (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G2" value="2" class="mr-2" />
                    <span>Kerap kali/3-4 hari (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G2" value="3" class="mr-2" />
                    <span>Pada setiap masa/5-7 hari (3)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya rasa saya tidak dapat menghapuskan perasaan tertekan walaupun dengan bantuan kawan-kawan saya.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="G3" value="0" class="mr-2" />
                    <span>Jarang/Kurang dari 1 hari (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G3" value="1" class="mr-2" />
                    <span>Kadang-kadang/1-2 hari (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G3" value="2" class="mr-2" />
                    <span>Kerap kali/3-4 hari (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G3" value="3" class="mr-2" />
                    <span>Pada setiap masa/5-7 hari (3)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya rasa saya sebaik orang lain.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="G4" value="3" class="mr-2" />
                    <span>Pada setiap masa/5-7 hari (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G4" value="2" class="mr-2" />
                    <span>Kerap kali/3-4 hari (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G4" value="1" class="mr-2" />
                    <span>Kadang-kadang/1-2 hari (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G4" value="0" class="mr-2" />
                    <span>Jarang/Kurang dari 1 hari (0)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya mempunyai masalah untuk menumpukan perhatian kepada kerja yang saya lakukan.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="G5" value="0" class="mr-2" />
                    <span>Jarang/Kurang dari 1 hari (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G5" value="1" class="mr-2" />
                    <span>Kadang-kadang/1-2 hari (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G5" value="2" class="mr-2" />
                    <span>Kerap kali/3-4 hari (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G5" value="3" class="mr-2" />
                    <span>Pada setiap masa/5-7 hari (3)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya rasa tertekan.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="G6" value="0" class="mr-2" />
                    <span>Jarang/Kurang dari 1 hari (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G6" value="1" class="mr-2" />
                    <span>Kadang-kadang/1-2 hari (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G6" value="2" class="mr-2" />
                    <span>Kerap kali/3-4 hari (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G6" value="3" class="mr-2" />
                    <span>Pada setiap masa/5-7 hari (3)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya rasa semua yang saya lakukan adalah satu usaha.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="G7" value="3" class="mr-2" />
                    <span>Pada setiap masa/5-7 hari (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G7" value="2" class="mr-2" />
                    <span>Kerap kali/3-4 hari (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G7" value="1" class="mr-2" />
                    <span>Kadang-kadang/1-2 hari (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G7" value="0" class="mr-2" />
                    <span>Jarang/Kurang dari 1 hari (0)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya rasa mempunyai harapan yang baik untuk masa depan saya.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="G8" value="3" class="mr-2" />
                    <span>Pada setiap masa/5-7 hari (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G8" value="2" class="mr-2" />
                    <span>Kerap kali/3-4 hari (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G8" value="1" class="mr-2" />
                    <span>Kadang-kadang/1-2 hari (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G8" value="0" class="mr-2" />
                    <span>Jarang/Kurang dari 1 hari (0)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya fikir hidup saya telah mengalami kegagalan.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="G9" value="0" class="mr-2" />
                    <span>Jarang/Kurang dari 1 hari (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G9" value="1" class="mr-2" />
                    <span>Kadang-kadang/1-2 hari (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G9" value="2" class="mr-2" />
                    <span>Kerap kali/3-4 hari (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G9" value="3" class="mr-2" />
                    <span>Pada setiap masa/5-7 hari (3)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya merasa sangat takut.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="G10" value="0" class="mr-2" />
                    <span>Jarang/Kurang dari 1 hari (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G10" value="1" class="mr-2" />
                    <span>Kadang-kadang/1-2 hari (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G10" value="2" class="mr-2" />
                    <span>Kerap kali/3-4 hari (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G10" value="3" class="mr-2" />
                    <span>Pada setiap masa/5-7 hari (3)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya gembira.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="G11" value="3" class="mr-2" />
                    <span>Pada setiap masa/5-7 hari (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G11" value="2" class="mr-2" />
                    <span>Kerap kali/3-4 hari (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G11" value="1" class="mr-2" />
                    <span>Kadang-kadang/1-2 hari (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="G11" value="0" class="mr-2" />
                    <span>Jarang/Kurang dari 1 hari (0)</span>
                </label>
            </div>

            <div class="mt-6">
                   <br><br>
             <a href="/part-6" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600"><< Kembali</a>
        <a href="/part-8" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">Seterusnya>></a>
            </div>
        </form>
    </div>
</div>
</x-layout>