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
                            <div class="mb-4 border p-4 rounded-lg">
                                <h5>{{ $question['text'] }}</h5>
                                @php
                                    $answer = $response->answers->where('question_id', $question['id'])->first();
                                @endphp

                                @if ($answer)
                                    <p><strong>Jawapan Anda:</strong>
                                        @if ($question['type'] === 'single_choice' || $question['type'] === 'scale')
                                            @php
                                                $displayText = $answer->answer;
                                                if (isset($question['options']) && is_array($question['options'])) {
                                                    foreach ($question['options'] as $option) {
                                                        if ($option === $answer->answer) {
                                                            $displayText = $option;
                                                            break;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            {{ $displayText }}
                                        @else
                                            {{ $answer->answer }}
                                        @endif
                                    </p>
                                    <a href="{{ route('survey.edit', [$section, $question['id']]) }}"
                                        class="btn btn-warning btn-sm mt-2">
                                        Edit Jawapan
                                    </a>
                                @else
                                    <p class="text-danger">Belum dijawab</p>
                                @endif
                            </div>
                        @endforeach

                        <div class="flex gap-2 mt-6">
                            <a href="{{ route('survey.results', $section) }}" class="btn btn-info">Kembali ke Keputusan</a>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
