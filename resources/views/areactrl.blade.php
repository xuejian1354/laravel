@if($area->type == '大棚')
  @include('areactrl.warmhouse')
@elseif($area->type == '鱼塘')
  @include('areactrl.fishpond')
@elseif($area->type == '养鸡厂')
  @include('areactrl.henhouse')
@elseif($area->type == '养猪厂')
  @include('areactrl.hogpen')
@endif

@section('conscript')
<!-- Sparkline -->
<script src="/adminlte/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="/adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>

<script>
function boxTitleUpdate(dict) {
	if(dict == 'prev') {
		var it = $('.carousel .active').prev().attr('boxtitle');
		if(typeof(it) == 'undefined') {
			it = $('.carousel .item').last().attr('boxtitle');
		}
		$('#box-title').text(it);
	}
	else if(dict == 'next')
	{
		var it = $('.carousel .active').next().attr('boxtitle');
		if(typeof(it) == 'undefined') {
			it = $('.carousel .item').first().attr('boxtitle');
		}
		$('#box-title').text(it);
	}
}

$(function(){
  wsConnect(function(devdata) {
    console.log(devdata);
    devdata = JSON.parse(devdata);

	$.each(devdata.areaboxcontents, function(index, value) {
		$.each(devdata.areaboxcontents[index], function(y, val) {
			//console.log('y: ' + y + 'val: ' + val);
			$('#devspan'+y).text(val);
		});
	});

    $('.devtr').each(function() {
      var devsn = $(this).find('.devsna').text();
      if(devsn == devdata.sn) {
    	devstaChange(devsn, devdata.data, devdata.updated_at);
      }
    });

	if(typeof devdata.value != "undefined") {
		$('#selopt'+devdata.sn).text(devdata.value);
	}

  });

  @if(isset($devices[0]))
  devstaChange('{{ $devices[0]->sn }}', '{{ $devices[0]->data }}', '{{ $devices[0]->updated_at }}');
  @endif
})
</script>
@endsection

@extends('admin.dashboard')