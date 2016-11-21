@section('content')
<section class="content">
  <div class="callout callout-info">
    <h4>功能提示！</h4>
    <p>此处用于对设备详细数据记录查看</p>
  </div>
  <div class="row" style="margin-bottom: 10px;">
    <div class="col-sm-6 col-xs-6">
      <input id="countval" onblur="javascript:countValSet();" type="text" style="width: 24px; border:none; float: right;"/>
      <span style="float: right;">采样个数：</span>
      <div style="margin-right: 100px;"><input id="countslider" data-slider-id="red" type="text" hidden/></div>
    </div>
    <div class="col-sm-6 col-xs-6">
      <input id="timeline" onblur="javascript:timeValSet();" class="pull-right" style="width: 250px; border:none;"/>
      <span class="pull-right">时间段：</span>
    </div>
  </div>
  <div id="chart-content"></div>
</section>
@endsection

@section('conscript')
<script src="/adminlte/plugins/bootstrap-slider/bootstrap-slider.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="/adminlte/plugins/morris/morris.min.js"></script>
<script>
function countValSet() {
  var countval = parseInt($('#countval').val());
  $('#countslider').slider('setValue', countval); 
  var times = ($('#timeline').val()+'').split('~');

  getRecordsPost('{{$device->sn}}', countval, $.trim(times[0]), $.trim(times[1]));
}

function timeValSet() {
  var countval = parseInt($('#countval').val());
  $('#countslider').slider('setValue', countval); 
  var times = ($('#timeline').val()+'').split('~');

  getRecordsPost('{{$device->sn}}', countval, $.trim(times[0]), $.trim(times[1]));
}

function appendRecordsChart(record) {
  //$('#chart-content').html(record); return;
  var jp = JSON.parse(record);

  var chartdata = jp.data;
  var charttitle = jp.title;
  var chartcount = jp.count;
  var charttime = jp.timeline;

  $('#countslider').slider({
	  min: 0,
	  max: chartcount.totalnum,
	  step: 1,
	  value: chartcount.samnum,
	  formatter: function(value) {
		  return value;
	  }
  });

  $('#countslider').on( "slideStop", function(result){
	  var times = ($('#timeline').val()+'').split('~');
	  getRecordsPost('{{$device->sn}}', result.value, $.trim(times[0]), $.trim(times[1]));
	  $('#countval').val(result.value);
  });

  $('#countval').val( chartcount.samnum );

  time_start = new Date(charttime.start);
  time_end = new Date(charttime.end);
  if(time_start.Format("yyyy-MM-dd") == time_end.Format("yyyy-MM-dd")) {
  	$('#timeline').val(time_start.Format("yyyy-MM-dd hh:mm:ss") + ' ~ ' + time_end.Format("hh:mm:ss"));
  }
  else {
	$('#timeline').val(time_start.Format("yyyy-MM-dd hh:mm:ss") + ' ~ ' + time_end.Format("yyyy-MM-dd hh:mm:ss"));
  }

  $('#chart-content').html('');
  for(k in chartdata) {
	  $('#chart-content').append('<div class="box box-default"><div class="box-header with-border">'
			  + '<h3 class="box-title">' + charttitle[k] +'</h3></div>'
			  + '<div class="box-body"><div class="chart" id="record-chart-'+ k + '" style="height: 300px;"></div></div></div>');

	  var line = new Morris.Line({
	    element: 'record-chart-'+k,
	    resize: true,
	    data: chartdata[k],
	    xkey: 'x',
	    ykeys: ['y'],
	    labels: [k],
	    lineColors: ['#3c8dbc'],
	    hideHover: 'auto'
	  });
  }
}

function getRecordsPost(devsn, count, start, end) {
  $.post('/{{ $request->path() }}',
	{ _token:'{{ csrf_token() }}', sn:devsn, num:count, start_time:start, end_time:end },
	function(data, status) {
	  if(status != 'success') {
		alert("Status: " + status);
	  }
	  else {
		appendRecordsChart(data);
	  }
    }
  );
}

$(function() {
  Date.prototype.Format = function (fmt) { //author: meizz 
    var o = {
        "M+": this.getMonth() + 1, //月份 
        "d+": this.getDate(), //日 
        "h+": this.getHours(), //小时 
        "m+": this.getMinutes(), //分 
        "s+": this.getSeconds(), //秒 
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
        "S": this.getMilliseconds() //毫秒 
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
  }

  getRecordsPost('{{$device->sn}}');
});
</script>
@endsection

@extends('admin.dashboard')