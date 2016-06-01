@section('userclassgrade')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h5 style="float: right;">当前用户: {{ $user->name }}<br>
  <a href="admin?action=usermanage&tabpos={{ $user->grade-1 }}" style="float: right; margin-top: 5px;">用户返回</a></h5>
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  <h3>1. 教室使用</h3>
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
  @if($user->privilege > 3)
  <h3 style="margin-top: 20px;">2. 智能操作</h3>
  <span>选择教室：</span>
  <select id="optsel" class="setselect">
    <option class="setblank"></option>
  @foreach($rooms as $room)
    <option roomsn="{{ $room->sn }}">{{ $room->name }}</option>
  @endforeach
  </select>
  <div id="optlist" style="margin-top: 10px;">
  </div>
  @endif
</div>

<script type="text/javascript">
function loadQueryRooms()
{
	var tobj = new Object();
	tobj.time = $('#querytime').val();
	if(tobj.time == null || tobj.time == '无')
	{
		tobj.time = undefined;
	}

	tobj.method = $('#querychr').attr('method');
	if(tobj.method == 1)
	{
		tobj.roomnamesn = $('#roomnamesn').val();
		if(tobj.roomnamesn == null || tobj.roomnamesn == '无')
		{
			tobj.roomnamesn = undefined;
			if(tobj.time == undefined)
			{
				alert('请设置查询条件');
				return;
			}
		}
	}
	else
	{
		tobj.roomtype = $('#roomtype option:selected').attr('roomtype');
		tobj.roomaddr = $('#roomaddr option:selected').attr('roomaddr');
		if(tobj.roomtype == '无')
		{
			tobj.roomtype = undefined;
		}

		if(tobj.roomaddr == '无')
		{
			tobj.roomaddr = undefined;
		}

		if(tobj.roomtype == undefined && tobj.roomaddr == undefined && tobj.time == undefined)
		{
			alert('请设置查询条件');
			return;
		}
	}

	//alert(JSON.stringify(tobj));
	loadContent('queryRoomlist', '/admin?action=userclassgrade/queryroom&data='+JSON.stringify(tobj));
}

$('#querychr').change(function(){
	if($(this).val() == '条件查询')
	{
		$('.curquery').addClass('hidden');
		$('.conquery').removeClass('hidden');
		$('#querychr').attr('method', '2');
	}
	else
	{
		$('.curquery').removeClass('hidden');
		$('.conquery').addClass('hidden');
		$('#querychr').attr('method', '1');
	}

	$('#roomnamesn').val('');
	$('.setselect').val('');
});

@if($user->privilege > 3)
$('#optsel').change(function(){
	var roomsn = $('#optsel option:selected').attr('roomsn');
	loadContent('optlist', '/admin?action=userclassgrade/opt&roomsn='+roomsn);
});
@endif

$('.setblank').remove();
$('.setselect').val('');
</script>
@endsection