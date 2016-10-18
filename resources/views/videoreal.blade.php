@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 id="vtitle" class="box-title">{{ $video_rand['name'] }}</h3>
      </div>
      <div class="box-body">
        <div id="viewplace" class="embed-responsive embed-responsive-4by3">
          @if($video_rand['type'] == 'mp4')
          <video id="vplay" class="embed-responsive-item" allowfullscreen controls autoplay>
  		    <source src="{{ '/video/'.$video_rand['name'] }}" type="video/mp4">
	      </video>
	      @endif
	      @if($video_rand['type'] == 'm3u8')
          <div id="hplay" class="embed-responsive-item">
		    <script type="text/javascript" src="/sewise.player.min.js?server=vod&type={{ $video_rand['type'] }}&videourl={{ $video_rand['url'] }}&autostart=true&skin=vodWhite"></script>
		  </div>
		  @endif
	    </div>
	  </div>
    </div>
  </div>
  <div class="col-md-4">
    @include('videoreal.videolist')
  </div>  
</div>
@endsection

@section('conscript')
<script>
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

function refreshVideo(type, val) {
	$('#vtitle').text(val);
	if(type == 'mp4') {
	  $('#viewplace').html('<video id="vplay" class="embed-responsive-item" allowfullscreen controls autoplay><source src="/video/' + val + '" type="video/mp4"><\/video>');
	  $('#vplay source').attr('src','/video/'+val);
	  $('#vplay').load();
	}
	else if(type == 'm3u8') {
	  $('#viewplace').html('<div id="hplay" class="embed-responsive-item"><script type="text/javascript" src="/sewise.player.min.js?server=vod&type=' + type + '&videourl=' + val + '&autostart=true&skin=vodWhite"><\/script><\/div>');
	}
}

function getHLSList()
{
  $.ajax({
    url: 'http://loongsky3.net:8088/api/getHLSList',
	contentType: 'application/x-www-form-urlencoded; charset=utf-8', 
    method: 'POST',
    dataType: 'json',
	cache: false,
	async: false,
    data: { },
    success: function (json) {
	  alert(JSON.stringify(json));
    },
	error:function(msg) {
	  alert(JSON.stringify(msg));
	}
  });
}
</script>
@endsection

@extends('admin.dashboard')
