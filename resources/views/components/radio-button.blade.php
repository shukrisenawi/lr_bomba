<div class="flex flex-col">
    <label class="font-medium text-gray-700">{{ $label }}</label>
    <div class="flex flex-col-4 mt-2 flex-wrap">
        @php
            $id = strval($id);
            $value = strval($value);
        @endphp

        @foreach ($data as $key => $option)
            @php
                $check = $value && $key == $value ? 'checked="checked"' : '';
                // Handle both string and array/object formats
                $optionText = is_array($option) ? $option['text'] ?? ($option['label'] ?? '') : $option;
                $optionValue = is_array($option) ? $option['value'] ?? $key : $key;
            @endphp
            <div class="px-5 py-1">
                <input type="radio" id="{{ $id . '_' . $optionValue }}" name="{{ $id }}"
                    value="{{ $optionValue }}" class="radio radio-sm" {{ $check }}>
                <label class="cursor-pointer ml-2" for="{{ $id . '_' . $optionValue }}">{{ $optionText }}</label>
            </div>
        @endforeach

        @error($id)
            <div style="color: red;">{{ $message }}</div>
        @enderror

    </div>
</div>
