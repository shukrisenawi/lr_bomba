<x-layout>
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white bg-opacity-90 px-10 py-5 rounded-xl shadow-lg">

            <h2 class="text-center text-3xl font-extrabold text-gray-900">
                Lupa Kata Laluan
            </h2>
            <div class="flex justify-center items-center space-x-4 mb-8">
                <img src="../img/logo 1.png"
                    class="h-14 w-auto transform hover:scale-110 transition-transform duration-300" alt="Logo 1" />
                <img src="../img/logo 2.png"
                    class="h-14 w-auto transform hover:scale-110 transition-transform duration-300" alt="Logo 2" />
                <img src="../img/logo 3.png"
                    class="h-14 w-auto transform hover:scale-110 transition-transform duration-300" alt="Logo 3" />
            </div>
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4"
                    role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form class="mt-8 space-y-6" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="email" class="sr-only">E-mel</label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="E-mel">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Hantar Link Reset
                    </button>
                </div>
            </form>

            <div class="text-center">
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Kembali ke Log Masuk
                </a>
            </div>
        </div>
    </div>
</x-layout>