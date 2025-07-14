<x-layout>
        <x-steps>
    <x-slot:active>2</x-slot:active>
    </x-steps>
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold text-center mb-6">Indeks Kebolehan Bekerja (Work Ability Index)</h1>

    <form action="" method="POST" class="max-w-4xl mx-auto space-y-6">
        @csrf

        <div class="space-y-4">
            <!-- Kebolehan Bekerja -->
            <div class="flex flex-col">
                <label for="work_ability" class="font-medium text-gray-700">Pada pandangan anda, sejauhmanakah kebolehan anda bekerja sekarang?</label>
                <input type="range" name="work_ability" id="work_ability" min="0" max="10" step="1" class="mt-2 w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                <div class="flex justify-between text-sm text-gray-600">
                    <span>0 = Tidak boleh bekerja langsung</span>
                    <span>10 = Boleh bekerja pada tahap terbaik</span>
                </div>
            </div>

            <!-- Tuntutan Fizikal -->
            <div class="flex flex-col">
                <label for="physical_demand" class="font-medium text-gray-700">Bagaimana anda menilai kebolehan bekerja sekarang dengan tuntutan fizikal anda?</label>
                <select name="physical_demand" id="physical_demand" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="5">Sangat Baik</option>
                    <option value="4">Agak Baik</option>
                    <option value="3">Sederhana</option>
                    <option value="2">Agak Teruk</option>
                    <option value="1">Sangat Teruk</option>
                </select>
            </div>

            <!-- Tuntutan Mental -->
            <div class="flex flex-col">
                <label for="mental_demand" class="font-medium text-gray-700">Bagaimana anda menilai kebolehan bekerja sekarang dengan tuntutan mental anda?</label>
                <select name="mental_demand" id="mental_demand" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="5">Sangat Baik</option>
                    <option value="4">Agak Baik</option>
                    <option value="3">Sederhana</option>
                    <option value="2">Agak Teruk</option>
                    <option value="1">Sangat Teruk</option>
                </select>
            </div>

            <!-- Penyakit atau Masalah Kesihatan -->
            <div class="flex flex-col">
                <label for="health_conditions" class="font-medium text-gray-700">Bilangan penyakit/masalah kesihatan yang anda alami sekarang yang telah disahkan oleh pegawai perubatan?</label>
                <select name="health_conditions" id="health_conditions" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="7">Tiada</option>
                    <option value="5">1</option>
                    <option value="4">2</option>
                    <option value="3">3</option>
                    <option value="2">4</option>
                    <option value="1">5 dan lebih</option>
                </select>
            </div>

            <!-- Gangguan Kerja -->
            <div class="flex flex-col">
                <label for="work_interference" class="font-medium text-gray-700">Adakah penyakit/masalah kesihatan mengganggu kerja anda sekarang?</label>
                <select name="work_interference" id="work_interference" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="6">Tiada halangan / Saya tiada penyakit</option>
                    <option value="5">Saya mampu membuat kerja saya, tapi ia menyebabkan timbul beberapa gejala/simptom</option>
                    <option value="4">Saya kadang-kala perlu memperlahankan rentak kerja saya atau mengubah kaedah kerja saya</option>
                    <option value="3">Saya sering perlu memperlahankan rentak kerja saya atau menukar kaedah kerja saya</option>
                    <option value="2">Disebabkan keadaan saya, saya rasa saya hanya mampu melakukan kerja separuh masa</option>
                    <option value="1">Pada pendapat saya, saya langsung tidak mampu untuk bekerja</option>
                </select>
            </div>

            <!-- Hari Tidak Bekerja -->
            <div class="flex flex-col">
                <label for="days_off" class="font-medium text-gray-700">Berapa hari anda tidak bekerja dalam tempoh 12 bulan yang lalu kerana penyakit/masalah kesihatan yang anda alami?</label>
                <select name="days_off" id="days_off" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="5">Tiada</option>
                    <option value="4">Maksimum 9 hari</option>
                    <option value="3">10-24 hari</option>
                    <option value="2">25-99 hari</option>
                    <option value="1">100-354 hari</option>
                </select>
            </div>

            <!-- Keyakinan Terhadap Masa Depan -->
            <div class="flex flex-col">
                <label for="future_ability" class="font-medium text-gray-700">Adakah anda percaya bahawa penyakit/masalah kesihatan yang anda sedang alami sekarang, anda masih dapat melakukan pekerjaan anda untuk tempoh dua tahun lagi?</label>
                <select name="future_ability" id="future_ability" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="1">Tidak mungkin</option>
                    <option value="4">Tidak pasti</option>
                    <option value="7">Agak pasti</option>
                </select>
            </div>

            <!-- Aktiviti Harian -->
            <div class="flex flex-col">
                <label for="daily_activities" class="font-medium text-gray-700">Merujuk pada 3 bulan lepas, adakah anda dapat menikmati aktiviti harian biasa anda?</label>
                <select name="daily_activities" id="daily_activities" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="4">Selalu</option>
                    <option value="3">Hampir sentiasa</option>
                    <option value="2">Kadang-kadang</option>
                    <option value="1">Jarang-jarang</option>
                    <option value="0">Tidak pernah</option>
                </select>
            </div>

            <!-- Aktiviti Fizikal -->
            <div class="flex flex-col">
                <label for="physical_activity" class="font-medium text-gray-700">Merujuk pada 3 bulan lepas, adakah anda aktif dan cergas?</label>
                <select name="physical_activity" id="physical_activity" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="4">Selalu</option>
                    <option value="3">Hampir sentiasa</option>
                    <option value="2">Kadang-kadang</option>
                    <option value="1">Jarang-jarang</option>
                    <option value="0">Tidak pernah</option>
                </select>
            </div>

            <!-- Harapan Masa Depan -->
            <div class="flex flex-col">
                <label for="future_hope" class="font-medium text-gray-700">Merujuk pada 3 bulan lepas, adakah anda merasa penuh harapan untuk masa depan?</label>
                <select name="future_hope" id="future_hope" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="4">Selalu</option>
                    <option value="3">Hampir sentiasa</option>
                    <option value="2">Kadang-kadang</option>
                    <option value="1">Jarang-jarang</option>
                    <option value="0">Tidak pernah</option>
                </select>
            </div>

        </div>

         <a href="/part-1" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600"><< Kembali</a>
        <a href="/part-3" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">Seterusnya>></a>
    </form>
</div>
</x-layout>