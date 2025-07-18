@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <h1 class="font-bold text-center text-xl sm:text-2xl mb-5 sm:mb-10">Kajian Pembangunan Profil Kesejahteraan
        Pekerja Berusia di Jabatan Bomba dan Penyelamat Di Lembah Klang, Malaysia</h1>

    <div class="row">
        @foreach ($sections as $section => $title)
            <div class="col-md-4 mb-4">
                <div class="card w-full bg-base-100 shadow-sm">
                    <div class="card-body">

                        <h5 class="card-title text-center block w-full">{{ $title }}</h5>
                        <h4 class="font-bold">Progress : {{ $progress[$section] }}%</h4>

                        @if (isset($responses[$section]))
                            @if ($responses[$section]->completed)
                                <progress class="progress progress-success w-[100%]" value="100"
                                    max="100">100%</progress>
                                <a href="{{ route('survey.results', $section) }}" class="btn btn-soft btn-success">Lihat
                                    Keputusan</a>
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
