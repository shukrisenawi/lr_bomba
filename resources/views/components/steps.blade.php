@php
    $active = isset($active) ? (int) trim($active) : 0;
@endphp

<ul class="steps steps-vertical absolute -ml-5">
@for($i=0;$i<=13;$i++ )
@php
   if($i==0){
    $link ="/";

   }else{
    $link ="/part-".$i;
   }
@endphp
  <a href="{{ $link }}" class="step {{ $i < $active ? 'step-success' : ($i == $active ? 'step-primary' : '') }}"></a>
@endfor
</ul>