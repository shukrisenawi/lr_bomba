<x-layout>
            <x-steps>
    <x-slot:active>3</x-slot:active>
    </x-steps>
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-6">Bahagian C: Soal-selidik Kandungan Kerja</h1>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <p class="text-lg mb-4">Soal-selidik ini direka untuk mengukur ciri-ciri sosial dan psikologi pekerjaan. Sila nyatakan sejauh mana kenyataan-kenyataan ini berlaku kepada anda.</p>

        <form action="#" method="POST">
            @csrf

            <h2 class="text-2xl font-semibold mb-4">Diskresi Kemahiran</h2>

            <div class="space-y-4">
                @foreach(['Pekerjaan saya perlukan saya belajar benda baru', 'Pekerjaan saya memerlukan saya untuk menjadi kreatif', 'Pekerjaan saya memerlukan tahap kemahiran yang tinggi', 'Saya dapat melakukan pelbagai benda berbeza dalam pekerjaan saya', 'Saya berpeluang untuk membangunkan kebolehan istimewa saya sendiri'] as $index => $question)
                <div class="flex flex-col">
                    <label for="C{{ $index + 1 }}" class="mb-2">{{ $question }}</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 1 }}" name="C{{ $index + 1 }}" value="1" class="mr-2" />
                            <span>Sangat tidak setuju</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 1 }}" name="C{{ $index + 1 }}" value="2" class="mr-2" />
                            <span>Tidak setuju</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 1 }}" name="C{{ $index + 1 }}" value="3" class="mr-2" />
                            <span>Setuju</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 1 }}" name="C{{ $index + 1 }}" value="4" class="mr-2" />
                            <span>Sangat setuju</span>
                        </label>
                    </div>
                </div>
                @endforeach
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Kuasa Membuat Keputusan</h2>

            <div class="space-y-4">
                @foreach(['Pekerjaan saya membolehkan saya membuat banyak keputusan sendiri', 'Dalam pekerjaan saya, saya mempunyai sedikit kebebasan untuk membuat keputusan tentang bagaimana saya membuat kerja', 'Saya mempunyai banyak yang ingin dikatakan tentang apa yang berlaku dengan kerja saya'] as $index => $question)
                <div class="flex flex-col">
                    <label for="C{{ $index + 6 }}" class="mb-2">{{ $question }}</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 6 }}" name="C{{ $index + 6 }}" value="1" class="mr-2" />
                            <span>Sangat tidak setuju</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 6 }}" name="C{{ $index + 6 }}" value="2" class="mr-2" />
                            <span>Tidak setuju</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 6 }}" name="C{{ $index + 6 }}" value="3" class="mr-2" />
                            <span>Setuju</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 6 }}" name="C{{ $index + 6 }}" value="4" class="mr-2" />
                            <span>Sangat setuju</span>
                        </label>
                    </div>
                </div>
                @endforeach
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Tuntutan Psikologi</h2>

            <div class="space-y-4">
                @foreach(['Pekerjaan saya memerlukan saya bekerja dengan sangat cepat', 'Pekerjaan saya memerlukan saya bekerja dengan sangat keras', 'Saya bebas daripada tuntutan bercanggah yang dibuat oleh orang lain', 'Pekerjaan saya memerlukan penumpuan perhatian yang tinggi dalam jangka masa panjang', 'Pekerjaan saya sangat sibuk', 'Menunggu kerja daripada orang lain atau jabatan lain seringkali memperlahankan kerja saya', 'Tugas saya sering terganggu sebelum saya dapat menyelesaikannya, menyebabkan saya perlu kembali kepadanya kemudian'] as $index => $question)
                <div class="flex flex-col">
                    <label for="C{{ $index + 9 }}" class="mb-2">{{ $question }}</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 9 }}" name="C{{ $index + 9 }}" value="1" class="mr-2" />
                            <span>Sangat tidak setuju</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 9 }}" name="C{{ $index + 9 }}" value="2" class="mr-2" />
                            <span>Tidak setuju</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 9 }}" name="C{{ $index + 9 }}" value="3" class="mr-2" />
                            <span>Setuju</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 9 }}" name="C{{ $index + 9 }}" value="4" class="mr-2" />
                            <span>Sangat setuju</span>
                        </label>
                    </div>
                </div>
                @endforeach
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Sokongan Sosial Rakan Sejawat</h2>

            <div class="space-y-4">
                @foreach(['Orang-orang yang saya bekerja bersama kompeten dalam melakukan tugas mereka', 'Orang-orang yang saya bekerja bersama mengambil berat tentang saya', 'Orang-orang yang saya bekerja bersama membantu dalam menyiapkan kerja'] as $index => $question)
                <div class="flex flex-col">
                    <label for="C{{ $index + 16 }}" class="mb-2">{{ $question }}</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 16 }}" name="C{{ $index + 16 }}" value="1" class="mr-2" />
                            <span>Sangat tidak setuju</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 16 }}" name="C{{ $index + 16 }}" value="2" class="mr-2" />
                            <span>Tidak setuju</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 16 }}" name="C{{ $index + 16 }}" value="3" class="mr-2" />
                            <span>Setuju</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 16 }}" name="C{{ $index + 16 }}" value="4" class="mr-2" />
                            <span>Sangat setuju</span>
                        </label>
                    </div>
                </div>
                @endforeach
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Sokongan Sosial Penyelia</h2>

            <div class="space-y-4">
                @foreach(['Penyelia saya memberi perhatian kepada apa yang saya katakan', 'Penyelia saya membantu saya dalam menyiapkan kerja', 'Penyelia saya berjaya dalam menggalakkan kerjasama antara pekerja'] as $index => $question)
                <div class="flex flex-col">
                    <label for="C{{ $index + 19 }}" class="mb-2">{{ $question }}</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 19 }}" name="C{{ $index + 19 }}" value="1" class="mr-2" />
                            <span>Sangat tidak setuju</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 19 }}" name="C{{ $index + 19 }}" value="2" class="mr-2" />
                            <span>Tidak setuju</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 19 }}" name="C{{ $index + 19 }}" value="3" class="mr-2" />
                            <span>Setuju</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="C{{ $index + 19 }}" name="C{{ $index + 19 }}" value="4" class="mr-2" />
                            <span>Sangat setuju</span>
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </form>
            <br><br>
             <a href="/part-2" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600"><< Kembali</a>
        <a href="/part-4" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">Seterusnya>></a>
    </div>
</div>
</x-layout>