<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>{{ trans('message.description') }}</title>
  <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
  <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
  <link rel="stylesheet" href="/vendor/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="/vendor/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="/vendor/device-mockups/device-mockups.min.css">
  <link rel="stylesheet" href="/css/new-age.css">
</head>

<body id="page-top">
<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
      </button>
      <a class="navbar-brand page-scroll" href="#page-top">{{ trans('message.appname') }}</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a class="page-scroll" href="#main">应用</a>
        </li>
        <li>
          <a class="page-scroll" href="#features">管理</a>
        </li>
        <li>
          <a class="page-scroll" href="#contact">联系</a>
        </li>
        @if (Auth::guest())
        <li><a role="button" data-target="#loginOptModal" data-toggle="modal">{{ trans('message.login') }}</a></li>
        <!-- li><a role="button" data-target="#registerOptModal" data-toggle="modal">{{ trans('message.register') }}</a></li -->
        @else
        <li><a href="/home" style="text-transform: none;">{{ Auth::user()->name }}</a></li>
        @endif
      </ul>
    </div>
  </div>
</nav>

<header>
  <div class="container">
    <div class="row">
      <div class="col-sm-7">
        <div class="header-content">
          <div class="header-content-inner">
            <h1>{{ trans('message.appname') }}综合管理平台<br>物联网应用操控中心</h1>
            <h2>——数字农业云平台一体化</h2>
          </div>
        </div>
      </div>
      <div class="col-sm-5">
        <div class="device-container">
          <div class="device-mockup iphone6_plus portrait white">
            <div class="device">
              <div class="screen">
                <img src="img/mainscreen-1.jpg" class="img-responsive" alt="">
              </div>
              <div class="button">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

<section id="main" class="download text-center" style="background:#34495e no-repeat center; background-size: 100% 100%; background-image: url('/img/farmbreeding.png');">
  <div class="container">
    <div class="row">
      <div class="col-md-9 col-md-offset-3">
        <a href="/farmbreeding">畜禽养殖</a>
      </div>
    </div>
  </div>
</section>

<section class="download text-center" style="background:#34495e no-repeat center; background-size: 100% 100%; background-image: url('/img/aquaculture.png');">
  <div class="cta-content">
    <div class="container">
      <div class="row">
        <div class="col-md-5">
          <a href="/">水产养殖</a>
        </div>
      </div>
    </div>
  </div>
  <div class="overlay"></div>
</section>

<section id="features" class="text-center bg-setting">
  <div class="cta-content">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <a href="/dashboard">后台管理</a>
        </div>
      </div>
    </div>
  </div>
  <div class="overlay"></div>
</section>

<section id="contact" class="contact bg-primary">
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
</section>

<footer>
  <div class="container">
    <p><strong>Copyright &copy; 2017 <a href="{{ asset('http://longyuanspace.com') }}" target="_blank" style="color: white;">NanJing LongYuan Innovation Space Co.,Ltd</a>.</strong></a></p>
  </div>
</footer>

@include('cullive.auth.login')
@include('cullive.auth.register')

@section('scripts')
  @include('cullive.layouts.partials.scripts')
@show

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
</body>
</html>
