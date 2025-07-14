<x-layout>
            <x-steps>
    <x-slot:active>11</x-slot:active>
    </x-steps>
    <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-6">Bahagian K: Soal-selidik Analisis Kerja (JAQ)</h1>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <p class="text-lg mb-4">Soal-selidik ini digunakan untuk mengumpul maklumat terperinci mengenai tugas, tanggungjawab, dan keperluan pekerjaan anda. Sila isikan maklumat yang diperlukan di bawah.</p>

        <form action="" method="POST">
            @csrf

            <h2 class="text-2xl font-semibold mb-4">Ringkasan berkaitan pekerjaan</h2>
            <div class="mb-6">
                <label for="pekerjaan" class="block text-lg">Secara amnya, pekerjaan saya ini adalah...</label>
                <input type="text" id="pekerjaan" name="pekerjaan" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Syarat kelayakan minimum untuk pekerjaan ini yang anda tahu</h2>
            <div class="space-y-4 mb-6">
                <label for="kelayakan" class="block text-lg">Tahap pendidikan, kecergasan fizikal, tinggi, berat, kemahiran bahasa, kesihatan, latihan khas dll</label>
                <textarea id="kelayakan" name="kelayakan" class="w-full p-2 border border-gray-300 rounded-md" rows="4" required></textarea>
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Senarai tugas utama anda</h2>
            <div class="space-y-4 mb-6">
                @for ($i = 1; $i <= 5; $i++)
                <div class="flex flex-col">
                    <label for="tugas{{ $i }}" class="text-lg">Tugas utama {{ $i }}:</label>
                    <input type="text" id="tugas{{ $i }}" name="tugas{{ $i }}" class="w-full p-2 border border-gray-300 rounded-md" required>
                    <label for="masa{{ $i }}" class="mt-2 text-lg">Peruntukan masa (jam) sehari:</label>
                    <input type="number" id="masa{{ $i }}" name="masa{{ $i }}" class="w-full p-2 border border-gray-300 rounded-md" required>
                </div>
                @endfor
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Apakah tugasan yang paling mencabar dari senarai ini? (pilih satu)</h2>
            <div class="space-y-4 mb-6">
                @for ($i = 1; $i <= 5; $i++)
                    <div class="flex items-center">
                        <input type="radio" id="mencabar{{ $i }}" name="mencabar" value="{{ $i }}" class="mr-2" />
                        <label for="mencabar{{ $i }}" class="text-lg">Tugas utama {{ $i }}</label>
                    </div>
                @endfor
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Tandakan tugasan yang dianggap sebagai latihan atau persediaan yang baik untuk pekerjaan anda ini (boleh lebih dari satu)</h2>
            <div class="space-y-4 mb-6">
                @for ($i = 1; $i <= 5; $i++)
                    <div class="flex items-center">
                        <input type="checkbox" id="latihan{{ $i }}" name="latihan[]" value="{{ $i }}" class="mr-2" />
                        <label for="latihan{{ $i }}" class="text-lg">Tugas utama {{ $i }}</label>
                    </div>
                @endfor
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Tugasan mana (jika ada) yang menyediakan sokongan sandaran jika pekerja berkenaan tidak hadir?</h2>
            <div class="space-y-4 mb-6">
                @for ($i = 1; $i <= 5; $i++)
                    <div class="flex items-center">
                        <input type="checkbox" id="sokongan{{ $i }}" name="sokongan[]" value="{{ $i }}" class="mr-2" />
                        <label for="sokongan{{ $i }}" class="text-lg">Tugas utama {{ $i }}</label>
                    </div>
                @endfor
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Keperluan Pekerjaan</h2>
            <div class="mb-6">
                <label for="keperluan" class="block text-lg">Apakah pendidikan/latihan yang diperlukan untuk layak sepenuhnya bagi pekerjaan ini? Jika ya, bagaimana pengetahuan/latihan ini biasanya diperolehi?</label>
                <textarea id="keperluan" name="keperluan" class="w-full p-2 border border-gray-300 rounded-md" rows="4" required></textarea>
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Kemahiran/Pengetahuan yang diperlukan untuk melaksanakan pekerjaan ini</h2>
            <div class="mb-6">
                <label for="kemahiran" class="block text-lg">Senaraikan kemahiran atau pengetahuan yang diperlukan</label>
                <textarea id="kemahiran" name="kemahiran" class="w-full p-2 border border-gray-300 rounded-md" rows="4" required></textarea>
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Tuntutan Mental</h2>
            <div class="mb-6">
                <label for="tuntutan_mental" class="block text-lg">Sila nyatakan tuntutan mental yang diperlukan dalam pekerjaan ini dari segi tahap konsentrasi dan tempoh usaha.</label>
                <textarea id="tuntutan_mental" name="tuntutan_mental" class="w-full p-2 border border-gray-300 rounded-md" rows="4" required></textarea>
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Tuntutan Fizikal</h2>
            <div class="mb-6">
                <label for="tuntutan_fizikal" class="block text-lg">Senaraikan tuntutan fizikal dalam tugasan kerja yang dilakukan mengikut tahap kekerapan.</label>
                <textarea id="tuntutan_fizikal" name="tuntutan_fizikal" class="w-full p-2 border border-gray-300 rounded-md" rows="4" required></textarea>
            </div>

            <div class="mt-6">
                   <br><br>
             <a href="/part-10" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600"><< Kembali</a>
        <a href="/part-12" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">Seterusnya>></a>
            </div>
        </form>
    </div>
</div>
</x-layout>