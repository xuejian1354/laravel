@section('content')
<!-- Info boxes -->
<div class="row">
@foreach($areaboxes as $areabox)
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
      <span class="info-box-icon {{ $areabox->color_class }}"><i class="fa {{ $areabox->icon_class }}"></i></span>
      <div class="info-box-content">
        <span class="info-box-number">{{ $areabox->title }}</span>
        <p class="info-box-text">
        @foreach($areabox->contents as $index => $areaboxcontent)
          {{ $areaboxcontent->key }}{{ $areaboxcontent->key && $areaboxcontent->val?'：':''}}<span id="devspan{{ $areaboxcontent->id }}">{{ $areaboxcontent->val }}</span><br>
        @endforeach
        @while($index++ < 2)
          <br>
        @endwhile
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
  <!-- Left col -->
  <div class="col-md-8">
  @include('areactrl.devlist')
  </div>
  <!-- /.col -->

  <div class="col-md-4">
    @if(App\Globalval::getVal('video_support'))
    <!-- MAP & BOX PANE -->
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">视频</h3>
        <div class="box-tools pull-right">
          <a id='vaddopt' href="/areactrl/{{ $area->sn }}/camadd" type="button" class="btn btn-box-tool"><i class="fa fa-plus"></i></a>
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
            <div id="hplay" class="embed-responsive-item">
		      <script type="text/javascript" src="/sewise.player.min.js?server=live&type=rtmp&streamurl={{ $video_file['url'] }}&title={{ $video_file['name'] }}&autostart=true&skin=liveWhite"></script>
		    </div>
		    @endif
	      </div>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
    @else
    <div class="box box-widget">
      <div class="box-header with-border"><h3 class="box-title">大棚介绍</h3></div>
      <div class="box-body" style="display: block;">
        <img class="img-responsive pad" src="/img/warmhouse.jpg" alt="Photo">
        <p>I took this photo here. What do you guys think?</p>
      </div>
    </div>
    @endif
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
@endsection

@section('conscript')
<!-- Sparkline -->
<script src="/adminlte/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="/adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>

<script>
$(function(){
  wsConnect(function(devdata) {
    console.log(devdata);
    devdata = JSON.parse(devdata);
    if(devdata.attr == 1) {
      for(x in devdata.areaboxcontents) {
        for (item in devdata.areaboxcontents[x]){
          $('#devspan'+item).text(devdata.areaboxcontents[x][item]);
        }
      }
    }
    else if(devdata.attr == 2) {
      $('.devtr').each(function() {
        var devsn = $(this).find('.devsna').text();
        if(devsn == devdata.sn) {
    	  devstaChange(devsn, devdata.data, devdata.updated_at);
        }
      });
    }
  });
})
</script>
@endsection

@extends('admin.dashboard')