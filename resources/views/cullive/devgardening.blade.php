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
                <a class="navbar-brand" href="/devgardening"><b>{{ trans('message.appname') }} | {{ trans('message.devgardening') }}</b></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/">{{ trans('message.home') }}</a></li>
                    <li><a href="{{ trans('message.lkgreenhousectrl') }}">{{ trans('message.greenhousectrl') }}</a></li>
                    <li><a href="{{ trans('message.lkseedctrl') }}">{{ trans('message.seedctrl') }}</a></li>
                    <li><a href="{{ trans('message.lkproductionctrl') }}">{{ trans('message.productionctrl') }}</a></li>
                    <li><a href="{{ trans('message.lkqualityctrl') }}">{{ trans('message.qualityctrl') }}</a></li>
                    <li><a href="{{ trans('message.lkbusinessctrl') }}">{{ trans('message.businessctrl') }}</a></li>
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
            <li data-target="#carousel-base" data-slide-to="4"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item ltoggle active" durl="{{ trans('message.lkgreenhousectrl') }}" align="center" style="cursor: pointer;">
                <img src="{{ asset('/img/cgreenhousectrl.png') }}" alt="">
            </div>
            <div class="item ltoggle" durl="{{ trans('message.lkseedctrl') }}" align="center" style="cursor: pointer;">
                <img src="{{ asset('/img/cseedctrl.png') }}" alt="">
            </div>
            <div class="item ltoggle" durl="{{ trans('message.lkproductionctrl') }}" align="center" style="cursor: pointer;">
                <img src="{{ asset('/img/cproductionctrl.png') }}" alt="">
            </div>
            <div class="item ltoggle" durl="{{ trans('message.lkqualityctrl') }}" align="center" style="cursor: pointer;">
                <img src="{{ asset('/img/cqualityctrl.png') }}" alt="">
            </div>
            <div class="item ltoggle" durl="{{ trans('message.lkbusinessctrl') }}" align="center" style="cursor: pointer;">
                <img src="{{ asset('/img/cbusinessctrl.png') }}" alt="">
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
                <h1>Devgardening</h1>
                <br>
                <br>
                <div class="col-lg-1"></div>
                <div class="col-lg-2 ltoggle" durl="{{ trans('message.lkgreenhousectrl') }}">
                    <img src="{{ asset('/img/igreenhousectrl.png') }}" alt="" style="cursor: pointer;">
                    <h3>GreenhouseCtrl</h3>
                </div>
                <div class="col-lg-2 ltoggle" durl="{{ trans('message.lkseedctrl') }}">
                    <img src="{{ asset('/img/iseedctrl.png') }}" alt="" style="cursor: pointer;">
                    <h3>SeedCtrl</h3>
                </div>
                <div class="col-lg-2 ltoggle" durl="{{ trans('message.lkproductionctrl') }}">
                    <img src="{{ asset('/img/iproductionctrl.png') }}" alt="" style="cursor: pointer;">
                    <h3>ProductionCtrl</h3>
                </div>
                <div class="col-lg-2 ltoggle" durl="{{ trans('message.lkqualityctrl') }}">
                    <img src="{{ asset('/img/iqualityctrl.png') }}" alt="" style="cursor: pointer;">
                    <h3>QualityCtrl</h3>
                </div>
                <div class="col-lg-2 ltoggle" durl="{{ trans('message.lkbusinessctrl') }}">
                    <img src="{{ asset('/img/ibusinessctrl.png') }}" alt="" style="cursor: pointer;">
                    <h3>BusinessCtrl</h3>
                </div>
                <div class="col-lg-1"></div>
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
