@extends('layouts.app')

@section('title', 'Admin Login - Bahagian I &amp; L')

@section('content')
    <div class="text-left mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Admin Access Required</h2>
        <p class="text-gray-600">Bahagian {{ $section }} hanya boleh diakses oleh admin.</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('survey.admin.login', $section) }}" class="space-y-4 text-left">
        @csrf
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Admin</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Laluan</label>
            <input id="password" name="password" type="password" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-800 underline">Kembali ke
                Dashboard</a>
            <button type="submit"
                class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                <i class="fas fa-lock mr-2"></i>
                Log Masuk Admin
            </button>
        </div>
    </form>
@endsection
