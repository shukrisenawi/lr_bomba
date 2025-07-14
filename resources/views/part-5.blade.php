<x-layout>
            <x-steps>
    <x-slot:active>5</x-slot:active>
    </x-steps>
    <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-6">Bahagian E: Soal-selidik Prestasi Kerja Individu (IWPQ)</h1>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <p class="text-lg mb-4">Soal-selidik ini digunakan untuk menilai prestasi kerja anda berdasarkan beberapa dimensi seperti prestasi tugas, prestasi konteksual, dan tingkah laku kerja kontraproduktif. Sila nyatakan sejauh mana kenyataan-kenyataan ini berlaku kepada anda dalam 3 bulan yang lepas.</p>

        <form action="" method="POST">
            @csrf

            <h2 class="text-2xl font-semibold mb-4">Prestasi Tugas</h2>

            <div class="space-y-4 mb-6">
                @foreach([
                    'Saya dapat merancang kerja saya supaya saya dapat menyelesaikannya tepat pada waktunya',
                    'Saya ingat hasil kerja yang perlu saya capai',
                    'Saya dapat menetapkan keutamaan',
                    'Saya dapat melaksanakan kerja saya dengan cekap',
                    'Saya menguruskan masa saya dengan baik'
                ] as $index => $question)
                <div class="flex flex-col">
                    <label for="E{{ $index + 1 }}" class="mb-2">{{ $question }}</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" id="E{{ $index + 1 }}" name="E{{ $index + 1 }}" value="0" class="mr-2" />
                            <span>Jarang Sekali (0)</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="E{{ $index + 1 }}" name="E{{ $index + 1 }}" value="1" class="mr-2" />
                            <span>Jarang (1)</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="E{{ $index + 1 }}" name="E{{ $index + 1 }}" value="2" class="mr-2" />
                            <span>Kadang-kadang (2)</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="E{{ $index + 1 }}" name="E{{ $index + 1 }}" value="3" class="mr-2" />
                            <span>Selalu (3)</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="E{{ $index + 1 }}" name="E{{ $index + 1 }}" value="4" class="mr-2" />
                            <span>Sentiasa (4)</span>
                        </label>
                    </div>
                </div>
                @endforeach
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Prestasi Konteksual</h2>

            <div class="space-y-4 mb-6">
                @foreach([
                    'Atas inisiatif saya sendiri, saya memulakan tugas baharu apabila tugas lama saya selesai',
                    'Saya mengambil tugas yang mencabar apabila ia tersedia',
                    'Saya berusaha mengemas kini pengetahuan berkaitan pekerjaan saya',
                    'Saya berusaha mengemas kini kemahiran kerja saya',
                    'Saya menghasilkan penyelesaian kreatif untuk masalah baharu',
                    'Saya mengambil tanggungjawab tambahan',
                    'Saya sentiasa mencari cabaran baharu dalam kerja saya',
                    'Saya aktif mengambil bahagian dalam mesyuarat dan/atau perundingan'
                ] as $index => $question)
                <div class="flex flex-col">
                    <label for="E{{ $index + 6 }}" class="mb-2">{{ $question }}</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" id="E{{ $index + 6 }}" name="E{{ $index + 6 }}" value="0" class="mr-2" />
                            <span>Jarang Sekali (0)</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="E{{ $index + 6 }}" name="E{{ $index + 6 }}" value="1" class="mr-2" />
                            <span>Jarang (1)</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="E{{ $index + 6 }}" name="E{{ $index + 6 }}" value="2" class="mr-2" />
                            <span>Kadang-kadang (2)</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="E{{ $index + 6 }}" name="E{{ $index + 6 }}" value="3" class="mr-2" />
                            <span>Selalu (3)</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="E{{ $index + 6 }}" name="E{{ $index + 6 }}" value="4" class="mr-2" />
                            <span>Sentiasa (4)</span>
                        </label>
                    </div>
                </div>
                @endforeach
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Perilaku Kerja Tidak Produktif</h2>

            <div class="space-y-4 mb-6">
                @foreach([
                    'Saya mengadu mengenai isu-isu kecil berkaitan kerja di tempat kerja',
                    'Saya memperbesarkan masalah di tempat kerja melebihi sepatutnya',
                    'Saya lebih fokus pada aspek negatif situasi di tempat kerja berbanding aspek positifnya',
                    'Saya bercakap dengan rakan sekerja tentang aspek negatif kerja saya',
                    'Saya bercakap dengan orang di luar organisasi tentang aspek negatif kerja saya'
                ] as $index => $question)
                <div class="flex flex-col">
                    <label for="E{{ $index + 14 }}" class="mb-2">{{ $question }}</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" id="E{{ $index + 14 }}" name="E{{ $index + 14 }}" value="4" class="mr-2" />
                            <span>Tidak pernah (4)</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="E{{ $index + 14 }}" name="E{{ $index + 14 }}" value="3" class="mr-2" />
                            <span>Jarang (3)</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="E{{ $index + 14 }}" name="E{{ $index + 14 }}" value="2" class="mr-2" />
                            <span>Kadang-kadang (2)</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="E{{ $index + 14 }}" name="E{{ $index + 14 }}" value="1" class="mr-2" />
                            <span>Selalu (1)</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="E{{ $index + 14 }}" name="E{{ $index + 14 }}" value="0" class="mr-2" />
                            <span>Sering (0)</span>
                        </label>
                    </div>
                </div>
                @endforeach
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Jumlah Skor</h2>

            <div class="space-y-4 mb-6">
                <p class="text-lg">Prestasi Tugas:</p>
                <p class="text-sm text-gray-600">Jumlah skor: _____</p>

                <p class="text-lg">Prestasi Konteksual:</p>
                <p class="text-sm text-gray-600">Jumlah skor: _____</p>

                <p class="text-lg">Perilaku Kerja Tidak Produktif:</p>
                <p class="text-sm text-gray-600">Jumlah skor: _____</p>

                <p class="text-lg">Jumlah Skor Keseluruhan:</p>
                <p class="text-sm text-gray-600">Jumlah skor: _____</p>
            </div>

            <div class="mt-6">
                <br><br>
             <a href="/part-4" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600"><< Kembali</a>
        <a href="/part-6" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">Seterusnya>></a>
            </div>
        </form>
    </div>
</div>
</x-layout>