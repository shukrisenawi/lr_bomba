<x-layout>
            <x-steps>
    <x-slot:active>8</x-slot:active>
    </x-steps>
    <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-6">Bahagian H: Instrumen Penilaian Kepenatan (BAT)</h1>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <p class="text-lg mb-4">Soal-selidik ini digunakan untuk menilai tahap keletihan yang anda alami berdasarkan pelbagai komponen, termasuk keletihan mental, kemerosotan kognitif, dan emosi. Sila tandakan sejauh mana kenyataan berikut berlaku kepada anda.</p>

        <form action="" method="POST">
            @csrf

            <h2 class="text-2xl font-semibold mb-4">Keletihan</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="H1" value="0" class="mr-2" />
                    <span>Tidak pernah (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H1" value="1" class="mr-2" />
                    <span>Jarang sekali (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H1" value="2" class="mr-2" />
                    <span>Kadang-kadang (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H1" value="3" class="mr-2" />
                    <span>Selalu (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H1" value="4" class="mr-2" />
                    <span>Sentiasa (4)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Selepas seharian bekerja, saya sukar untuk memulihkan tenaga saya.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="H2" value="0" class="mr-2" />
                    <span>Tidak pernah (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H2" value="1" class="mr-2" />
                    <span>Jarang sekali (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H2" value="2" class="mr-2" />
                    <span>Kadang-kadang (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H2" value="3" class="mr-2" />
                    <span>Selalu (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H2" value="4" class="mr-2" />
                    <span>Sentiasa (4)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Di tempat kerja, saya rasa keletihan fizikal.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="H3" value="0" class="mr-2" />
                    <span>Tidak pernah (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H3" value="1" class="mr-2" />
                    <span>Jarang sekali (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H3" value="2" class="mr-2" />
                    <span>Kadang-kadang (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H3" value="3" class="mr-2" />
                    <span>Selalu (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H3" value="4" class="mr-2" />
                    <span>Sentiasa (4)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya sukar untuk mencari semangat untuk kerja saya.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="H4" value="0" class="mr-2" />
                    <span>Tidak pernah (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H4" value="1" class="mr-2" />
                    <span>Jarang sekali (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H4" value="2" class="mr-2" />
                    <span>Kadang-kadang (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H4" value="3" class="mr-2" />
                    <span>Selalu (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H4" value="4" class="mr-2" />
                    <span>Sentiasa (4)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya berasa sangat tidak suka terhadap pekerjaan saya.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="H5" value="0" class="mr-2" />
                    <span>Tidak pernah (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H5" value="1" class="mr-2" />
                    <span>Jarang sekali (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H5" value="2" class="mr-2" />
                    <span>Kadang-kadang (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H5" value="3" class="mr-2" />
                    <span>Selalu (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H5" value="4" class="mr-2" />
                    <span>Sentiasa (4)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya sinis tentang kerja saya memberi makna kepada orang lain.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="H6" value="0" class="mr-2" />
                    <span>Tidak pernah (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H6" value="1" class="mr-2" />
                    <span>Jarang sekali (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H6" value="2" class="mr-2" />
                    <span>Kadang-kadang (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H6" value="3" class="mr-2" />
                    <span>Selalu (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H6" value="4" class="mr-2" />
                    <span>Sentiasa (4)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya sukar untuk kekal fokus di tempat kerja.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="H7" value="0" class="mr-2" />
                    <span>Tidak pernah (0)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H7" value="1" class="mr-2" />
                    <span>Jarang sekali (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H7" value="2" class="mr-2" />
                    <span>Kadang-kadang (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H7" value="3" class="mr-2" />
                    <span>Selalu (3)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="H7" value="4" class="mr-2" />
                    <span>Sentiasa (4)</span>
                </label>
            </div>

            <div class="mt-6">
                     <br><br>
             <a href="/part-7" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600"><< Kembali</a>
        <a href="/part-9" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">Seterusnya>></a>
            </div>
        </form>
    </div>
</div>
</x-layout>