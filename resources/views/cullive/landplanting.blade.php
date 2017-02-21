<!DOCTYPE html>
<!--
Landing page based on Pratt: http://blacktie.co/demo/pratt/
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Adminlte-laravel - {{ trans('message.description') }} ">
    <meta name="author" content="Sam Chen - cullive.com">

    <title>{{ trans('message.description') }}</title>

    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/main.css') }}" rel="stylesheet">

    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
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
                <a class="navbar-brand" href="/landplanting"><b>{{ trans('message.appname') }} | {{ trans('message.landplanting') }}</b></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/">{{ trans('message.home') }}</a></li>
                    <li><a href="{{ trans('message.lkplantctrl') }}">{{ trans('message.plantctrl') }}</a></li>
                    <li><a href="{{ trans('message.lkplantmanage') }}">{{ trans('message.plantmanage') }}</a></li>
                    <li><a href="{{ trans('message.lkplantservice') }}">{{ trans('message.plantservice') }}</a></li>
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
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item ltoggle active" durl="/landplanting/plantctrl" align="center" style="cursor: pointer;">
                <img src="{{ asset('/img/item-02.png') }}" alt="">
            </div>
            <div class="item ltoggle" durl="/landplanting/plantmanage" align="center" style="cursor: pointer;">
                <img src="{{ asset('/img/item-02.png') }}" alt="">
            </div>
            <div class="item ltoggle" durl="/landplanting/plantservice" align="center" style="cursor: pointer;">
                <img src="{{ asset('/img/item-02.png') }}" alt="">
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
                <h1>LandPlanting</h1>
                <br>
                <br>
                <div class="col-lg-4 ltoggle" durl="/landplanting/plantctrl">
                    <img src="{{ asset('/img/iplantctrl.png') }}" alt="" style="cursor: pointer;">
                    <h3>PlantCtrl</h3>
                </div>
                <div class="col-lg-4 ltoggle" durl="/landplanting/plantmanage">
                    <img src="{{ asset('/img/iplantmanage.png') }}" alt="" style="cursor: pointer;">
                    <h3>PlantManage</h3>
                </div>
                <div class="col-lg-4 ltoggle" durl="/landplanting/plantservice">
                    <img src="{{ asset('/img/iplantservice.png') }}" alt="" style="cursor: pointer;">
                    <h3>PlantService</h3>
                </div>
            </div>
            <br>
            <hr>
        </div> <!--/ .container -->
    </div><!--/ #basewrap -->
    
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ asset('/js/app.js') }}"></script>
<script src="{{ asset('/js/smoothscroll.js') }}"></script>
<script>
    $('.carousel').carousel({
        interval: 3500
    })
    
    $('.ltoggle').click(function () {
        $durl = $(this).attr('durl');
        location.href = $durl;
    })
</script>
</body>
</html>
