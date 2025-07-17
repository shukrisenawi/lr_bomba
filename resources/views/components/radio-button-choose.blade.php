<div class="flex flex-col mb-3">
    <label class="font-medium text-gray-700">{{ $label }}</label>
    <div class="flex items-center space-x-4 mt-2">
        @php
            $data=[
                1=>[5=>"Sangat Baik", 4=>"Agak Baik", 3=>"Sederhana", 2=>"Agak Teruk", 1=>"Sangat Teruk"],
                2=>[ 4=>"Selalu", 3=>"Hampir sentiasa", 2=>"Kadang-kadang", 1=>"Jarang-jarang", 0=>"Tidak pernah"],
                3=>[1=> "Sangat tidak setuju", 2=>"Tidak setuju", 3=>"setuju", 4=>"Sangat setuju"],
                4=>[ 0=> "Jarang Sekali", 1=> "Jarang", 2=>"Kadang-kadang", 3=>"Selalu", 4=>"Sentiasa"],
                5=>[4=>"Tidak pernah", 3=>"Jarang", 2=>"Kadang-kadang", 1=>"Selalu", 0=>"Sering"],
                6=>[ 0=>"Tidak pernah", 1=>"Jarang-jarang", 2=>"Kadang-kadang", 3=>"Kerap", 4=>"Sepanjang masa"],
                7=>[ 0=>"Jarang/Kurang dari 1 hari",1=>"Kadang-kadang/1-2 hari",2=>"Kerap kali/3-4 hari", 3=> "Pada setiap masa/5-7 hari"],
                8=>[1=>"Tidak pernah", 2=>"Jarang sekali", 3=>"Kadang-kadang", 4=>"Selalu", 5=>"Sentiasa"]

        ];
        @endphp
    @foreach ( $data[$choose] as $key=>$value )
        <div class="flex gap-3 text-[15px]">
            <input type="radio" id="{{ $id."_".$key }}" name="{{ $id }}" value="{{ $key }}" class="radio radio-sm">
            <label class="cursor-pointer" for="{{ $id."_".$key }}">{{ $value }}</label>
        </div>
    @endforeach
    </div>
</div>