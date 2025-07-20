@extends('layouts.app')

@section('content')
    <div class="text-center w-full">
        <h2 class="text-2xl font-bold block m-0">
            {{ $sectionTitle }}<br>({{ $progress }}% siap)
        </h2>

        @if (isset($debug_info))
            <div class="text-sm text-gray-600 mt-2">
                Soalan: {{ $debug_info['total_questions'] }} |
                Dijawab: {{ $debug_info['answered'] }} |
                Baki: {{ $debug_info['remaining'] }}
            </div>
        @endif
    </div>

    <form method="POST" action="{{ route('survey.store', $section) }}" class="text-left p-5">
        @csrf
        <input type="hidden" name="question_id" value="{{ $question['id'] }}">

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h4 class="text-lg font-semibold mb-4">{{ $question['text_BM'] ?? $question['text'] }}</h4>

            @if (isset($question['description_BM']))
                <p class="text-sm text-gray-600 mb-4">{{ $question['description_BM'] }}</p>
            @endif

            @if ($question['type'] === 'single_choice')
                <div class="space-y-3">

                    @foreach ($question['options'] as $key => $option)
                        @php
                            $optionText = is_array($option) ? $option['text'] ?? ($option['label'] ?? '') : $option;
                            $optionValue = is_array($option) ? $option['value'] ?? $key : $key;

                        @endphp
                        <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="radio" name="answer" value="{{ $key }}"
                                class="mr-3 radio radio-primary" required>
                            <span class="text-sm">{{ $optionText }}</span>
                        </label>
                    @endforeach
                </div>
            @elseif($question['type'] === 'numeric')
                <div class="form-group">
                    <x-input-text required>
                        <x-slot:id>answer</x-slot:id>
                        <x-slot:label></x-slot:label>
                        <x-slot:placeholder>Masukkan nilai</x-slot:placeholder>
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
                        <x-slot:placeholder>Masukkan jawapan</x-slot:placeholder>
                    </x-input-text>
                </div>
            @else
                <div class="form-group">
                    <x-input-text required>
                        <x-slot:id>answer</x-slot:id>
                        <x-slot:label></x-slot:label>
                        <x-slot:placeholder>Masukkan jawapan</x-slot:placeholder>
                    </x-input-text>
                </div>
            @endif
        </div>

        <div class="mt-10 mb-5 flex flex-wrap gap-2 justify-center flex-col">
            <button type="submit" class="btn btn-primary w-full max-w-xs mx-auto">Hantar Jawapan</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary w-full max-w-xs mx-auto">Kembali ke Dashboard</a>
        </div>
    </form>
@endsection
