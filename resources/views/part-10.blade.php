<x-layout>
            <x-steps>
    <x-slot:active>10</x-slot:active>
    </x-steps>
    <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-6">Bahagian J: Soal-selidik Muskuloskeletal Nordic (NMQ)</h1>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <p class="text-lg mb-4">Soal-selidik ini digunakan untuk menilai prevalensi kesakitan muskuloskeletal yang anda alami pada bahagian tubuh tertentu. Sila tandakan "Ya" atau "Tidak" berdasarkan pengalaman anda.</p>

        <form action="" method="POST">
            @csrf

            <h2 class="text-2xl font-semibold mb-4">Bahagian Tubuh yang Mengalami Sakit</h2>

            <div class="space-y-4 mb-6">
                @foreach([
                    'Leher',
                    'Bahu',
                    'Lengan',
                    'Punggung',
                    'Siku',
                    'Pergelangan tangan',
                    'Pinggang',
                    'Paha',
                    'Kaki'
                ] as $index => $body_part)
                <div class="flex items-center">
                    <label for="NMQ{{ $index }}" class="mr-4">{{ $body_part }}</label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="NMQ{{ $index }}" value="yes" class="mr-2" />
                        <span>Ya</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="NMQ{{ $index }}" value="no" class="mr-2" />
                        <span>Tidak</span>
                    </label>
                </div>
                @endforeach
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Berapa kerap anda mengalami sakit pada bahagian tubuh yang dinyatakan?</h2>

            <div class="space-y-4 mb-6">
                @foreach([
                    'Leher',
                    'Bahagian atas punggung',
                    'Bahu',
                    'Lengan',
                    'Siku',
                    'Punggung',
                    'Kaki',
                    'Pinggang'
                ] as $index => $body_part)
                <div class="flex items-center">
                    <label for="NMQF{{ $index }}" class="mr-4">{{ $body_part }}</label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="NMQF{{ $index }}" value="0" class="mr-2" />
                        <span>Tidak pernah</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="NMQF{{ $index }}" value="1" class="mr-2" />
                        <span>Jarang-jarang</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="NMQF{{ $index }}" value="2" class="mr-2" />
                        <span>Kerap</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="NMQF{{ $index }}" value="3" class="mr-2" />
                        <span>Sentiasa</span>
                    </label>
                </div>
                @endforeach
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Adakah kesakitan tersebut menyebabkan kesukaran dalam aktiviti harian anda?</h2>

            <div class="space-y-4 mb-6">
                @foreach([
                    'Leher',
                    'Bahagian atas punggung',
                    'Bahu',
                    'Lengan',
                    'Siku',
                    'Punggung',
                    'Kaki',
                    'Pinggang'
                ] as $index => $body_part)
                <div class="flex items-center">
                    <label for="NMQA{{ $index }}" class="mr-4">{{ $body_part }}</label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="NMQA{{ $index }}" value="yes" class="mr-2" />
                        <span>Ya</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="NMQA{{ $index }}" value="no" class="mr-2" />
                        <span>Tidak</span>
                    </label>
                </div>
                @endforeach
            </div>

            <div class="mt-6">
                   <br><br>
             <a href="/part-9" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600"><< Kembali</a>
        <a href="/part-11" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">Seterusnya>></a>
            </div>
        </form>
    </div>
</div>
</x-layout>