@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 id="vtitle" class="box-title">{{ $video_rand }}</h3>
      </div>
      <div class="box-body">
        <div class="embed-responsive embed-responsive-4by3">
          <video id="vplay" class="embed-responsive-item" allowfullscreen controls autoplay>
  		    <source src="{{ '/video/'.$video_rand }}" type="video/mp4">
	      </video>
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

function refreshVideo(name) {
	$('#vtitle').text(name);
	$('#vplay source').attr('src','/video/'+name);
	$('#vplay').load();
}
</script>
@endsection

@extends('admin.dashboard')
