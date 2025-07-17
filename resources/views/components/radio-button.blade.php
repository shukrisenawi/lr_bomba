<div class="flex flex-col">
    <label class="font-medium text-gray-700">{{ $label }}</label>
    <div class="flex items-center space-x-4 mt-2">

    @foreach ( $data as $key=>$value )
        <div>
            <input type="radio" id="{{ $id."_".$key }}" name="{{ $id }}" value="{{ $key }}" class="radio radio-sm">
            <label class="cursor-pointer" for="{{ $id."_".$key }}" class="ml-2">{{ $value }}</label>
        </div>
    @endforeach

    </div>
</div>