<!DOCTYPE html>
<!--
Landing page based on Pratt: http://blacktie.co/demo/pratt/
-->
<html lang="en">
<head>
 @section('htmlheader')
  @include('cullive.layouts.partials.htmlheader')
@show
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
      <a class="navbar-brand" href="/farmbreeding"><b>{{ trans('message.appname') }} | 畜禽养殖</b></a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li><a href="/">首页</a></li>
        <li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span>环境监控</span></a>
          <ul class="dropdown-menu dropdown-auto">
            <li><a href="/farmbreeding/envctrl/swctrl">自动化通风</a></li>
            <li><a href="/farmbreeding/envctrl/htctrl">温度控制</a></li>
            <li><a href="/farmbreeding/envctrl/envdetect">环境监测</a></li>
          </ul>
        </li>
        <li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span>精准饲喂</span></a>
          <ul class="dropdown-menu dropdown-auto">
            <li><a href="/farmbreeding/promanage/elecdis">电子识别</a></li>
            <li><a href="/farmbreeding/promanage/autoweight">自动称量</a></li>
            <li><a href="/farmbreeding/promanage/autofeed">精准上料</a></li>
            <li><a href="/farmbreeding/promanage/autodrink">自动饮水</a></li>
            <li><a href="/farmbreeding/promanage/autoegg">自动集蛋</a></li>
            <li><a href="/farmbreeding/promanage/automilk">自动挤奶</a></li>
            <li><a href="/farmbreeding/promanage/autopack">产品包装</a></li>
          </ul>
        </li>
        <li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span>粪污处理</span></a>
          <ul class="dropdown-menu dropdown-auto">
            <li><a href="/farmbreeding/promanage/watersave">节水设施</a></li>
            <li><a href="/farmbreeding/promanage/dungclean">粪便清理</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
      @if (!Auth::guest())
        <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-transform: none;"><span>{{ Auth::user()->name }}</span></a>
          <ul class="dropdown-menu dropdown-auto">
            <li><a href="/dashboard">管理后台</a></li>            
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
              <li data-target="#carousel-base" data-slide-to="3"></li>
              <li data-target="#carousel-base" data-slide-to="4"></li>
            </ol>
            <div class="carousel-inner">
              <div class="item ltoggle active" durl="/farmbreeding/envctrl/envdetect" align="center" style="cursor: pointer; padding: 10px;">
                <h2 style="position: absolute; margin-top: 10%; margin-left: 50%;">环境监控</h2>
                <img src="/img/cbarctrl.png" alt="">
              </div>
              <div class="item ltoggle" durl="/farmbreeding/promanage/autofeed" align="center" style="cursor: pointer; padding: 10px;">
                <h2 style="position: absolute; margin-top: 10%; margin-left: 20%;">精准喂料</h2>
                <img src="/img/cfeedctrl.png" alt="">
              </div>
              <div class="item ltoggle" durl="/farmbreeding/promanage/dungclean" align="center" style="cursor: pointer; padding: 10px;">
                <h2 style="position: absolute; margin-top: 10%; margin-left: 18%;">粪污处理</h2>
                <img src="/img/cdungctrl.png" alt="">
              </div>
              <div class="item ltoggle" durl="/farmbreeding/promanage/autoegg" align="center" style="cursor: pointer; padding: 10px;">
                <h2 style="position: absolute; margin-top: 8%; margin-left: 18%;">自动集蛋</h2>
                <img src="/img/ceggctrl.png" alt="">
              </div>
              <div class="item ltoggle" durl="/farmbreeding/promanage/automilk" align="center" style="cursor: pointer; padding: 10px;">
                <h2 style="position: absolute; margin-top: 6%; margin-left: 50%;">自动挤奶</h2>
                <img src="/img/cmilkctrl.png" alt="">
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
      <div class="info-box bg-green ltoggle" durl="/farmbreeding/promanage" style="cursor: pointer;">
        <span class="info-box-icon"><i class="fa fa-table"></i></span>
        <div class="info-box-content">
          <span class="info-box-number" style="padding: 8px 0;">生产管理</span>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
          <span class="info-box-text">农产品生产过程管理监控</span>
        </div>
      </div>
      <div class="info-box bg-aqua ltoggle" durl="/farmbreeding/resmanage" style="cursor: pointer;">
        <span class="info-box-icon"><i class="fa fa-sort-amount-desc"></i></span>
        <div class="info-box-content">
          <span class="info-box-number" style="padding: 8px 0;">溯源系统</span>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
          <span class="info-box-text">农产品溯源追踪，可靠来源查询</span>
        </div>
      </div>
      <div class="info-box bg-yellow ltoggle" durl="/farmbreeding/onexpert" style="cursor: pointer;">
        <span class="info-box-icon"><i class="fa fa-user-plus"></i></span>
        <div class="info-box-content">
          <span class="info-box-number" style="padding: 8px 0;">专家系统</span>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
          <span class="info-box-text">专家在线答疑、咨询</span>
        </div>
      </div>
      <div class="info-box bg-red ltoggle" durl="/farmbreeding/alarminfo" style="cursor: pointer;">
        <span class="info-box-icon"><i class="fa fa-volume-up"></i></span>
        <div class="info-box-content">
          <span class="info-box-number" style="padding: 8px 0;">报警提示</span>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
          <span class="info-box-text">报警阈值设置，联动报警等</span>
        </div>
      </div>
    </div>
  </div>
</div>



</div>

@section('scripts')
  @include('cullive.layouts.partials.scripts')
@show
<script>
    $('.carousel').carousel({
        interval: 3500
    })

    $('.carousel').carousel({{ $slideto }})

    $('.ltoggle').click(function () {
        $durl = $(this).attr('durl');
        location.href = $durl;
    })
</script>
</body>
</html>
