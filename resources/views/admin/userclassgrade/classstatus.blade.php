<div>
  <div>
    <span>选择时间：</span>
    <select id="querytime" class="setselect">
      <option class="setblank"></option>
      @foreach($weektimes as $weektime)
      <option>{{ $weektime }}</option>
      @endforeach
      <option class="setnone">无</option>
    </select>
  </div>
  <div>
    <div style="margin-top: 10px;">
      <span>查询方式：</span>
      <select id="querychr" method="1">
        <option>精确查询</option>
        <option>条件查询</option>
      </select>
    </div>
    <div class="curquery" style="margin-top: 10px;">
      <span>教室：</span>
      <select id="roomnamesn" class="setselect">
        <option class="setblank"></option>
        @foreach($rooms as $room)
        <option roomsn="{{ $room->sn }}">{{ $room->name }}</option>
        @endforeach
        <option class="setnone">无</option>
      </select>
    </div>
    <div class="conquery hidden" style="margin-top: 10px;">
      <span>选择类型：</span>
      <select id="roomtype" class="setselect">
        <option class="setblank"></option>
        @foreach($roomtypes as $roomtype)
        <option roomtype="{{ $roomtype->roomtype }}">{{ $roomtype->str }}</option>
        @endforeach
        <option class="setnone">无</option>
      </select>
      <span style="margin-left: 10px;">选择地点：</span>
      <select id="roomaddr" class="setselect">
        <option class="setblank"></option>
        @foreach($roomaddrs as $roomaddr)
        <option roomaddr="{{ $roomaddr->roomaddr }}">{{ $roomaddr->str }}</option>
        @endforeach
        <option class="setnone">无</option>
      </select>
    </div>
  </div>
  <button onclick="javascript:loadQueryRooms();" class="btn btn-primary" style="margin-top: 10px;">查询</button>
  <div id="queryRoomlist" style="margin-top: 10px;">
  </div>
</div>