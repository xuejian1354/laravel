@section('content')
<div class="row">
  <div class="col-md-8">
    @include('devstats.devlist')
    <div class="box box-default">
      <div class="box-header with-border">
        <i class="fa fa-h-square"></i>
        <h3 class="box-title">智能贴士</h3>
      </div>
      <div class="box-body">
        <div class="alert alert-info alert-dismissible">
          <h4><i class="icon fa fa-info"></i> 设备统计</h4>
          <span>共用 {{ $pagetag->getAllcols() }} 个设备，其中 监测类 {{ App\Device::where('attr', 1)->count() }}，控制类 {{ App\Device::where('attr', 2)->count() }}</span>
        </div>
        <div class="alert alert-warning alert-dismissible">
          <h4><i class="icon fa fa-warning"></i> 状态警告</h4>
          <span>有 {{ App\Device::where('attr', '!=', 3)->where('data', null)->count() }} 个设备处于无数据状态</span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="box box-widget">
      <div class="box-header with-border"><h3 class="box-title">设备导航</h3></div>
      <div class="box-body" style="display: block;">
        <img class="img-responsive pad" src="/bower_components/AdminLTE/dist/img/photo2.png" alt="Photo">
        <p>I took this photo this morning. What do you guys think?</p>
      </div>
    </div>
  </div>
</div>
@endsection

@section('conscript')
<script type="text/javascript">
function selChangeCheck(sn, flag) {
	var selflag = $('#nametype'+sn).attr('selflag');
	if(selflag < 3) {
	  selflag = parseInt(selflag) + parseInt(flag);
	  $('#nametype'+sn).attr('selflag', selflag);
	}

	if(selflag == 3) {
	  $('#nametype'+sn).attr('selflag', selflag+1);
	  $('#selopt'+sn).html('<button type="button" class="btn btn-xs bg-purple" onclick="javascript:devSettingPost(\'' + sn + '\');"><b>设置</b></button>');
	  $('#devsettingall').removeClass('hidden');
	}
}

function devstaSwitch(devsn, data, at) {
  if(data == '打开' || data == '关闭') {
    $('#devsta'+devsn).removeClass('label-danger');
    $('#devsta'+devsn).addClass('label-success');
    $('#devsta'+devsn).text(data);
    $('#devat'+devsn).text(at);
  }
  else {
	$('#devsta'+devsn).addClass('label-danger');
	$('#devsta'+devsn).removeClass('label-success');
	$('#devsta'+devsn).text('离线');
  }
}

function devstaChange(devsn, data, at) {
  if(data.length > 0) {
    $('#devsta'+devsn).removeClass('label-danger');
	$('#devsta'+devsn).addClass('label-success');
	$('#devsta'+devsn).text(data);
	$('#devat'+devsn).text(at);
  }
  else {
    $('#devsta'+devsn).addClass('label-danger');
    $('#devsta'+devsn).removeClass('label-success');
    $('#devsta'+devsn).text('离线');
  }
}

function devSettingPost(devsn = null) {
  var devsettings = new Array();

  if(devsn != null) {
	devsettings.push({
		sn: devsn,
		name: $('#nametype' + devsn + ' option:selected').text(),
		type: $('#nametype' + devsn).val(),
		area: $('#area' + devsn).val()
	});
  }
  else {
	$('.devtr').each(function(){
	  if($(this).find('.selnametype').attr('selflag') > 3) {
		devsettings.push({
			sn: $(this).find('.devsna').text(),
			name: $.trim($(this).find('.selnametype option:selected').text()),
			type: $(this).find('.selnametype').val(),
			area: $(this).find('.selarea').val() 
		});
	  }
	});
  }

  var devstr = JSON.stringify(devsettings);

  $.post('/devsetting', { _token:'{{ csrf_token() }}', devs:devstr }, function(data, status) {
	  if(status != 'success') {
		alert("Status: " + status);
	  }
	  else {
		var devarrs = JSON.parse(data);
		for(x in devarrs) {
		  $('#selopt'+devarrs[x].sn).html('<span class="label label-success">成功</span>');
		  $('#devat'+devarrs[x].sn).text(devarrs[x].updated_at);
		}
	  }
  });
}

function devCtrlPost(sw, devsn) {
  $.post('/devctrl/'+devsn, { _token:'{{ csrf_token() }}', data:sw }, function(data, status) {
	  if(status != 'success') {
		alert("Status: " + status);
	  }
	  else {
		devstaSwitch(devsn, data[0], data[1]);
	  }
  });
}

function updateDevListPost(hid, pg) {
  $.post('/'+'{{ $request->path() }}',
    { _token:'{{ csrf_token() }}', way:hid, page:pg },
	function(data, status) {
	  if(status != 'success') {
		alert("Status: " + status);
	  }
	  else {
		$('#'+hid).html(data);
	  }
    }
  );
}
</script>

<script src="https://js.pusher.com/3.2/pusher.min.js"></script>
<script>
//Pusher.logToConsole = true;
var pusher = new Pusher("{{ env('PUSHER_KEY') }}", { encrypted: true});
var channel = pusher.subscribe('devdata-updating');
channel.bind('update', function(devdata) {
	console.log(JSON.stringify(devdata));
    $('.devtr').each(function() {
      var devsn = $(this).find('.devsna').text();
      if(devsn == devdata.sn) {
    	if(devdata.attr == 2) {
          devstaSwitch(devsn, devdata.data, devdata.updated_at);
        }
    	else {
    	  devstaChange(devsn, devdata.data, devdata.updated_at);
        }
      }
    });
});
</script>
@endsection

@extends('admin.dashboard')
