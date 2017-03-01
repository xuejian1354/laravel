@if($device->rel_devopt->method == 'trigger')
<div class="btn-group">
  @for($index=0; $index<$device->rel_devopt->channel; $index++)
  <button type="button" class="btn btn-xs btn-info" onClick="javascript:devOptCtrl('{{ $device->sn }}', '{{ $device->psn }}', '{{ $device->rel_devopt->method }}', '{{ $device->rel_devopt->channel }}', '{{ $index }}', '{{ $device->rel_devopt->data }}');"><b>&nbsp;</b></button>
  @endfor
</div>
@elseif($device->rel_devopt->method == 'switch')
  @for($index=0; $index<$device->rel_devopt->channel; $index++)
  <div class="btn-group">
    @foreach(json_decode($device->rel_devopt->data) as $key => $val)
    <button type="button" class="btn btn-xs btn-info" onClick="javascript:devOptCtrl('{{ $device->sn }}', '{{ $device->psn }}', '{{ $device->rel_devopt->method }}', '{{ $device->rel_devopt->channel }}', '{{ $index }}', '{{ $val }}');"><b>{{ $key }}</b></button>
    @endforeach
  </div>
  @endfor
@else
<div class="btn-group">
  <button type="button" class="btn btn-xs btn-info" onClick="javascript:devCtrlPost('01', '{{ $device->sn }}', '{{ $device->psn }}');"><b>开</b></button>
  <button type="button" class="btn btn-xs btn-default" onClick="javascript:devCtrlPost('00', '{{ $device->sn }}', '{{ $device->psn }}');"><b>关</b></button>
</div>
@endif