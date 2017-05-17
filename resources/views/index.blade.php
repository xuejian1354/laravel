<!DOCTYPE html>
<!--
Landing page based on Pratt: http://blacktie.co/demo/pratt/
-->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width">
  <title>{{ trans('message.description') }}</title>
  <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('/adminlte/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/adminlte/plugins/fullcalendar/fullcalendar.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/adminlte/plugins/fullcalendar/fullcalendar.print.css') }}" media="print">
  <link rel="stylesheet" href="{{ asset('/adminlte/plugins/morris/morris.css') }}">
  <link rel="stylesheet" href="{{ asset('/adminlte/plugins/bootstrap-slider/slider.css') }}">
  <link rel="stylesheet" href="{{ asset('/adminlte/dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/adminlte/dist/css/skins/skin-blue.min.css') }}">
</head>

<body data-spy="scroll" data-offset="0" data-target="#navigation">

<div id="app">
<!-- Fixed navbar -->
<div id="navigation" class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/"><b>{{ trans('message.appname') }} | 鱼塘养殖</b></a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li><a href="/areactrl"><span>环境监测</span></a>
        </li>
        <li><a href="/devstats"><span>设备控制</span></a>
        </li>
        <li><a href="/videoreal"><span>视频监控</span></a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
      @if (!Auth::guest())
        <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-transform: none;"><span>{{ Auth::user()->name }}</span></a>
          <ul class="dropdown-menu dropdown-auto">
            <li><a href="/curinfo/user">管理后台</a></li>            
            <li>
              <a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">退出</a>
              <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
            </li>
          </ul>
        </li>
      @else
        <li><a href="/login">登录</a></li>
      @endif
      </ul>
    </div>
  </div>
</div>
    
    
<div class="container">
  <div class="row" style="margin-top: 80px;">
    <div class="col-md-8">
      <div class="box box-default">
        <div class="box-body">
          <div id="carousel-base" class="carousel slide">
            <ol class="carousel-indicators">
              <li data-target="#carousel-base" data-slide-to="0" class="active"></li>
              <li data-target="#carousel-base" data-slide-to="1"></li>
              <li data-target="#carousel-base" data-slide-to="2"></li>
              <li data-target="#carousel-base" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
              <div class="item ltoggle active" durl="#" align="center" style="cursor: pointer; padding: 10px;">
                <h2 style="position: absolute; margin-top: 10%; margin-left: 50%;">生产管理</h2>
                <img src="/img/caquadetect.png" alt="">
              </div>
              <div class="item ltoggle" durl="#" align="center" style="cursor: pointer; padding: 10px;">
                <h2 style="position: absolute; margin-top: 10%; margin-left: 20%;">溯源系统</h2>
                <img src="/img/caquaservice.png" alt="">
              </div>
              <div class="item ltoggle" durl="#" align="center" style="cursor: pointer; padding: 10px;">
                <h2 style="position: absolute; margin-top: 10%; margin-left: 18%;">专家系统</h2>
                <img src="/img/caquactrl.png" alt="">
              </div>
              <div class="item ltoggle" durl="#" align="center" style="cursor: pointer; padding: 10px;">
                <h2 style="position: absolute; margin-top: 10%; margin-left: 18%;">报警提示</h2>
                <img src="/img/caquamanage.png" alt="">
              </div>
            </div>
            <a class="left carousel-control" href="#carousel-base" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-base" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="info-box bg-green ltoggle" durl="/areactrl" style="cursor: pointer;">
        <span class="info-box-icon"><i class="fa fa-table"></i></span>
        <div class="info-box-content">
          <span class="info-box-number" style="padding: 8px 0;">环境监测</span>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
          <span class="info-box-text">实时监控生产环境数据</span>
        </div>
      </div>
      <div class="info-box bg-aqua ltoggle" durl="/devstats" style="cursor: pointer;">
        <span class="info-box-icon"><i class="fa fa-hand-pointer-o"></i></span>
        <div class="info-box-content">
          <span class="info-box-number" style="padding: 8px 0;">设备控制</span>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
          <span class="info-box-text">设置控制设备，调试测试数据信息</span>
        </div>
      </div>
      <div class="info-box bg-yellow ltoggle" durl="/videoreal" style="cursor: pointer;">
        <span class="info-box-icon"><i class="fa  fa-video-camera"></i></span>
        <div class="info-box-content">
          <span class="info-box-number" style="padding: 8px 0;">视频监控</span>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
          <span class="info-box-text">现场监控，查看鱼塘状态</span>
        </div>
      </div>
    </div>
  </div>
</div>



</div>

<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="/js/new-age.min.js"></script>
<script>
    $('.carousel').carousel({
        interval: 3500
    })

    $('.carousel').carousel(0)

    $('.ltoggle').click(function () {
        $durl = $(this).attr('durl');
        location.href = $durl;
    })
</script>
</body>
</html>
