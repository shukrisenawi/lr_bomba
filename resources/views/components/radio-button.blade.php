<div class="flex flex-col">
    <label class="font-medium text-gray-700">{{ $label }}</label>
    <div class="flex flex-col-4 mt-2 flex-wrap">

        @foreach ($data as $key => $option)
            @php
                $check = $value && $key == $value ? 'checked="checked"' : '';
            @endphp
            <div class="px-5 py-1">
                <input type="radio" id="{{ $id . '_' . $key }}" name="{{ $id }}" value="{{ $key }}"
                    class="radio radio-sm" {{ $check }}>
                <label class="cursor-pointer" for="{{ $id . '_' . $key }}" class="ml-2">{{ $option }}</label>
            </div>
        @endforeach

    </div>
</div>
