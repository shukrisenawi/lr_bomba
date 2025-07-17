<div class="mt-5">
<x-steps>
    <x-slot:active>{{ $active??0 }}</x-slot:active>
</x-steps>

</div>

<div class="my-10 flex justify-between">
<div>
 <a href="/" class="p-3btn btn btn-neutral btn-outline"><i class="fa fa-home"></i> Halaman Utama</a>
</div>
<div class="flex">
  <a href="{{ $link1 }}" class="p-3 btn btn-soft btn-neutral"><< Kembali</a>&nbsp;&nbsp;<a href="{{ $link2 }}" class="p-3 btn btn-soft btn-neutral">Seterusnya>></a>
</div>

</div>