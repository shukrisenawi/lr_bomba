<x-layout>

            <h1 class="text-3xl font-bold text-center text-blue-600 mb-6">Kajian Pembangunan Profil Kesejahteraan Pekerja
                Berusia</h1>
<x-steps>
    <x-slot:active>{{ 0 }}</x-slot:active>
</x-steps>
            <h2 class="text-2xl font-semibold text-blue-500 mb-4">Pengenalan</h2>
            <p class="text-gray-700 text-lg mb-4">
                Kesejahteraan pekerja, terutama pekerja yang semakin berusia, adalah isu kritikal yang berpotensi mempengaruhi
                prestasi, keselamatan, dan keseluruhan kualiti hidup mereka. Secara umumnya, anggota Jabatan Bomba dan Penyelamat
                Malaysia (JBPM) sering menghadapi pelbagai cabaran samada dari segi fizikal dan mental seiring dengan tugasan dan
                tanggungjawab mereka berhadapan dengan risiko keselamatan dan kecemasan semasa bekerja. Selain itu, peningkatan usia
                juga sedikit sebanyak turut memberi kesan secara tidak langsung dalam mereka mendepani cabaran ini. Justeru, adalah
                perlu untuk memahami dan menangani cabaran unik ini bagi memastikan kesejahteraan hidup pekerja berusia ini dapat
                dicapai dengan sebaiknya.
            </p>

            <h2 class="text-2xl font-semibold text-blue-500 mb-4">Tujuan Kajian</h2>
            <p class="text-gray-700 text-lg mb-4">
                Kajian ini bertujuan untuk menyediakan satu mekanisma penilaian komprehensif untuk mengurus pekerja berusia dengan
                lebih efektif dan berkesan di JBPM di Lembah Klang, Malaysia. Ia akan dibangunkan bagi membantu pihak JBPM dalam
                membuat penilaian yang lebih menyeluruh bagi memperkukuhkan aspek pengurusan sumber manusia, keselamatan dan
                kesihatan pekerjaan (OSH), keupayaan kerja, dan produktiviti anggota berusia JBPM.
            </p>

            <h2 class="text-2xl font-semibold text-blue-500 mb-4">Apa Yang Perlu Anda Lakukan?</h2>
            <p class="text-gray-700 text-lg mb-4">
                Secara keseluruhan, keterlibatan dan kerjasama secara aktif daripada tuan/puan dalam memberikan maklumat dan
                pandangan yang berkaitan adalah penting untuk membantu penyelidik dan pihak JBPM dalam mengenal pasti isu dan
                cabaran yang dihadapi oleh tuan/puan di tempat kerja ke arah menambahbaik aspek pengurusan tenaga kerja berusia
                JBPM.
            </p>

            <h2 class="text-2xl font-semibold text-blue-500 mb-4">Siapa Yang Tidak Boleh Menyertai Kajian Ini?</h2>
            <ul class="list-disc pl-5 text-gray-700 text-lg mb-4">
                <li>Anggota JBPM yang berumur di bawah 45 tahun</li>
                <li>Pejabat/balai bomba JBPM yang terletak di luar Lembah Klang</li>
                <li>Pegawai bukan anggota bomba (gred C, M, N, J, F, W)</li>
            </ul>

            <h2 class="text-2xl font-semibold text-blue-500 mb-4">Apakah Faedah Menyertai Kajian Ini?</h2>
            <p class="text-gray-700 text-lg mb-4">
                Penglibatan tuan/puan dalam kajian ini memberi faedah/menafaat bukan sahaja kepada JBPM (dalam bentuk data dan
                maklumat untuk perancangan masa depan) tetapi juga kepada tuan/puan kerana maklumat yang diberikan akan dapat
                membantu untuk penambahbaikan dalam polisi, program, sokongan, kemudahan, dan kesejahteraan di tempat kerja.
            </p>

            <h2 class="text-2xl font-semibold text-blue-500 mb-4">Adakah Risiko Terlibat?</h2>
            <p class="text-gray-700 text-lg mb-4">
                Risiko adalah minimal kerana ianya dikendalikan dengan pendekatan yang teliti dan beretika. Penyelidik akan
                memastikan bahawa prosedur penyelidikan dilaksanakan dengan mengutamakan kesejahteraan responden, memberikan
                maklumat yang jelas mengenai tujuan kajian, dan menjaga kerahsiaan serta hak privasi responden dan organisasi.
            </p>

            <h2 class="text-2xl font-semibold text-blue-500 mb-4">Adakah Maklumat dan Identiti Saya Kekal Rahsia?</h2>
            <p class="text-gray-700 text-lg mb-4">
                Dengan langkah-langkah perlindungan yang betul, penyelidik akan memastikan maklumat dan identiti responden kajian
                ini akan kekal rahsia sejajar dengan pematuhan kepada Akta Perlindungan Data Peribadi 2010. Pematuhan kepada
                prinsip kerahsiaan dan etika penyelidikan yang ketat adalah amat penting untuk memastikan bahawa maklumat yang
                dikongsi oleh responden tidak disalahgunakan dan hanya digunakan untuk tujuan penyelidikan yang sah.
            </p>

            <h2 class="text-2xl font-semibold text-blue-500 mb-4">Persetujuan Menjadi Responden</h2>
            <p class="text-gray-700 text-lg mb-4">
                Sila masukkan nama dan tarikh di sini sekiranya anda telah membaca dan memahami kandungan halaman ini.
            </p>

            <form action="/survey" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700">Nama:</label>
                    <input type="text" id="nama" name="nama" class="w-full p-3 border border-gray-300 rounded-md mt-2" required>
                </div>
                <div class="mb-4">
                    <label for="tarikh" class="block text-gray-700">Tarikh:</label>
                    <input type="date" id="tarikh" name="tarikh" class="w-full p-3 border border-gray-300 rounded-md mt-2" required>
                </div>
                <div class="mb-4">
                    <label for="persetujuan" class="block text-gray-700">Persetujuan:</label>
                    <div class="flex items-center">
                        <input type="checkbox" id="persetujuan" name="persetujuan" class="mr-2" required>
                        <span>Saya bersetuju untuk menjadi responden dalam kajian ini</span>
                    </div>
                </div>
                <div class="flex justify-center mt-6">
                    <a href="/part-1" type="submit" class="bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700">Hantar Persetujuan</a>
                </div>
            </form>

</x-layout>