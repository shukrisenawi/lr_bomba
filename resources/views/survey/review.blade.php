@extends('layouts.app')

@section('title', 'Semakan')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-2xl font-bold">
                        {{ $sectionTitle }}
                    </div>

                    <div class="card-body">
                        @foreach ($questions as $question)
                            <div class="mb-4">
                                <h5>{{ $question['text'] }}</h5>
                                @php
                                    $answer = $response->answers->where('question_id', $question['id'])->first();
                                @endphp

                                @if ($answer)
                                    <p><strong>Jawapan Anda:</strong> {{ $answer->answer }}</p>
                                @else
                                    <p class="text-danger">Belum dijawab</p>
                                @endif
                            </div>
                        @endforeach

                        <a href="{{ route('survey.results', $section) }}" class="btn btn-info">Kembali ke Keputusan</a>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
