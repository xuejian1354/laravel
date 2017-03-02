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
	      @elseif($video_rand['type'] == 'm3u8')
          <div id="hplay" class="embed-responsive-item">
		    <script type="text/javascript" src="/sewise.player.min.js?server=vod&type=m3u8&videourl={{ $video_rand['url'] }}&autostart=true&skin=vodWhite"></script>
		  </div>
		  @elseif($video_rand['type'] == 'rtmp')
          <!-- div id="hplay" class="embed-responsive-item">
		    <script type="text/javascript" src="/sewise.player.min.js?server=live&type=rtmp&streamurl={{ $video_rand['url'] }}&autostart=true&skin=liveWhite"></script>
		  </div -->
		  <div id='hplay' class="embed-responsive-item">Video player not support</div>
		  <script type='text/javascript' src='/jwplayer/jwplayer.js'></script>
		  <script>jwplayer.key="ug0t4OFCQGuT+MAtmPobjyV4HqvzL4p/3KgXeA==";</script>
	      <script type='text/javascript'>
            jwplayer('hplay').setup({
              playlist: [{
                sources: [{
                  file: '{{ $video_rand["url"] }}'
                }]
              }],
              autostart:true,
              aspectratio: "4:3",
              width: '100%',
              height: 'auto'
            });
	      </script>
		  @elseif($video_rand['type'] == 'sdp')
          <object id="hplay" type='application/x-vlc-plugin' pluginspage="http://www.videolan.org/">
		    <param name='mrl' value="{{ $video_rand['url'] }}" />
		    <param name='volume' value='50' />
		    <param name='autoplay' value='true' />
		    <param name='loop' value='false' />
		    <param name='fullscreen' value='false' />
		    <param name='controls' value='false' />
		  </object>
		  @endif
	    </div>
	  </div>
    </div>
  </div>
  <div class="col-md-4">
    @include(config('cullivebefore.mainrouter').'.videoreal.videolist')
  </div>  
</div>
@endsection

@section('conscript')
<script>
function refreshVideo(type, id, val) {
  var name = $.trim($('#'+id).text());
  if(name.length == 0) {
    name = $.trim($('#'+id).val());
  }

  if(type == 'mp4' || type == 'm3u8' || type == 'rtmp') {
    $('#vtitle').text(name);
  }

  if(type == 'mp4') {
    $('#viewplace').html(
                      '<video id="vplay" class="embed-responsive-item" '
				      + 'allowfullscreen controls autoplay>'
				      + '<source src="' + val + '" type="video/mp4"><\/video>');
    $('#vplay source').attr('src', val);
    $('#vplay').load();
  }
  else if(type == 'm3u8') {
  $('#viewplace').html(
                    '<div id="hplay" class="embed-responsive-item">'
                    + '<script type="text/javascript" '
                      + 'src="/sewise.player.min.js?'
                      + 'server=vod&type=' + type
                      + '&videourl=' + val
                      + '&autostart=true&skin=vodWhite"><\/script><\/div>');
  }
  else if(type == 'rtmp') {
    /*$('#viewplace').html(
                      '<div id="hplay" class="embed-responsive-item">'
                      + '<script type="text/javascript" '
                        + 'src="/sewise.player.min.js?'
                        + 'server=live&type=' + type
                        + '&streamurl=' + val
                        + '&autostart=true&skin=liveWhite"><\/script><\/div>');*/

    $('#viewplace').html(
                      '<div id="hplay" class="embed-responsive-item">Video player not support<\/div>'
                      + '<script type="text/javascript" src="/jwplayer/jwplayer.js"><\/script>'
                      + '<script>jwplayer.key="ug0t4OFCQGuT+MAtmPobjyV4HqvzL4p/3KgXeA==";<\/script>'
                      + '<script type="text/javascript">'
                        + 'jwplayer("hplay").setup({'
                          + 'playlist: [{'
                            + 'sources: [{'
                              + 'file: "' + val + '"'
                            + '}]'
                          + '}],'
                          + 'autostart:true,'
                          + 'aspectratio: "4:3",'
                          + 'width: "100%",'
                          + 'height: "auto"'
                        + '});'
                      + '<\/script>');
  }
}

