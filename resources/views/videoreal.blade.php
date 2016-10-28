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
          <video id="vplay" class="embed-responsive-item" preload="auto" loop allowfullscreen controls autoplay>
  		    <source src="{{ $video_rand['url'] }}" type="video/mp4">
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

function refreshVideo(type, id, val) {
	var name = $.trim($('#'+id).text());
	if(name.length == 0) {
      name = $.trim($('#'+id).val());
	}
	$('#vtitle').text(name);

	if(type == 'mp4') {
	  $('#viewplace').html('<video id="vplay" class="embed-responsive-item" allowfullscreen controls autoplay><source src="' + val + '" type="video/mp4"><\/video>');
	  $('#vplay source').attr('src', val);
	  $('#vplay').load();
	}
	else if(type == 'm3u8') {
	  $('#viewplace').html('<div id="hplay" class="embed-responsive-item"><script type="text/javascript" src="/sewise.player.min.js?server=vod&type=' + type + '&videourl=' + val + '&autostart=true&skin=vodWhite"><\/script><\/div>');
	}
}

function videolistSetting() {
  var flag = $('#vsetopt').attr('isset');
  if(flag == 1) {
    $('#vaddopt').addClass('disabled');
    $('#vaddopt').addClass('hidden');
    $('#vsetopt').removeAttr('isset');
    $('#vsetopt i').removeClass('fa-remove');
    $('#vsetopt i').addClass('fa-cog');

    $('.videom3u8').each(function() {
      var ainput = $(this).find('input');
      $(this).html('<br><a id="' + ainput.attr('id') + '" href="' + ainput.attr('href') + '" class="product-description">' + ainput.val() + '</a>');
    });
  }
  else {
    $('#vaddopt').removeClass('disabled');
    $('#vaddopt').removeClass('hidden');
    $('#vsetopt').attr('isset', 1);
    $('#vsetopt i').removeClass('fa-cog');
    $('#vsetopt i').addClass('fa-remove');

    $('.videom3u8').each(function() {
      var vname = $(this).text();
      var ahref = $(this).find('a');
      $(this).html('<br><input id="' + ahref.attr('id') + '" href="' + ahref.attr('href') + '" onblur="javascript:edtCam(\'' + ahref.attr('id') + '\');" type="text" value="' + $.trim(vname) + '" style="border: 0; width: 85%;"><a href="javascript:delCam(\'' + ahref.attr('id') + '\');" class="pull-right" style="margin-left: 10px;"><i class="fa fa-trash-o"></i></a>');
    });
  }
}

function edtCam(id) {
  $.post('/videoreal/camedt', { _token:'{{ csrf_token() }}', sn:id, name:$('#'+id).val() },
    function(data, status) {
      if(status != 'success') {
	    alert("Status: " + status);
      }
      else {
      }
  });
}

function delCam(id) {
  if(confirm('是否删除该设备？')) {
    $.post('/videoreal/camdel', { _token:'{{ csrf_token() }}', sn:id },
      function(data, status) {
        if(status != 'success') {
	      alert("Status: " + status);
        }
        else if(data == 'OK'){
          $('#vitem'+id).remove();
          $('.products-list').append('<li class="item" style="height: 71px;"></li>');
        }
    });
  }
}
</script>
@endsection

@extends('admin.dashboard')
