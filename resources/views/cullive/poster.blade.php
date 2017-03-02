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
  <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
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
                <a class="navbar-brand" href="#"><b>{{ trans('message.appname') }}</b></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#home" class="smoothScroll">{{ trans('message.home') }}</a></li>
                    <li><a href="#landplanting" class="smoothScroll">{{ trans('message.landplanting') }}</a></li>
                    <li><a href="#devgardening" class="smoothScroll">{{ trans('message.devgardening') }}</a></li>
                    <li><a href="#farmbreeding" class="smoothScroll">{{ trans('message.farmbreeding') }}</a></li>
                    <li><a href="#aquaculture" class="smoothScroll">{{ trans('message.aquaculture') }}</a></li>
                    <li><a href="#contact" class="smoothScroll">{{ trans('message.contact') }}</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a role="button" data-target="#loginOptModal" data-toggle="modal">{{ trans('message.login') }}</a></li>
                        <li><a role="button" data-target="#registerOptModal" data-toggle="modal">{{ trans('message.register') }}</a></li>
                    @else
                        <li><a href="/home">{{ Auth::user()->name }}</a></li>
                    @endif
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>

    <section id="home" name="home"></section>
    <div id="headerwrap">
        <div class="container">
            <div class="row centered">
                <div class="col-lg-12">
                    <h1>{{ trans('message.appname') }} <b><a href="#">{{ trans('message.console') }}</a></b></h1>
                    <h3>先进农业示范工程，坚持政府引导、市场主体、多元投入、多方协同的原则，推动大数据、云计算、物联网、移动互联、遥感等现代信息技术在农业中应用，加快推进农业生产智能化、经营信息化、管理数据化、服务在线化，全面提高农业现代化水平</h3>
                    <h3><a href="/dashboard" class="btn btn-lg btn-success">进 入 ...</a></h3>
                </div>
                <div class="col-lg-2">
                    <h5>可伸缩菜单操作</h5>
                    <p>基于Web可视化应用</p>
                    <img class="hidden-xs hidden-sm hidden-md" src="{{ asset('/img/arrow1.png') }}">
                </div>
                <div class="col-lg-8">
                    <img class="img-responsive" src="{{ asset('/img/app-bg.png') }}" alt="">
                </div>
                <div class="col-lg-2">
                    <br>
                    <img class="hidden-xs hidden-sm hidden-md" src="{{ asset('/img/arrow2.png') }}">
                    <h5>集中式管理...</h5>
                    <p>...操作功能耦合、关联在同一界面，或由指定位置直接跳转</p>
                </div>
            </div>
        </div> <!--/ .container -->
    </div><!--/ #headerwrap -->

    <section id="landplanting" name="landplanting"></section>
    <!-- PLANT WRAP -->
    <div id="plantwrap">
        <div class="container">
            <div class="row centered">
                <div class="col-md-offset-3 col-md-4" style="margin-top: 1%;">
                    <h1>大田种植</h1>
                    <h3>数字农业建设试点</h3>
                </div>
                <div class="col-md-offset-10 col-md-2" style="margin-top: 20%;">
                    <br>
                    <h3>机械种植</h3>
                    <p>精准定位，信息化一键管理，公共服务系统</p>
                    <h3><a href="/landplanting" class="btn btn-lg btn-success">进 入 ...</a></h3>
                </div>
            </div>
        </div> <!--/ .container -->
    </div><!--/ #plantwrap -->

    <section id="devgardening" name="devgardening"></section>
    <!-- GARDEN WRAP -->
    <div id="gardenwrap">
        <div class="container">
            <div class="row centered">
                <div class="col-md-4" style="margin-top: 2%;">
                    <h1>设施农业</h1>
                    <h3>数字化管理</h3>
                </div>
                <div class="col-md-3" style="margin-top: 20%;">
                    <br>
                    <h3>工厂化监控平台</h3>
                    <p>温室大棚监控系统，工厂化育苗，生产过程管理，生产质量管理，水肥一体化</p>
                    <h3><a href="/devgardening" class="btn btn-lg btn-success">进 入 ...</a></h3>
                </div>
            </div>
        </div> <!--/ .container -->
    </div><!--/ #gardenwrap -->

    <section id="farmbreeding" name="farmbreeding"></section>
    <!-- FARM WRAP -->
    <div id="farmwrap">
        <div class="container">
            <div class="row centered">
                <div class="col-md-offset-5 col-md-4" style="margin-top: 5%;">
                    <h1>畜禽养殖</h1>
                    <h3>自动化控制</h3>
                </div>
                <div class="col-md-offset-9 col-md-3" style="margin-top: 30%;">
                    <br>
                    <h3>智能养猪系统</h3>
                    <p>数字化精准喂料系统，分级管理，无害化粪污处理</p>
                    <h3><a href="/farmbreeding" class="btn btn-lg btn-success">进 入 ...</a></h3>
                </div>
            </div>
        </div><!--/ .container -->
    </div><!--/ #farmwrap -->

    <section id="aquaculture" name="aquaculture"></section>
    <div id="aquawrap">
        <div class="container">
            <div class="row centered">
                <div class="col-md-3" style="margin-top: 37%;">
                    <br>
                    <h3>信息化养鱼</h3>
                    <p>综合管理保障系统，公共服务设施，远程视频检测</p>
                    <h3><a href="/aquaculture" class="btn btn-lg btn-success">进 入 ...</a></h3>
                </div>
                <div class="col-md-offset-1 col-md-4" style="margin-top: 4%;">
                    <h1>水产养殖</h1>
                    <h3>在线检测系统</h3>
                </div>
            </div>
        </div><!-- / .container -->
    </div><!-- / #aquawrap -->

    <section id="contact" name="contact"></section>
    <div id="footerwrap">
        <div class="container">
            <div class="col-lg-5">
                <h3>{{ trans('message.address') }}</h3>
                <p>南京市江宁区,<br/>胜太路58号,<br/>人才市场大厦5楼<br/></p>
            </div>

            <div class="col-lg-7">
                <h3>线上留言</h3>
                <br>
                <div>
                    <input id="mtoken" type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="name1">{{ trans('message.yourname') }}</label>
                        <input id="mname" type="name" name="Name" class="form-control" id="name1" placeholder="{{ trans('message.yourname') }}">
                    </div>
                    <div class="form-group">
                        <label for="email1">{{ trans('message.emailaddress') }}</label>
                        <input id="memail" type="email" name="Mail" class="form-control" id="email1" placeholder="{{ trans('message.emailaddress') }}">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('message.yourtext') }}</label>
                        <textarea id="mmessage" class="form-control" name="Message" rows="3"></textarea>
                    </div>
                    <br>
                    <button class="btn btn-large btn-success" onclick="javascript:uploadMsg();">{{ trans('message.submit') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div id="c">
        <div class="container">
            <p>
              <strong>Copyright &copy; 2017 <a href="{{ asset('http://cullive.com') }}" target="_blank">NanJing LongYuan Innovation Space Co.,Ltd</a>.</strong> </a>
            </p>
        </div>
    </div>
</div>

@include('cullive.auth.login')
@include('cullive.auth.register')

@section('scripts')
  @include('cullive.layouts.partials.scripts')
@show

<script src="{{ asset('/js/smoothscroll.js') }}"></script>
<script type="text/javascript">
function uploadMsg() {
  $.post('/upinfo',
    { _token:$('#mtoken').val(), Name:$('#mname').val(), Mail:$('#memail').val(), Message:$('#mmessage').val() },
	function(data, status) {
      $('#mname').val('');
	  $('#memail').val('');
	  $('#mmessage').val('');

	  if(status != 'success') {
		alert("Status: " + status);
	  }
	  else if (data == 'TRUE'){
		  alert('提交成功');
	  }
    }
  );
}
</script>
</script>
</body>
</html>
