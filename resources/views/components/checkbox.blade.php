<div class="flex flex-col">
    <label class="font-medium text-gray-700">{{ $label }}</label>
    <div class="flex items-center flex-wrap space-x-4 mt-2">
        @php
            $data_value_array =
                $data_value && !empty($data_value) && $data_value != '' ? json_decode($data_value) : false;
            // dd($data_value);
        @endphp
        @foreach ($data as $key => $value)
            <div>
                @php
                    $lainChecked = strtoupper($value) == 'LAIN-LAIN' ? '@click="open = !open"' : '';
                @endphp
                <input type="checkbox" id="{{ $id . '_' . $key }}" name="{{ $id }}" value="{{ $key }}"
                    {!! $lainChecked !!} class="checkbox" @if ($data_value_array && in_array($value, $data_value_array)) checked @endif>
                <label for="{{ $id . '_' . $key }}" class="ml-2">{{ $value }}</label>
            </div>
        @endforeach
        @if (is_string($id))
            @error($id)
                <div style="color: red;">{{ $message }}</div>
            @enderror
        @endif
    </div>
</div>
