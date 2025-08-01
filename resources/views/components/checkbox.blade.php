<div class="flex flex-col">
    <label class="font-medium text-gray-700">{{ $label }}</label>
    <div class="flex items-center space-x-4 mt-2">

        @foreach ($data as $key => $value)
            <div>
                <input type="checkbox" id="{{ $id . '_' . $key }}" name="{{ $id }}" value="{{ $key }}"
                    class="form-checkbox text-blue-500">
                <label for="{{ $id . '_' . $key }}" class="ml-2">{{ $value }}</label>
            </div>
        @endforeach
        @if (is_string($id))
            @error($id)
                <div style="color: red;">{{ $message }}</div>
            @enderror
    </div>
</div>
