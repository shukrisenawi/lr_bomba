@extends('layouts.app')

@section('title', 'Keputusan')
@section('content')

    <div class="card-header">
        Keputusan {{ $sectionData['title_BM'] }}
    </div>

    <div class="card-body">
        @if ($response->scores->isNotEmpty())
            @foreach ($response->scores as $score)
                <h4>Skor Anda: {{ $score->score }}</h4>
                <p>Kategori: {{ $score->category }}</p>
                <div class="alert alert-info">
                    <h5>Cadangan:</h5>
                    <p>{{ $score->recommendation }}</p>
                </div>
            @endforeach
        @else
            <p>Tiada keputusan dikira untuk bahagian ini.</p>
        @endif

        <a href="{{ route('survey.review', $section) }}" class="btn btn-info">Semak Jawapan</a>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
@endsection
