@section('content')
<section class="content">
  <div class="callout callout-info">
    <h4>功能提示！</h4>
    <p>此处用于对设备进行修改、设置 或 <a href="javascript:devDelPost();"">删除</a></p>
  </div>

  <div class="box">
    <div class="box-header with-border"><h3 class="box-title">属性设置</h3></div>
      <div class="box-body">
      <table class="table table-bordered">
        <tr>
          <th width="60px">#</th>
          <th>键</th>
          <th>值</th>
        </tr>
        <tr>
          <td>1</td>
          <td>序列号</td>
          <td id="devsn">{{ $device->sn }}</td>
        </tr>
        <tr>
          <td>2</td>
          <td>名称</td>
          <td><input id="devname" type="text" onkeydown="javascript:devNameEdt();" style="border:none;" value="{{ $device->name }}"></td>
        </tr>
        <tr>
          <td>3</td>
          <td>类型</td>
          <td>
            <select id="devtype" onchange="javascript:devTypeEdt();" style="appearance:none; -moz-appearance:none; -webkit-appearance:none; border:0;">
              <option disabled selected hidden></option>
            @for($index=2; $index<count($devtypes); $index++)
              @if($devtypes[$index]->id == $device->type)
              <option selected value="{{ $devtypes[$index]->id }}">{{ $devtypes[$index]->name }}</option>
              @else
              <option value="{{ $devtypes[$index]->id }}">{{ $devtypes[$index]->name }}</option>
              @endif
            @endfor
            </select>
          </td>
        </tr>
        <tr>
          <td>4</td>
          <td>地点</td>
          <td>
            <select id="devarea" onchange="javascript:devAreaEdt();" style="appearance:none; -moz-appearance:none; -webkit-appearance:none; border:0;">
              <option disabled selected hidden></option>
            @foreach($areas as $area)
              @if($area->sn == $device->area)
              <option selected value="{{ $area->sn }}">{{ $area->name }}</option>
              @else
              <option value="{{ $area->sn }}">{{ $area->name }}</option>
              @endif
            @endforeach
            </select>
          </td>
        </tr>
        <tr>
          <td>5</td>
          <td>数据</td>
          <td><input id="devdata" type="text" onkeydown="javascript:devDataEdt();" style="border:none;" value="{{ $device->data }}"></td>
        </tr>
        <tr>
          <td>6</td>
          <td>报警阈值</td>
          <td>{{ $device->alarmthres }}</td>
        </tr>
        <tr>
          <td>7</td>
          <td>所有者</td>
          <td>
            <select id="devowner" onchange="javascript:devOwnerEdt();" style="appearance:none; -moz-appearance:none; -webkit-appearance:none; border:0;">
              <option disabled selected hidden></option>
            @foreach($users as $user)
              @if($user->sn == $device->owner)
              <option selected value="{{ $user->sn }}">{{ $user->name }}</option>
              @else
              <option value="{{ $user->sn }}">{{ $user->name }}</option>
              @endif
            @endforeach
            </select>
          </td>
        </tr>
        <tr>
          <td>8</td>
          <td>更新时间</td>
          <td id="devat">{{ $device->updated_at }}</td>
        </tr>
      </table>
      </div>
  </div>
</section>
@endsection

@section('conscript')
<script>
function devNameEdt(e) {
  var e = e || window.event; 
  if(e.keyCode == 13) {
	devEdtPost('nameedt', $('#devname').val());
  }
}

function devTypeEdt() {
  $('#devtype').val();

  var namestr = $('#devtype option:selected').text()+$('#devsn').text().substring(2);
  $('#devname').val(namestr);

  devEdtPost('typeedt', $('#devtype option:selected').val());
}

function devAreaEdt() {
  devEdtPost('areaedt', $('#devarea option:selected').val());
}

function devDataEdt() {
  var e = e || window.event; 
  if(e.keyCode == 13) {
    devEdtPost('dataedt', $('#devdata').val());
  }
}

function devAlarmEdt() {
  alert('devAlarmEdt');
}

function devOwnerEdt() {
  devEdtPost('owneredt', $('#devowner option:selected').val());
}

function devDelPost() {
  var devname = $.trim($('#devname').val());
  if(devname.length == 0) {
    devname = $('#devsn').text();
  }

  if(confirm('确定要从列表中删除『' + devname + '』？')) {
	$.post('/'+'{{ $request->path() }}', { _token:'{{ csrf_token() }}', way:'del', sn:'{{ $device->sn }}' },
	  function(data, status) {
	    if(status != 'success') {
		  alert("Status: " + status);
	    }
	    else {
		  if(data == 'OK') {
			location.reload();
		  }
		  else {
			alert(data);
		  }
	    }
      }
    );
  }
}

function devEdtPost(key, val) {
  $.post('/'+'{{ $request->path() }}', {_token:'{{ csrf_token() }}', way:key, sn:'{{ $device->sn }}', value:val},
	function(data, status) {
	  if(status != 'success') {
		alert("Status: " + status);
	  }
	  else {
		if(data != 'FAIL') {
          $('#devat').text(data);
		}
	  }
  });
}
</script>
@endsection

@extends('admin.dashboard')