function videolistSetting() {
  var flag = $('#vsetopt').attr('isset');
  if(flag == 1) {
    $('#vaddopt').addClass('disabled');
    $('#vaddopt').addClass('hidden');
    $('#vsetopt').removeAttr('isset');
    $('#vsetopt').attr('title', '设置');
    $('#vsetopt i').removeClass('fa-remove');
    $('#vsetopt i').addClass('fa-cog');

    $('.videom3u8,.videortmp,.videonone').each(function() {
      var ainput = $(this).find('input');
      $(this).html(
                '<a id="' + ainput.attr('id') + '" '
                + 'href="' + ainput.attr('href') + '" '
                + 'class="product-description" style="margin: 15px 0;">' + ainput.val() + '</a>');
    });
  }
  else {
    var videodev = new Array();
    $('.videom3u8,.videortmp,.videonone').each(function() {
      videodev.push($(this).find('a').attr('id'));
    });

    $.post('{{ config("cullivebefore.mainrouter") }}/videoreal/camattr', { _token:'{{ csrf_token() }}', sns:JSON.stringify(videodev) },
      function(data, status) {
        if(status != 'success') {
          alert("Status: " + status);
        }
        else {
          var camattrs = JSON.parse(data);

          $('#vaddopt').removeClass('disabled');
          $('#vaddopt').removeClass('hidden');
          $('#vsetopt').attr('isset', 1);
          $('#vsetopt').attr('title', '取消');
          $('#vsetopt i').removeClass('fa-cog');
          $('#vsetopt i').addClass('fa-remove');

          $('.videom3u8,.videortmp,.videonone').each(function() {
            var vname = $.trim($(this).text());
            var ahref = $(this).find('a');

            var vahref = ahref.attr('href');
            var vaid = ahref.attr('id');

            if(camattrs[vaid].rtmp_enable == 'true') {
              camattrs[vaid].rtmp_checked = 'checked="checked" ';
            }
            else {
              camattrs[vaid].rtmp_checked = '';
            }

            if(camattrs[vaid].hls_enable == 'true') {
              camattrs[vaid].hls_checked = 'checked="checked" ';
            }
            else {
              camattrs[vaid].hls_checked = '';
            }

            if(camattrs[vaid].rtsp_enable == 'true') {
              camattrs[vaid].rtsp_checked = 'checked="checked" ';
            }
            else {
              camattrs[vaid].rtsp_checked = '';
            }

            if(camattrs[vaid].storage_enable == 'true') {
              camattrs[vaid].storage_start = ' disabled';
              camattrs[vaid].storage_stop = '';
            }
            else {
              camattrs[vaid].storage_start = '';
              camattrs[vaid].storage_stop = ' disabled';
            }

@if(\App\Model\Globalval::getVal('matrix') == 'raspberrypi')
            $(this).html(
                      '<input id="' + vaid
                      + '" href="' + vahref
                      + '" onblur="javascript:edtCam(\'' + vaid + '\');" '
                      + 'type="text" value="' + vname + '" style="width: 50px; margin: 12px 0;">'
                      + '<div class="pull-right" style="margin: 14px 0;">'
                        + '<input id="rtmpcheck' + vaid + '" type="checkbox" '
                          + camattrs[vaid].rtmp_checked
                          + 'onclick="javascript:videoStreamCheck(\'rtmp\', \'' + vaid + '\');">'
                        + '<span style="margin-left: 1px;">RTMP</span>'
                        + '<input id="hlscheck' + vaid + '" type="checkbox" style="margin-left: 4px;"'
                          + camattrs[vaid].hls_checked
                          + 'onclick="javascript:videoStreamCheck(\'hls\', \'' + vaid + '\');" disabled hidden>'
                        + '<span style="margin-left: 1px;" hidden>hls</span>'
                        + '<input id="rtspcheck' + vaid + '" type="checkbox" style="margin-left: 4px;"'
                          + camattrs[vaid].rtsp_checked
                          + 'onclick="javascript:videoStreamCheck(\'rtsp\', \'' + vaid + '\');" disabled hidden>'
                        + '<span style="margin-left: 1px;" hidden>rtsp</span>'
                        + '<button onclick="javascript:delCam(\'' + vaid + '\');" '
                          + 'title="删除" class="btn btn-link pull-right" style="margin-left: 8px; padding: 0;">'
                          + '<i class="fa fa-trash-o"></i></button>'
                        + '<button id="storagestart' + vaid + '" title="停止" '
                          + 'onclick="javascript:videoStreamCheck(\'storage\', \'' + vaid + '\', false);" '
                          + 'class="btn btn-link pull-right"' + camattrs[vaid].storage_stop + ' '
                          + 'style="margin-left: 8px; padding: 0;">'
                          + '<i class="fa fa-stop-circle-o"></i></button>'
                        + '<button id="storagestop' + vaid + '" title="录制" '
                          + 'onclick="javascript:videoStreamCheck(\'storage\', \'' + vaid + '\', true);" '
                          + 'class="btn btn-link pull-right"' + camattrs[vaid].storage_start + ' '
                          + 'style="margin-left: 8px; padding: 0;">'
                          + '<i class="fa fa-play-circle-o"></i></button></div>');
@else
		    $(this).html(
		    		'<input id="' + vaid
                    + '" href="' + vahref
                    + '" onblur="javascript:edtCam(\'' + vaid + '\');" '
                    + 'type="text" value="' + vname + '" style="width: 50px; margin: 12px 0;">'
		            + '<div class="pull-right" style="margin: 14px 0;">'
		              + '<button onclick="javascript:delCam(\'' + vaid + '\');" '
		                + 'title="删除" class="btn btn-link pull-right" style="margin-left: 8px; padding: 0;">'
		                + '<i class="fa fa-trash-o"></i></button></div>');
@endif
          });
        }
    });
  }
}

