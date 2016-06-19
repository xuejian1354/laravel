<span>选择教室：</span>
<select id="optsel" class="setselect">
  <option class="setblank"></option>
@foreach($rooms as $room)
  <option roomsn="{{ $room->sn }}">{{ $room->name }}</option>
@endforeach
</select>
<div id="optlist" style="margin-top: 10px;">
</div>
