@section('content')
<section id="chart-content" class="content">
  <div class="callout callout-info">
    <h4>功能提示！</h4>
    <p>此处用于对设备详细数据记录查看</p>
  </div>
</section>
@endsection

@section('conscript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="/adminlte/plugins/morris/morris.min.js"></script>
<script>
function appendRecordsChart(record) {
  //$('#chart-content').append(record);
  var jp = JSON.parse(record);

  var chartdata = jp.data;
  var charttitle = jp.title;
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

$(function() {
  $.post('/{{ $request->path() }}', { _token:'{{ csrf_token() }}', sn:'{{$device->sn}}' },
	function(data, status) {
	  if(status != 'success') {
		alert("Status: " + status);
	  }
	  else {
		appendRecordsChart(data);
	  }
    }
  );
});
</script>
@endsection

@extends('admin.dashboard')