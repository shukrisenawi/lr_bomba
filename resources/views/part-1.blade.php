<x-layout>
    <x-steps>
    <x-slot:active>1</x-slot:active>
    </x-steps>
<h1 class="text-2xl font-semibold text-center mb-6">Latar Belakang Demografi Responden</h1>

    <form action="#" method="POST" class="max-w-4xl mx-auto space-y-6">
        @csrf

        <div class="space-y-4">
            <!-- No. H/P -->
            <div class="flex flex-col">
                <label for="phone_number" class="font-medium text-gray-700">No. H/P</label>
                <input type="text" name="phone_number" id="phone_number" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <!-- E-mel -->
            <div class="flex flex-col">
                <label for="email" class="font-medium text-gray-700">E-mel</label>
                <input type="email" name="email" id="email" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <!-- Umur -->
            <div class="flex flex-col">
                <label for="age" class="font-medium text-gray-700">Umur (pada tahun 2025)</label>
                <input type="number" name="age" id="age" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <!-- Tempat Lahir -->
            <div class="flex flex-col">
                <label for="place_of_birth" class="font-medium text-gray-700">Tempat Lahir</label>
                <input type="text" name="place_of_birth" id="place_of_birth" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <!-- Jantina -->
            <div class="flex flex-col">
                <label class="font-medium text-gray-700">Jantina</label>
                <div class="flex items-center space-x-4 mt-2">
                    <div>
                        <input type="radio" id="gender_male" name="gender" value="Lelaki" class="form-radio text-blue-500" required>
                        <label for="gender_male" class="ml-2">Lelaki</label>
                    </div>
                    <div>
                        <input type="radio" id="gender_female" name="gender" value="Perempuan" class="form-radio text-blue-500" required>
                        <label for="gender_female" class="ml-2">Perempuan</label>
                    </div>
                </div>
            </div>

            <!-- Etnik -->
            <div class="flex flex-col">
                <label for="ethnicity" class="font-medium text-gray-700">Etnik</label>
                <select name="ethnicity" id="ethnicity" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="Melayu">Melayu</option>
                    <option value="Cina">Cina</option>
                    <option value="India">India</option>
                    <option value="Lain-lain">Lain-lain</option>
                </select>
            </div>

            <!-- Status Perkahwinan -->
            <div class="flex flex-col">
                <label for="marital_status" class="font-medium text-gray-700">Status Perkahwinan</label>
                <select name="marital_status" id="marital_status" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="Tidak pernah berkahwin">Tidak pernah berkahwin</option>
                    <option value="Berhijrah">Berhijrah</option>
                    <option value="Balu">Balu</option>
                    <option value="Bercerai">Bercerai</option>
                </select>
            </div>

            <!-- Tahap Pendidikan -->
            <div class="flex flex-col">
                <label for="education_level" class="font-medium text-gray-700">Tahap Pendidikan Tertinggi</label>
                <select name="education_level" id="education_level" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="Tiada pendidikan formal">Tiada pendidikan formal</option>
                    <option value="Sijil sekolah rendah">Sijil sekolah rendah</option>
                    <option value="SRP/PMR/LCE">SRP/PMR/LCE</option>
                    <option value="SPM/SPMV/MCE">SPM/SPMV/MCE</option>
                    <option value="STP/STPM/STAM/HSC">STP/STPM/STAM/HSC</option>
                    <option value="Sijil kemahiran">Sijil kemahiran</option>
                    <option value="Diploma">Diploma</option>
                    <option value="Ijazah Sarjana Muda">Ijazah Sarjana Muda</option>
                    <option value="Master">Master</option>
                    <option value="PhD">PhD</option>
                    <option value="Lain-lain">Lain-lain</option>
                </select>
            </div>

            <!-- Pendapatan Bulanan Diri -->
            <div class="flex flex-col">
                <label for="monthly_income_self" class="font-medium text-gray-700">Anggaran Pendapatan Bulanan (Diri-sendiri) RM</label>
                <input type="number" name="monthly_income_self" id="monthly_income_self" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <!-- Pendapatan Bulanan Pasangan -->
            <div class="flex flex-col">
                <label for="monthly_income_spouse" class="font-medium text-gray-700">Anggaran Pendapatan Bulanan (Pasangan) RM</label>
                <input type="number" name="monthly_income_spouse" id="monthly_income_spouse" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Lain-lain Sumber Pendapatan -->
            <div class="flex flex-col">
                <label for="other_income" class="font-medium text-gray-700">Lain-lain Sumber Pendapatan RM</label>
                <input type="number" name="other_income" id="other_income" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Jawatan Semasa -->
            <div class="flex flex-col">
                <label for="current_position" class="font-medium text-gray-700">Jawatan Semasa</label>
                <input type="text" name="current_position" id="current_position" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <!-- Gred -->
            <div class="flex flex-col">
                <label for="grade" class="font-medium text-gray-700">Gred</label>
                <select name="grade" id="grade" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="JUSA A">JUSA A</option>
                    <option value="JUSA B">JUSA B</option>
                    <option value="JUSA C">JUSA C</option>
                    <option value="KB 54/KB 14">KB 54/KB 14</option>
                    <option value="KB 52/KB 13">KB 52/KB 13</option>
                    <option value="KB 48/KB 12">KB 48/KB 12</option>
                    <option value="KB 44/KB 10">KB 44/KB 10</option>
                    <option value="KB 41/KB 9">KB 41/KB 9</option>
                    <option value="KB 40/KB 8">KB 40/KB 8</option>
                    <option value="KB 38/KB 7">KB 38/KB 7</option>
                    <option value="KB 32/KB 6">KB 32/KB 6</option>
                    <option value="KB 29/KB 5">KB 29/KB 5</option>
                    <option value="KB 28/KB 4">KB 28/KB 4</option>
                    <option value="KB 26/KB 3">KB 26/KB 3</option>
                    <option value="KB 24/KB 2">KB 24/KB 2</option>
                    <option value="KB 22/KB 1">KB 22/KB 1</option>
                    <option value="KB 19/KB 1">KB 19/KB 1</option>
                </select>
            </div>

            <!-- Lokasi -->
            <div class="flex flex-col">
                <label for="location" class="font-medium text-gray-700">Lokasi</label>
                <input type="text" name="location" id="location" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <!-- Tempoh Berkhidmat -->
            <div class="flex flex-col">
                <label for="years_of_service" class="font-medium text-gray-700">Tempoh Berkhidmat</label>
                <input type="number" name="years_of_service" id="years_of_service" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <!-- Status Perkhidmatan -->
            <div class="flex flex-col">
                <label for="service_status" class="font-medium text-gray-700">Status Perkhidmatan</label>
                <select name="service_status" id="service_status" class="mt-2 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="Pegawai Sepenuh Masa">Pegawai Sepenuh Masa</option>
                    <option value="Pegawai Bomba Bantuan">Pegawai Bomba Bantuan</option>
                </select>
            </div>
        </div>
  <a href="/" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600"><< Kembali</a>
        <a href="/part-2" class="w-full mt-4 p-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">Seterusnya>></a>
    </form>
</div>
</x-layout>