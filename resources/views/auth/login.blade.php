<x-layout>
    <div class="max-w-4xl mx-auto opacity-95 sm:p-6">
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-center mb-6">Log Masuk</h2>
            @if ($errors->any())
                <div class="alert alert-danger mb-5">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 mb-2">E-mel</label>
                    <input type="email" id="email" name="email"
                        class="w-full p-2 border border-gray-300 rounded" required autofocus>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-700 mb-2">Kata Laluan</label>
                    <input type="password" id="password" name="password"
                        class="w-full p-2 border border-gray-300 rounded" required>
                </div>

                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="mr-2">
                        <label for="remember" class="text-gray-700">Ingat saya</label>
                    </div>

                    <a href="/register" class="text-blue-600 hover:underline">Daftar Baru</a>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                    Log Masuk
                </button>
            </form>
        </div>
    </div>
    </x-layout-form>
