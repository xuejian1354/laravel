@section('content')
<div class="row">
@foreach($areaboxes as $pos => $areabox)
  <div class="col-md-4 col-sm-4 col-xs-12">
    <div class="info-box">
      <a href="" class="info-box-icon {{ $areabox->color_class }}" data-target="#myCarousel" data-slide-to="{{ $pos+1 }}"><i class="fa {{ $areabox->icon_class }}"></i></a>
      <div class="info-box-content">
        <span class="info-box-number">{{ $areabox->title }}</span>
        <p class="info-box-text">
        @foreach($areabox->contents as $index => $areaboxcontent)
          {{ $areaboxcontent->key }}{{ $areaboxcontent->key && $areaboxcontent->val?'：':''}}<span id="devspan{{ $areaboxcontent->id }}">{{ $areaboxcontent->val }}</span><br>
        @endforeach
        @if(isset($index))
        @while($index++ < 2)
          <br>
        @endwhile
        @endif
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
    <div class="box box-info">
      <div class="box-header with-border">
        <span class="box-title">控制设备</span>
        <div class="box-tools pull-right">
          <div class="btn-group">
            <a type="button" class="btn btn-default btn-sm" href="#myCarousel" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
            <a type="button" class="btn btn-default btn-sm" href="#myCarousel" data-slide="next"><i class="fa fa-chevron-right"></i></a>
          </div>
        </div>
      </div>
      <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
        <div class="carousel-inner" role="listbox">
          <div class="item active">
          @include('areactrl.devlist')
          </div>
          @foreach($areaboxes as $areabox)
          <div class="item">
            <p>{{ $areabox->title }}</p>
          </div>
          @endforeach
        </div>
      </div>
    </div>
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
      <div class="box-header with-border"><h3 class="box-title">养猪厂介绍</h3></div>
      <div class="box-body" style="display: block;">
        <img class="img-responsive pad" src="/img/hogpen.jpg" alt="Photo">
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