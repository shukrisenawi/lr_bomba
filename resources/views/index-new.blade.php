<x-layout>
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-orange-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo Section -->
            <div class="text-center">
                <div class="flex justify-center items-center space-x-4 mb-8">
                    <img src="../img/logo 1.png"
                        class="h-16 w-auto transform hover:scale-110 transition-transform duration-300" alt="Logo 1" />
                    <img src="../img/logo 2.png"
                        class="h-16 w-auto transform hover:scale-110 transition-transform duration-300" alt="Logo 2" />
                    <img src="../img/logo 3.png"
                        class="h-16 w-auto transform hover:scale-110 transition-transform duration-300"
                        alt="Logo 3" />
                </div>
                <h2 class="mt-6 text-2xl font-extrabold text-gray-900">
                    Aplikasi Penilaian ‘Fit-to-Work’
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Jabatan Bomba dan Penyelamat Malaysia
                </p>
            </div>

            <!-- Action Cards -->
            <div class="mt-8 space-y-6">
                <!-- Register Card -->
                <div class="group">
                    <a href="/register"
                        class="relative block w-full px-8 py-6 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-white">Daftar Baru</h3>
                                <p class="text-blue-100 text-sm">Mulakan pendaftaran sebagai responden baharu</p>
                            </div>
                            <div class="ml-auto">
                                <svg class="h-5 w-5 text-white transform group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Login Card -->
                <div class="group">
                    <a href="/login"
                        class="relative block w-full px-8 py-6 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-white">Log Masuk</h3>
                                <p class="text-orange-100 text-sm">Akses sistem untuk responden berdaftar</p>
                            </div>
                            <div class="ml-auto">
                                <svg class="h-5 w-5 text-white transform group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-xs text-gray-500">
                    National Institute of Occupational Safety & Health (NIOSH), Malaysia dan
                    Institut Penyelidikan Penuaan Malaysia (MyAgeing®), UPM
                </p>
            </div>
        </div>
    </div>

    <!-- Background Pattern -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div
            class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-blue-100 via-transparent to-orange-100 opacity-50">
        </div>
        <div
            class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse">
        </div>
        <div
            class="absolute top-3/4 right-1/4 w-96 h-96 bg-orange-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse animation-delay-2000">
        </div>
    </div>

    <style>
        @keyframes pulse {

            0%,
            100% {
                opacity: 0.2;
                transform: scale(1);
            }

            50% {
                opacity: 0.3;
                transform: scale(1.1);
            }
        }

        .animate-pulse {
            animation: pulse 4s ease-in-out infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }
    </style>
</x-layout>
