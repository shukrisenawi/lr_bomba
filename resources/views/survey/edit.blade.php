@extends('layouts.app')

@section('content')
    <div class="text-center w-full">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold block m-0">
                {{ $sectionTitle }}<br>(Kemaskini Jawapan)
            </h2>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="btn btn-error btn-sm">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <form method="POST" action="{{ route('survey.update', [$section, $question['id']]) }}" class="text-left p-5">
        @csrf
        @method('PUT')
        <input type="hidden" name="question_id" value="{{ $question['id'] }}">

        <h4>{{ $question['text_BM'] ?? $question['text'] }}</h4>

        @if ($question['type'] === 'single_choice')
            <div class="form-group">

                @foreach ($question['options'] as $key => $option)
                    @php
                        // Handle both string and array option formats
                        $optionText = is_array($option) ? $option['text'] ?? ($option['label'] ?? '') : $option;
                        $optionValue = is_array($option) ? $option['value'] ?? $key : $key;

                        // Ensure answer is string for comparison
                        $currentAnswer = is_array($answer->value ?? null)
                            ? json_encode($answer->value)
                            : $answer->value ?? '';
                        $isChecked = $currentAnswer == $optionValue;
                    @endphp

                    <div class="form-check">
                        <input type="radio" id="answer_{{ $key }}" name="answer" value="{{ $optionValue }}"
                            class="form-check-input" {{ $isChecked ? 'checked' : '' }}>
                        <label class="form-check-label" for="answer_{{ $key }}">
                            {{ $optionText }}
                        </label>
                    </div>
                @endforeach
            </div>
        @elseif($question['type'] === 'numeric')
            <div class="form-group">
                <input type="number" name="answer" id="answer" class="form-control"
                    value="{{ is_array($answer->answer ?? null) ? '' : $answer->answer ?? '' }}" required>
                @if (isset($question['unit']))
                    <small class="text-muted">Unit: {{ $question['unit'] }}</small>
                @endif
            </div>
        @elseif($question['type'] === 'text')
            <div class="form-group">
                <input type="text" name="answer" id="answer" class="form-control"
                    value="{{ is_array($answer->answer ?? null) ? '' : $answer->answer ?? '' }}" required>
            </div>
        @else
            <div class="form-group">
                <input type="text" name="answer" id="answer" class="form-control"
                    value="{{ is_array($answer->answer ?? null) ? '' : $answer->answer ?? '' }}" required>
            </div>
        @endif

        <div class="mt-10 mb-5 flex flex-wrap gap-2 justify-center flex-col">
            <button type="submit" class="btn btn-primary">Kemaskini Jawapan</button>
            <a href="{{ route('survey.review', $section) }}" class="btn btn-secondary">Kembali ke Semakan</a>
        </div>
    </form>
@endsection
