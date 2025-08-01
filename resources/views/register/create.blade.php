<x-layout-form>
    @section('title', 'BAHAGIAN A: Latarbelakang Demografi Responden')

    <x-title-section>
        <x-slot:title1>BAHAGIAN A: Latarbelakang Demografi Responden</x-slot:title1>
        <x-slot:title2>SECTION A: Respondent Demography Background</x-slot:title2>
        <x-slot:description>Latarbelakang Demografi Responden adalah gambaran umum mengenai karakteristik responden
            berdasarkan data kependudukan seperti usia, jantina, tahap pendidikan, pekerjaan, status sosial ekonomi, dan
            sebagainya.</x-slot:description>
    </x-title-section>

    <form action="{{ route('register.store-demography') }}" method="POST" class="max-w-4xl mx-auto space-y-6">
        @csrf

        <x-input-text type="name" value="{{ old('name', $session->name) }}">
            <x-slot:id>name</x-slot:id>
            <x-slot:label>1. Nama</x-slot:label>
        </x-input-text>

        <x-input-text type="email" value="{{ old('email', $session->email) }}">
            <x-slot:id>email</x-slot:id>
            <x-slot:label>2. E-mel</x-slot:label>
        </x-input-text>


        <x-input-text value="{{ old('phone_number') }}">
            <x-slot:id>phone_number</x-slot:id>
            <x-slot:label>3. No. H/P</x-slot:label>
        </x-input-text>
        <x-input-text type="number" value="{{ old('age') }}">
            <x-slot:id>age</x-slot:id>
            <x-slot:label>4. Umur (pada tahun 2025)</x-slot:label>
        </x-input-text>

        <x-input-text value="{{ old('place_of_birth') }}" type="text">
            <x-slot:id>place_of_birth</x-slot:id>
            <x-slot:label>5. Tempat Lahir</x-slot:label>
        </x-input-text>

        <x-radio-button :data="['Lelaki' => 'Lelaki', 'Perempuan' => 'Perempuan']" :value="old('gender')">
            <x-slot:id>gender</x-slot:id>
            <x-slot:label>6. Jantina</x-slot:label>
        </x-radio-button>

        <x-dropdown :data="['Melayu' => 'Melayu', 'Cina' => 'Cina', 'India' => 'India', 'Lain-lain' => 'Lain-lain']" :value="old('ethnicity')">
            <x-slot:id>ethnicity</x-slot:id>
            <x-slot:label>7. Etnik</x-slot:label>
        </x-dropdown>

        <x-dropdown :data="[
            'Tidak pernah berkahwin' => 'Tidak pernah berkahwin',
            'Berkahwin' => 'Berkahwin',
            'Kematian Pasangan' => 'Kematian Pasangan',
            'Bercerai / Berpisah' => 'Bercerai / Berpisah',
        ]" :value="old('marital_status')">
            <x-slot:id>marital_status</x-slot:id>
            <x-slot:label>8. Status Perkahwinan</x-slot:label>
        </x-dropdown>

        <x-dropdown :data="[
            'Tiada pendidikan formal' => 'Tiada pendidikan formal',
            'Sijil sekolah rendah' => 'Sijil sekolah rendah',
            'SRP/PMR/LCE' => 'SRP/PMR/LCE',
            'SPM/SPMV/MCE' => 'SPM/SPMV/MCE',
            'STP/STPM/STAM/HSC' => 'STP/STPM/STAM/HSC',
            'Sijil kemahiran' => 'Sijil kemahiran',
            'Diploma' => 'Diploma',
            'Ijazah Sarjana Muda' => 'Ijazah Sarjana Muda',
            'Master' => 'Master',
            'PhD' => 'PhD',
            'Lain-lain' => 'Lain-lain',
        ]" :value="old('education_level')">
            <x-slot:id>education_level</x-slot:id>
            <x-slot:label>10. Tahap Pendidikan Tertinggi</x-slot:label>
        </x-dropdown>

        <x-input-text type="number" value="{{ old('monthly_income_self') }}">
            <x-slot:id>monthly_income_self</x-slot:id>
            <x-slot:label>11. Anggaran Pendapatan Bulanan (Diri-sendiri) RM</x-slot:label>
        </x-input-text>

        <x-input-text type="number" value="{{ old('monthly_income_spouse') }}">
            <x-slot:id>monthly_income_spouse</x-slot:id>
            <x-slot:label>12. Anggaran Pendapatan Bulanan (Pasangan) RM</x-slot:label>
        </x-input-text>

        <x-input-text type="number" value="{{ old('other_income') }}">
            <x-slot:id>other_income</x-slot:id>
            <x-slot:label>13. Lain-lain Sumber Pendapatan RM</x-slot:label>
        </x-input-text>

        <x-input-text type="number" value="{{ old('household_income') }}">
            <x-slot:id>household_income</x-slot:id>
            <x-slot:label>14. Pendapatan isi rumah RM</x-slot:label>
        </x-input-text>

        <x-input-text value="{{ old('current_position') }}">
            <x-slot:id>current_position</x-slot:id>
            <x-slot:label>15. Jawatan Semasa</x-slot:label>
        </x-input-text>

        <x-dropdown :data="[
            'JUSA A' => 'JUSA A',
            'JUSA B' => 'JUSA B',
            'JUSA C' => 'JUSA C',
            'KB 54/KB 14' => 'KB 54/KB 14',
            'KB 52/KB 13' => 'KB 52/KB 13',
            'KB 48/KB 12' => 'KB 48/KB 12',
            'KB 44/KB 10' => 'KB 44/KB 10',
            'KB 41/KB 9' => 'KB 41/KB 9',
            'KB 40/KB 8' => 'KB 40/KB 8',
            'KB 38/KB 7' => 'KB 38/KB 7',
            'KB 32/KB 6' => 'KB 32/KB 6',
            'KB 29/KB 5' => 'KB 29/KB 5',
            'KB 28/KB 4' => 'KB 28/KB 4',
            'KB 26/KB 3' => 'KB 26/KB 3',
            'KB 24/KB 2' => 'KB 24/KB 2',
            'KB 22/KB 1' => 'KB 22/KB 1',
            'KB 19/KB 1' => 'KB 19/KB 1',
        ]" :value="old('grade')">
            <x-slot:id>grade</x-slot:id>
            <x-slot:label>16. Gred</x-slot:label>
        </x-dropdown>

        <x-dropdown value="{{ old('location') }}" :data="[
            'Ibu Pejabat Putrajaya' => 'Ibu Pejabat Putrajaya',
            'Ibu Pejabat Negeri' => 'Ibu Pejabat Negeri',
            'Zon daerah' => 'Zon daerah',
            'Balai bomba' => 'Balai bomba',
        ]">
            <x-slot:id>location</x-slot:id>
            <x-slot:label>17. Lokasi</x-slot:label>
        </x-dropdown>

        <x-dropdown :value="old('position')" :data="[
            'Operasi kebombaan dan penyelamat' => 'Operasi kebombaan dan penyelamat',
            'Keselamatan kebakaran' => 'Keselamatan kebakaran',
            'Latihan' => 'Latihan',
            'Penyiasatan kebakaran' => 'Penyiasatan kebakaran',
            'Udara' => 'Udara',
            'Pembangunan, kejuruteraan dan logistik' => 'Pembangunan, kejuruteraan dan logistik',
            'Perancangan dan penyelidikan' => 'Perancangan dan penyelidikan',
            'Pengurusan korporat' => 'Pengurusan korporat',
            'Pengurusan' => 'Pengurusan',
            'Integriti' => 'Integriti',
        ]">
            <x-slot:id>position</x-slot:id>
            <x-slot:label>18. Bahagian</x-slot:label>
        </x-dropdown>

        <x-dropdown :value="old('state')" :data="['Selangor' => 'Selangor', 'Kuala Lumpur' => 'Kuala Lumpur', 'Putrajaya' => 'Putrajaya']">
            <x-slot:id>state</x-slot:id>
            <x-slot:label>19. Negeri</x-slot:label>
        </x-dropdown>

        <x-input-text value="{{ old('years_of_service') }}" type="text">
            <x-slot:id>years_of_service</x-slot:id>
            <x-slot:label>20. Tempoh Perkhidmatan (Tahun), <em>contohnya: 15 tahun</em></x-slot:label>
        </x-input-text>

        <x-radio-button :value="old('service_status')" :data="[
            'Pegawai Sepenuh Masa' => 'Pegawai Sepenuh Masa',
            'Pegawai Bomba Bantuan' => 'Pegawai Bomba Bantuan',
        ]">
            <x-slot:id>service_status</x-slot:id>
            <x-slot:label>21. Status Perkhidmatan</x-slot:label>
        </x-radio-button>

        <x-input-text type="password" required>
            <x-slot:id>password</x-slot:id>
            <x-slot:label>Katakunci</x-slot:label>
        </x-input-text>

        <x-input-text type="password" required>
            <x-slot:id>password_confirmation</x-slot:id>
            <x-slot:label>Ulang Katakunci</x-slot:label>
        </x-input-text>
        <div class="flex justify-center gap-4 mt-6">
            <a href="/register" type="submit" class="bg-gray-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700">
                << Kembali</a>
                    <button type="submit" class="bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700">Hantar
                        Pendaftaran</button>
        </div>
    </form>
</x-layout-form>
