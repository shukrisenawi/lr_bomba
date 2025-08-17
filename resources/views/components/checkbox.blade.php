<div class="flex flex-col">
    <label class="font-medium text-gray-700">{{ $label }}</label>
    <div class="flex items-center flex-wrap space-x-4 mt-2">
        @php
            // if (request()->isMethod('post')) {
            //     dd($data_value);
            // }
            $data_value_array = old('health_issue', '[]')
                ? json_decode(json_encode(old('health_issue', '[]')), true)
                : [];
        @endphp
        @foreach ($data as $key => $value)
            <div>
                @php
                    $lainChecked = strtoupper($value) == 'LAIN-LAIN' ? '@click="open = !open"' : '';
                @endphp
                <input type="checkbox" id="{{ $id . '_' . $key }}" name="{{ $id }}[]" value="{{ $key }}"
                    class="checkbox" {!! $lainChecked !!} @if (is_array($data_value_array) && in_array($value, $data_value_array)) checked @endif>
                <label for="{{ $id . '_' . $key }}" class="ml-2">{{ $value }}</label>
            </div>
        @endforeach
        {{-- @error($id)
            <div style="color: red;">{{ $message }}</div>
        @enderror --}}
    </div>
</div>
