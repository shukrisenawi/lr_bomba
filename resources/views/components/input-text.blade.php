<div class="flex flex-col">
    @php
        $id = strval($id);
    @endphp
    <label for="{{ $id }}" class="font-medium text-gray-700">{{ $label }}</label>
    <input {{ $attributes }} name="{{ $id }}" id="{{ $id }}" class="input w-full mt-3"
        autocomplete="off">

    @error($id)
        <div style="color: red; text-sm; font-bold">{{ $message }}</div>
    @enderror

</div>
