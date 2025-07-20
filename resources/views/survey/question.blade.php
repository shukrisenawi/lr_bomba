@extends('layouts.app')

@section('content')
    <div class="text-center w-full">
        <h2 class="text-2xl font-bold block m-0">
            {{ $sectionTitle }}<br>({{ $progress }}% siap)</h2>
    </div>

    <form method="POST" action="{{ route('survey.store', $section) }}" class="text-left p-5">
        @csrf
        <input type="hidden" name="question_id" value="{{ $question['id'] }}">

        <h4>{{ $question['text_BM'] ?? $question['text'] }}</h4>

        @if ($question['type'] === 'single_choice')
            <x-radio-button :data="$question['options']" :value="0">
                <x-slot:id>answer</x-slot:id>
                <x-slot:label></x-slot:label>
            </x-radio-button>
        @elseif($question['type'] === 'numeric')
            <div class="form-group">
                <x-input-text required>
                    <x-slot:id>answer</x-slot:id>
                    <x-slot:label></x-slot:label>
                </x-input-text>
                @if (isset($question['unit']))
                    <small class="text-muted">Unit: {{ $question['unit'] }}</small>
                @endif
            </div>
        @elseif($question['type'] === 'text')
            <div class="form-group">

                <x-input-text required>
                    <x-slot:id>answer</x-slot:id>
                    <x-slot:label></x-slot:label>
                </x-input-text>
            </div>
        @else
            <div class="form-group">

                <x-input-text required>
                    <x-slot:id>answer</x-slot:id>
                    <x-slot:label></x-slot:label>
                </x-input-text>
            </div>
        @endif

        <div class="mt-10 mb-5 flex flex-wrap gap-2 justify-center flex-col">
            <button type="submit" class="btn btn-primary">Hantar</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
    </form>
@endsection
