<div class="flex flex-col">
    <label class="font-medium text-gray-700">{{ $label }}</label>
    <div class="flex items-center flex-wrap space-x-4 mt-2">
        @php
            $data_value_array = ($datavalue = json_decode($data_value)) && $datavalue != '[]' ?? '[]';
        @endphp
        @foreach ($data as $key => $value)
            <div>
                @php
                    $lainChecked = strtoupper($value) == 'LAIN-LAIN' ? '@click="open = !open"' : '';
                @endphp
                <input type="checkbox" id="{{ $id . '_' . $key }}" name="{{ $id }}[]" value="{{ $key }}"
                    class="checkbox" @if ($data_value_array && in_array($key, $data_value_array)) checked @endif>
                <label for="{{ $id . '_' . $key }}" class="ml-2">{{ $value }}</label>
            </div>
        @endforeach
        {{-- @error($id)
            <div style="color: red;">{{ $message }}</div>
        @enderror --}}
    </div>
</div>