function videoRecordListSetting(isset) {
  if(isset == 1) {
    updateCamListPost('{{ config("cullivebefore.mainrouter") }}/videoreal', 'videolist', '0', '{{ csrf_token() }}');
  }
  else {
    updateVideoListPost('{{ config("cullivebefore.mainrouter") }}/videoreal', 'videolist', 'mp4', '0', '{{ csrf_token() }}')
  }
}

function edtCam(id) {
  $.post('{{ config("cullivebefore.mainrouter") }}/videoreal/camedt', { _token:'{{ csrf_token() }}', sn:id, name:$('#'+id).val() },
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
    $.post('{{ config("cullivebefore.mainrouter") }}/videoreal/camdel', { _token:'{{ csrf_token() }}', sn:id },
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

function videoStreamCheck(action, id, check) {
  var checkval = false;
  if(action == 'storage') {
    checkval = check;
  }
  else {
    var ele = $('#' + action + 'check' +id);
    checkval = ele.prop('checked');
    if(checkval) {
      ele.prop('checked', false);
    }
    else {
      ele.prop('checked', true);
    }
  }

  $.post('{{ config("cullivebefore.mainrouter") }}/videoreal/camset',
    { _token:'{{ csrf_token() }}', action:action, sn:id, check:checkval },
    function(data, status) {
      if(status != 'success') {
        alert("Status: " + status);
      }
      else {
        if(action == 'storage') {
          if(check) {
            $('#storagestop'+id).attr('disabled', "disabled");
            $('#storagestart'+id).removeAttr('disabled');
          }
          else {
            $('#storagestop'+id).removeAttr('disabled');
            $('#storagestart'+id).attr('disabled', "disabled");
          }
        }
        else {
          var jsdata = JSON.parse(data);
          $('#proimg'+id).attr('href', "javascript:refreshVideo('" + jsdata.action + "', '" + jsdata.sn + "', '" + jsdata.url + "');");
          $('#'+id).attr('href', "javascript:refreshVideo('" + jsdata.action + "', '" + jsdata.sn + "', '" + jsdata.url + "');");
          ele.prop('checked', checkval);
        }
      }
  });
}

function updateCamListPost(path, hid, pg, token) {
  $.post(path, { _token:token, way:hid, page:pg },
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

function updateVideoListPost(path, hid, types, pg, token) {
  $.post(path, { _token:token, way:hid, edtypes:types, page:pg },
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
@endsection

@extends(config('cullivebefore.mainrouter').'.admin.dashboard')
