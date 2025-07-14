<x-layout>
            <x-steps>
    <x-slot:active>9</x-slot:active>
    </x-steps>
    <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-6">Bahagian I: Rapid Entire Body Assessment (REBA)</h1>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <p class="text-lg mb-4">Penilaian ini digunakan untuk menilai risiko gangguan muskuloskeletal (MSD) berdasarkan postur dan tugas berulang. Sila pilih sejauh mana setiap kenyataan ini menggambarkan keadaan anda semasa bekerja.</p>

        <form action="" method="POST">
            @csrf

            <h2 class="text-2xl font-semibold mb-4">Keletihan</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="I1" value="1" class="mr-2" />
                    <span>Risiko sangat rendah (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I1" value="2" class="mr-2" />
                    <span>Risiko rendah (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I1" value="4" class="mr-2" />
                    <span>Risiko sederhana (4)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I1" value="6" class="mr-2" />
                    <span>Risiko tinggi (6)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I1" value="8" class="mr-2" />
                    <span>Risiko sangat tinggi (8)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Selepas seharian bekerja, saya sukar untuk memulihkan tenaga saya.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="I2" value="1" class="mr-2" />
                    <span>Risiko sangat rendah (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I2" value="2" class="mr-2" />
                    <span>Risiko rendah (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I2" value="4" class="mr-2" />
                    <span>Risiko sederhana (4)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I2" value="6" class="mr-2" />
                    <span>Risiko tinggi (6)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I2" value="8" class="mr-2" />
                    <span>Risiko sangat tinggi (8)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Di tempat kerja, saya rasa keletihan fizikal.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="I3" value="1" class="mr-2" />
                    <span>Risiko sangat rendah (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I3" value="2" class="mr-2" />
                    <span>Risiko rendah (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I3" value="4" class="mr-2" />
                    <span>Risiko sederhana (4)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I3" value="6" class="mr-2" />
                    <span>Risiko tinggi (6)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I3" value="8" class="mr-2" />
                    <span>Risiko sangat tinggi (8)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya sukar untuk mencari semangat untuk kerja saya.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="I4" value="1" class="mr-2" />
                    <span>Risiko sangat rendah (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I4" value="2" class="mr-2" />
                    <span>Risiko rendah (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I4" value="4" class="mr-2" />
                    <span>Risiko sederhana (4)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I4" value="6" class="mr-2" />
                    <span>Risiko tinggi (6)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I4" value="8" class="mr-2" />
                    <span>Risiko sangat tinggi (8)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya berasa sangat tidak suka terhadap pekerjaan saya.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="I5" value="1" class="mr-2" />
                    <span>Risiko sangat rendah (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I5" value="2" class="mr-2" />
                    <span>Risiko rendah (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I5" value="4" class="mr-2" />
                    <span>Risiko sederhana (4)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I5" value="6" class="mr-2" />
                    <span>Risiko tinggi (6)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I5" value="8" class="mr-2" />
                    <span>Risiko sangat tinggi (8)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya sinis tentang kerja saya memberi makna kepada orang lain.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="I6" value="1" class="mr-2" />
                    <span>Risiko sangat rendah (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I6" value="2" class="mr-2" />
                    <span>Risiko rendah (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I6" value="4" class="mr-2" />
                    <span>Risiko sederhana (4)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I6" value="6" class="mr-2" />
                    <span>Risiko tinggi (6)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I6" value="8" class="mr-2" />
                    <span>Risiko sangat tinggi (8)</span>
                </label>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Saya sukar untuk kekal fokus di tempat kerja.</h2>

            <div class="flex items-center space-x-4 mb-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="I7" value="1" class="mr-2" />
                    <span>Risiko sangat rendah (1)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I7" value="2" class="mr-2" />
                    <span>Risiko rendah (2)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I7" value="4" class="mr-2" />
                    <span>Risiko sederhana (4)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I7" value="6" class="mr-2" />
                    <span>Risiko tinggi (6)</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="I7" value="8" class="mr-2" />
                    <span>Risiko sangat tinggi (8)</span>
                </label>
            </div>

            <div class="mt-6">
                    <br><br>
             <a href="/part-8" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600"><< Kembali</a>
        <a href="/part-10" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">Seterusnya>></a>
            </div>
        </form>
    </div>
</div>
</x-layout>