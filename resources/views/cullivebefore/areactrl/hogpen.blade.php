@section('content')
<div class="row">
@foreach($areaboxes as $pos => $areabox)
  <div class="col-md-4 col-sm-4 col-xs-12">
    <div class="info-box">
      <button class="btn btn-link info-box-icon {{ $areabox->color_class }}" onclick="javascript:$('#box-title').text('{{ $areabox->title }}');" data-target="#myCarousel" data-slide-to="{{ $pos+1 }}"><i class="fa {{ $areabox->icon_class }}"></i></button>
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
        <span id="box-title" class="box-title">控制设备</span>
        <div class="box-tools pull-right">
          <div class="btn-group">
            <button class="btn btn-default btn-sm" onclick="javascript:boxTitleUpdate('prev');" data-target="#myCarousel" data-slide="prev"><i class="fa fa-chevron-left"></i></button>
            <button class="btn btn-default btn-sm" onclick="javascript:boxTitleUpdate('next');" data-target="#myCarousel" data-slide="next"><i class="fa fa-chevron-right"></i></button>
          </div>
        </div>
      </div>
      <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
        <div class="carousel-inner" role="listbox">
          <div class="item active" boxtitle="控制设备">
            @include(config('cullivebefore.mainrouter').'.areactrl.devlist')
          </div>
          @foreach($areaboxes as $areabox)
          <div class="item" boxtitle="{{ $areabox->title }}">
            @include(config('cullivebefore.mainrouter').'.areactrl.devlist', ['listid' => $areabox->id, 'pagetag' => $areabox->pagetag, 'devices' => $areabox->devices])
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  <!-- /.col -->

  <div class="col-md-4">
    @if(App\Model\Globalval::getVal('video_support'))
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