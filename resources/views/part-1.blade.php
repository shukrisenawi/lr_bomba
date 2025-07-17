<x-layout>
<x-title-section>
<x-slot:title1>BAHAGIAN A: Latarbelakang Demografi Responden</x-slot:title1>
<x-slot:title2>SECTION A: Respondent Demography Background</x-slot:title2>
<x-slot:description>Latarbelakang Demografi Responden adalah gambaran umum mengenai karakteristik responden berdasarkan data kependudukan seperti usia, jantina, tahap pendidikan, pekerjaan, status sosial ekonomi, dan sebagainya.</x-slot:description>
</x-title-section>

    <form action="#" method="POST" class="max-w-4xl mx-auto space-y-6">
        @csrf

        <div class="space-y-4">

            <x-input-text>
                <x-slot:id>phone_number</x-slot:id>
                <x-slot:label>1. No. H/P</x-slot:label>
            </x-input-text>

            <x-input-text type="email" required>
                <x-slot:id>email</x-slot:id>
                <x-slot:label>2. E-mel</x-slot:label>
            </x-input-text>

            <x-input-text type="number" required>
                <x-slot:id>age</x-slot:id>
                <x-slot:label>3. Umur (pada tahun 2025)</x-slot:label>
            </x-input-text>

            <x-input-text type="text">
                <x-slot:id>place_of_birth</x-slot:id>
                <x-slot:label>4. Tempat Lahir</x-slot:label>
            </x-input-text>

            <x-input-text>
                <x-slot:id>phone_number</x-slot:id>
                <x-slot:label>5. No. H/P</x-slot:label>
            </x-input-text>

            <x-radio-button :data="['Lelaki', 'Perempuan']">
                <x-slot:id>gander</x-slot:id>
                <x-slot:label>6. Jantina</x-slot:label>
            </x-radio-button>

            <x-dropdown :data="['Melayu', 'Cina', 'India', 'Lain-lain']">
                <x-slot:id>ethnicity</x-slot:id>
                <x-slot:label>7. Etnik</x-slot:label>
            </x-dropdown>

            <x-dropdown :data="['Tidak pernah berkahwin', 'Berhijrah', 'Balu', 'Bercerai']">
                <x-slot:id>marital_status</x-slot:id>
                <x-slot:label>8. Status Perkahwinan</x-slot:label>
            </x-dropdown>

            <x-dropdown :data="['Tiada pendidikan formal', 'Sijil sekolah rendah', 'SRP/PMR/LCE', 'SPM/SPMV/MCE', 'STP/STPM/STAM/HSC', 'Sijil kemahiran', 'Diploma', 'Ijazah Sarjana Muda', 'Master', 'PhD', 'Lain-lain']">
                <x-slot:id>education_level</x-slot:id>
                <x-slot:label>9. Tahap Pendidikan Tertinggi</x-slot:label>
            </x-dropdown>

            <x-input-text type="number" required>
                <x-slot:id>monthly_income_self</x-slot:id>
                <x-slot:label>10. Anggaran Pendapatan Bulanan (Diri-sendiri) RM</x-slot:label>
            </x-input-text>

            <x-input-text type="number" required>
                <x-slot:id>monthly_income_spouse</x-slot:id>
                <x-slot:label>11. Anggaran Pendapatan Bulanan (Pasangan) RM</x-slot:label>
            </x-input-text>

            <x-input-text type="number" required>
                <x-slot:id>other_income</x-slot:id>
                <x-slot:label>13. Lain-lain Sumber Pendapatan RM</x-slot:label>
            </x-input-text>

            <x-input-text required>
                <x-slot:id>current_position</x-slot:id>
                <x-slot:label>14. Jawatan Semasa</x-slot:label>
            </x-input-text>

            <x-dropdown :data="['JUSA A', 'JUSA B', 'JUSA C', 'KB 54/KB 14', 'KB 52/KB 13', 'KB 48/KB 12', 'KB 44/KB 10', 'KB 41/KB 9', 'KB 40/KB 8', 'KB 38/KB 7', 'KB 32/KB 6', 'KB 29/KB 5', 'KB 28/KB 4', 'KB 26/KB 3', 'KB 24/KB 2', 'KB 22/KB 1', 'KB 19/KB 1']">
                <x-slot:id>grade</x-slot:id>
                <x-slot:label>Gred</x-slot:label>
            </x-dropdown>

            <x-dropdown :data="['Ibu Pejabat Putrajaya', 'Ibu Pejabat Negeri', 'Zon daerah', 'Balai bomba']">
                <x-slot:id>location</x-slot:id>
                <x-slot:label>Lokasi</x-slot:label>
            </x-dropdown>

            <x-dropdown :data="['Operasi kebombaan dan penyelamat', 'Keselamatan kebakaran',
            'Latihan', 'Penyiasatan kebakaran', 'Udara', 'Pembangunan, kejuruteraan dan logistik', 'Perancangan dan penyelidikan', 'Pengurusan korporat', 'Pengurusan', 'Integriti']">
                <x-slot:id>position</x-slot:id>
                <x-slot:label>Bahagian</x-slot:label>
            </x-dropdown>

            <x-dropdown :data="['Selangor', 'Kuala Lumpur', 'Putrajaya']">
                <x-slot:id>state</x-slot:id>
                <x-slot:label>Negeri</x-slot:label>
            </x-dropdown>

            <x-input-text type="number" required>
                <x-slot:id>years_of_service</x-slot:id>
                <x-slot:label>Tempoh Berkhidmat</x-slot:label>
            </x-input-text>

            <x-radio-button :data="['Pegawai Sepenuh Masa', 'Pegawai Bomba Bantuan']">
                <x-slot:id>service_status</x-slot:id>
                <x-slot:label>Status Perkhidmatan</x-slot:label>
            </x-radio-button>
        </div>
<span class="font-bold text-red-500">*Akan dipaparkan sebagai maklumat am di akhir penilaian</span>
        <x-navigation>
            <x-slot:active>1</x-slot:active>
            <x-slot:link1>/</x-slot:link1>
            <x-slot:link2>/part-2</x-slot:link2>
        </x-navigation>

    </form>
</div>
</x-layout>