@php
    $active = isset($active) ? (int) trim($active) : 0;
@endphp

<ul class="steps -ml-5 -mr-10">
@for($i=1;$i<=12;$i++ )
@php
   if($i==0){
    $link ="/";

   }else{
    $link ="/part-".$i;
   }
@endphp
  <a href="{{ $link }}" class="step {{ $i < $active ? '' : ($i == $active ? 'step-primary' : '') }}"></a>
@endfor
</ul>

