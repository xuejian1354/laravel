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
                <a class="navbar-brand" href="/aquaculture"><b>{{ trans('message.appname') }} | {{ trans('message.aquaculture') }}</b></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/">{{ trans('message.home') }}</a></li>
                    <li><a href="{{ trans('message.lkaquactrl') }}">{{ trans('message.aquactrl') }}</a></li>
                    <li><a href="{{ trans('message.lkaquamanage') }}">{{ trans('message.aquamanage') }}</a></li>
                    <li><a href="{{ trans('message.lkaquadetect') }}">{{ trans('message.aquadetect') }}</a></li>
                    <li><a href="{{ trans('message.lkaquaservice') }}">{{ trans('message.aquaservice') }}</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">{{ trans('message.login') }}</a></li>
                        <li><a href="{{ url('/register') }}">{{ trans('message.register') }}</a></li>
                    @else
                        <li><a href="/home">{{ Auth::user()->name }}</a></li>
                    @endif
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>

    <div id="carousel-base" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#carousel-base" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-base" data-slide-to="1"></li>
            <li data-target="#carousel-base" data-slide-to="2"></li>
            <li data-target="#carousel-base" data-slide-to="3"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item ltoggle active" durl="{{ trans('message.lkaquactrl') }}" align="center" style="cursor: pointer;">
                <img src="{{ asset('/img/caquactrl.png') }}" alt="">
            </div>
            <div class="item ltoggle" durl="{{ trans('message.lkaquamanage') }}" align="center" style="cursor: pointer;">
                <img src="{{ asset('/img/caquamanage.png') }}" alt="">
            </div>
            <div class="item ltoggle" durl="{{ trans('message.lkaquadetect') }}" align="center" style="cursor: pointer;">
                <img src="{{ asset('/img/caquadetect.png') }}" alt="">
            </div>
            <div class="item ltoggle" durl="{{ trans('message.lkaquaservice') }}" align="center" style="cursor: pointer;">
                <img src="{{ asset('/img/caquaservice.png') }}" alt="">
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

    <hr>

    <div id="basewrap">
        <div class="container">
            <div class="row" style="text-align: center;">
                <h1>Aquaculture</h1>
                <br>
                <br>
                <div class="col-lg-3 ltoggle" durl="{{ trans('message.lkaquactrl') }}">
                    <img src="{{ asset('/img/iaquactrl.png') }}" alt="" style="cursor: pointer;">
                    <h3>AquaCtrl</h3>
                </div>
                <div class="col-lg-3 ltoggle" durl="{{ trans('message.lkaquamanage') }}">
                    <img src="{{ asset('/img/iaquamanage.png') }}" alt="" style="cursor: pointer;">
                    <h3>AquaManage</h3>
                </div>
                <div class="col-lg-3 ltoggle" durl="{{ trans('message.lkaquadetect') }}">
                    <img src="{{ asset('/img/iaquadetect.png') }}" alt="" style="cursor: pointer;">
                    <h3>AquaDetect</h3>
                </div>
                <div class="col-lg-3 ltoggle" durl="{{ trans('message.lkaquaservice') }}">
                    <img src="{{ asset('/img/iaquaservice.png') }}" alt="" style="cursor: pointer;">
                    <h3>AquaService</h3>
                </div>
            </div>
            <br>
            <hr>
        </div> <!--/ .container -->
    </div><!--/ #basewrap -->
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
