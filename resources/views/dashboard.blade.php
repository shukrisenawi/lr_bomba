@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="flex justify-between items-center mb-5 sm:mb-10">
        <h1 class="font-bold text-center text-xl sm:text-2xl">Kajian Pembangunan Profil Kesejahteraan
            Pekerja Berusia di Jabatan Bomba dan Penyelamat Di Lembah Klang, Malaysia</h1>

        <form action="{{ route('logout') }}" method="POST" class="ml-4">
            @csrf
            <button type="submit" class="btn btn-error btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
            </button>
        </form>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card w-full bg-base-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-users-cog me-2"></i>
                        Akses Halaman Admin
                    </h5>
                    <p class="text-muted">Akses senarai responder dan jawapan mereka</p>
                    <div class="flex gap-2 flex-wrap">
                        <a href="{{ route('admin.responders') }}" class="btn btn-primary">
                            <i class="fas fa-eye me-1"></i>
                            Lihat Senarai Responder
                        </a>
                        <a href="{{ route('admin.export') }}" class="btn btn-success">
                            <i class="fas fa-file-excel me-1"></i>
                            Export ke Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        @foreach ($sections as $section => $title)
            <div class="col-md-4 mb-4">
                <div class="card w-full bg-base-100 shadow-sm">
                    <div class="card-body">

                        <h5 class="card-title text-center block w-full">{{ $title }}</h5>
                        <h4 class="font-bold">Progress : {{ $progress[$section] }}%</h4>

                        @if ($section !== 'A')
                            <a href="{{ route('survey.results', $section) }}" class="btn btn-soft btn-success">Lihat
                                Keputusan</a>
                        @endif

                        @if (isset($responses[$section]))
                            @if ($responses[$section]->completed)
                                <progress class="progress progress-success w-[100%]" value="100"
                                    max="100">100%</progress>
                                <a href="{{ route('survey.review', $section) }}" class="btn btn-soft btn-info">Semak
                                    Jawapan</a>
                            @else
                                <progress class="progress progress-info w-[100%]" value="{{ $progress[$section] }}"
                                    max="100">{{ $progress[$section] }}%</progress>
                                <a href="{{ route('survey.show', $section) }}" class="btn btn-soft btn-primary">Sambung</a>
                            @endif
                        @else
                            <progress class="progress progress-neutral w-[100%]" value="0" max="100"></progress>
                            <a href="{{ route('survey.show', $section) }}" class="btn btn-soft btn-primary">Mulakan</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script>
        // Script khusus untuk halaman ini
        console.log('Dashboard loaded');
    </script>
@endpush
