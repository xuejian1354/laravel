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
                <a class="navbar-brand" href="/farmbreeding"><b>{{ trans('message.appname') }} | {{ trans('message.farmbreeding') }}</b></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/">{{ trans('message.home') }}</a></li>
                    <li><a href="{{ trans('message.lkbarctrl') }}">{{ trans('message.barctrl') }}</a></li>
                    <li><a href="{{ trans('message.lkfeedctrl') }}">{{ trans('message.feedctrl') }}</a></li>
                    <li><a href="{{ trans('message.lkeggctrl') }}">{{ trans('message.eggctrl') }}</a></li>
                    <li><a href="{{ trans('message.lkmilkctrl') }}">{{ trans('message.milkctrl') }}</a></li>
                    <li><a href="{{ trans('message.lkdungctrl') }}">{{ trans('message.dungctrl') }}</a></li>
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
            <div class="item ltoggle active" durl="{{ trans('message.lkbarctrl') }}" align="center" style="cursor: pointer;">
                <img src="{{ asset('/img/cbarctrl.png') }}" alt="">
            </div>
            <div class="item ltoggle" durl="{{ trans('message.lkfeedctrl') }}" align="center" style="cursor: pointer;">
                <img src="{{ asset('/img/cfeedctrl.png') }}" alt="">
            </div>
            <div class="item ltoggle" durl="{{ trans('message.lkeggctrl') }}" align="center" style="cursor: pointer;">
                <img src="{{ asset('/img/ceggctrl.png') }}" alt="">
            </div>
            <div class="item ltoggle" durl="{{ trans('message.lkmilkctrl') }}" align="center" style="cursor: pointer;">
                <img src="{{ asset('/img/cmilkctrl.png') }}" alt="">
            </div>
            <div class="item ltoggle" durl="{{ trans('message.lkdungctrl') }}" align="center" style="cursor: pointer;">
                <img src="{{ asset('/img/cdungctrl.png') }}" alt="">
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
            <div class="row centered">
                <h1>Farmbreeding</h1>
                <br>
                <br>
                <div class="col-lg-1"></div>
                <div class="col-lg-2 ltoggle" durl="{{ trans('message.lkbarctrl') }}">
                    <img src="{{ asset('/img/ibarctrl.png') }}" alt="" style="cursor: pointer;">
                    <h3>BarCtrl</h3>
                </div>
                <div class="col-lg-2 ltoggle" durl="{{ trans('message.lkfeedctrl') }}">
                    <img src="{{ asset('/img/ifeedctrl.png') }}" alt="" style="cursor: pointer;">
                    <h3>FeedCtrl</h3>
                </div>
                <div class="col-lg-2 ltoggle" durl="{{ trans('message.lkeggctrl') }}">
                    <img src="{{ asset('/img/ieggctrl.png') }}" alt="" style="cursor: pointer;">
                    <h3>EggCtrl</h3>
                </div>
                <div class="col-lg-2 ltoggle" durl="{{ trans('message.lkmilkctrl') }}">
                    <img src="{{ asset('/img/imilkctrl.png') }}" alt="" style="cursor: pointer;">
                    <h3>MilkCtrl</h3>
                </div>
                <div class="col-lg-2 ltoggle" durl="{{ trans('message.lkdungctrl') }}">
                    <img src="{{ asset('/img/idungctrl.png') }}" alt="" style="cursor: pointer;">
                    <h3>DungCtrl</h3>
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
