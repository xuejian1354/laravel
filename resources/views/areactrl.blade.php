@if($area->type == '大棚')
  @include('areactrl.warmhouse')
@elseif($area->type == '鱼塘')
  @include('areactrl.fishpond')
@elseif($area->type == '养鸡场')
  @include('areactrl.henhouse')
@elseif($area->type == '养猪场')
  @include('areactrl.hogpen')
@endif
