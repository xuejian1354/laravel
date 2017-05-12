@section('content')
<!-- Info boxes -->
<div class="row">
@foreach($areaboxes as $pos => $areabox)
  @if($areabox->column == 4)
  <div class="col-md-3 col-sm-6 col-xs-12">
  @elseif($areabox->column == 3)
  <div class="col-md-4 col-sm-6 col-xs-12">
  @elseif($areabox->column == 2)
  <div class="col-md-6 col-sm-6 col-xs-12">
  @elseif($areabox->column == 1)
  <div class="col-md-12 col-sm-12 col-xs-12">
  @else
  <div class="col-md-4 col-sm-6 col-xs-12">
  @endif
    <div class="info-box">
      <button class="btn btn-link info-box-icon {{ $areabox->color_class }}"><i class="fa {{ $areabox->icon_class }}"></i></button>
      <div class="info-box-content">
        <span class="info-box-number">{{ $areabox->title }}</span>
        <p class="info-box-text" style="font-size: 20px; margin-top: 5px; text-transform: none;">
        @foreach($areabox->contents as $index => $areaboxcontent)
          {{ $areaboxcontent->key }}{{ $areaboxcontent->key && $areaboxcontent->val?'：':''}}<span id="devspan{{ $areaboxcontent->id }}">{{ $areaboxcontent->val }}</span><br>
        @endforeach
        </p>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
@endforeach
</div>
<!-- /.row -->

<!-- Main row -->
<div class="row">
  <div class="col-md-7">
    @if(App\Globalval::getVal('video_support'))
    <!-- MAP & BOX PANE -->
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">视频</h3>
        <div class="box-tools pull-right">
          <a id='vaddopt' href="/areactrl/{{ $area->sn }}/camadd" title="添加" type="button" class="btn btn-box-tool"><i class="fa fa-plus"></i></a>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body no-padding">
        <div class="pad">
          <div id="viewplace" class="embed-responsive embed-responsive-4by3">
            @if($video_file['type'] == 'mp4')
            <video id="vplay" class="embed-responsive-item" allowfullscreen controls autoplay>
  		      <source src="{{ $video_file['url'] }}" type="video/mp4">
	        </video>
	        @elseif($video_file['type'] == 'm3u8')
            <div id="hplay" class="embed-responsive-item">
		      <script type="text/javascript" src="/sewise.player.min.js?server=vod&type=m3u8&videourl={{ $video_file['url'] }}&title={{ $video_file['name'] }}&autostart=true&skin=vodWhite"></script>
		    </div>
		    @elseif($video_file['type'] == 'rtmp')
            <!-- div id="hplay" class="embed-responsive-item">
		      <script type="text/javascript" src="/sewise.player.min.js?server=live&type=rtmp&streamurl={{ $video_file['url'] }}&title={{ $video_file['name'] }}&autostart=true&skin=liveWhite"></script>
		    </div -->
		    <div id='hplay' class="embed-responsive-item">Video player not support</div>
		    <script type='text/javascript' src='/jwplayer/jwplayer.js'></script>
		    <script>jwplayer.key="ug0t4OFCQGuT+MAtmPobjyV4HqvzL4p/3KgXeA==";</script>
	        <script type='text/javascript'>
              jwplayer('hplay').setup({
                playlist: [{
                  sources: [{
                    file: '{{ $video_file["url"] }}'
                  }]
                }],
                autostart:true,
                aspectratio: "4:3",
                width: '100%',
                height: 'auto'
              });
	        </script>
		    @endif
	      </div>
        </div>
      </div>
      <!-- /.box-body -->
      @if($video_file['type'] == 'rtmp')
      <div class="box-footer clearfix">
        <div class="btn-group">
          <a id='vleftopt' onmousedown="javascript:camctrl('{{ $video_file['id'] }}', 'left');" onmouseup="javascript:camctrl('{{ $video_file['id'] }}', 'stop');" title="左移" type="button" class="btn btn-default btn-sm"><i class="fa fa-caret-left"></i></a>
          <a id='vupopt' onmousedown="javascript:camctrl('{{ $video_file['id'] }}', 'up');" onmouseup="javascript:camctrl('{{ $video_file['id'] }}', 'stop');" title="上移" type="button" class="btn btn-default btn-sm"><i class="fa fa-caret-up"></i></a>
          <a id='vdownopt' onmousedown="javascript:camctrl('{{ $video_file['id'] }}', 'down');" onmouseup="javascript:camctrl('{{ $video_file['id'] }}', 'stop');" title="下移" type="button" class="btn btn-default btn-sm"><i class="fa fa-caret-down"></i></a>
          <a id='vrightopt' onmousedown="javascript:camctrl('{{ $video_file['id'] }}', 'right');" onmouseup="javascript:camctrl('{{ $video_file['id'] }}', 'stop');" title="右移" type="button" class="btn btn-default btn-sm"><i class="fa fa-caret-right"></i></a>
          <a id='vstopopt' onclick="javascript:camctrl('{{ $video_file['id'] }}', 'stop');" title="停止" type="button" class="btn btn-default btn-sm"><i class="fa fa-stop"></i></a>
        </div>
      </div>
      @endif
    </div>
    <!-- /.box -->
    @else
    <div class="box box-widget">
      <div class="box-header with-border"><h3 class="box-title">鱼塘介绍</h3></div>
      <div class="box-body" style="display: block;">
        <img class="img-responsive pad" src="/img/aquaculture.png" alt="Photo">
        <p>I took this photo here. What do you guys think?</p>
      </div>
    </div>
    @endif
  </div>
  <!-- /.col -->

  <div class="col-md-5">
    <div class="box box-info">
      <div class="box-header with-border">
        <span id="box-title" class="box-title">控制设备</span>
      </div>
      <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
        <div class="carousel-inner" role="listbox">
          <div class="item active" boxtitle="控制设备">
            @include('areactrl.devlist')
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
<script type="text/javascript">
function camctrl(camsn, action) {
  $.post('/videoreal/camctrl', { _token:'{{ csrf_token() }}', sn:camsn, action:action },
	function(data, status) {
	  if(status != 'success') {
		alert("Status: " + status);
	  }
	  else {
	  }
    }
  );
}
</script>
@endsection