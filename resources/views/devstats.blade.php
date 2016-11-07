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
function devNameTypeEdt(sn) {
  var namestr = $('#nametype' + sn + ' option:selected').text();
  var type = $('#nametype' + sn + ' option:selected').val();

  devEdtPost(sn, 'nameedt', namestr);
  devEdtPost(sn, 'typeedt', type);
}

function devAreaEdt(sn) {
  devEdtPost(sn, 'areaedt', $('#devarea' + sn + ' option:selected').val());
}

function devEdtPost(sn, key, val) {
  $.post('/devstats/device', {_token:'{{ csrf_token() }}', way:key, sn:sn, value:val},
	function(data, status) {
	  if(status != 'success') {
		alert("Status: " + status);
	  }
	  else {
		if(data != 'FAIL') {
          $('#devat'+sn).text(data.split(' ')[1]);
		}
	  }
  });
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

wsConnect(function(devdata) {
  console.log(devdata);
  devdata = JSON.parse(devdata);
  $('.devtr').each(function() {
    var devsn = $(this).find('.devsna').text();
    if(devsn == devdata.sn) {
      devstaChange(devsn, devdata.data, devdata.updated_at);
    }
  });
});
</script>
@endsection

@extends('admin.dashboard')
