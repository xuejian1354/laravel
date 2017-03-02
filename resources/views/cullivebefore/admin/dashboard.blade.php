<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width">
  <title>{{ trans('message.appname').' | '.trans('message.barctrl').' | '.$select_menus[0]->name}}
  @if(isset($page_title) || count($select_menus) > 1)
    | {{ $page_title or end($select_menus)->name }}
  @endif
  @if(isset($page_description))
    | {{ $page_description }}
  @endif
  </title>
  @if(\App\Model\Globalval::getVal('matrix') == 'raspberrypi')
  <link rel="shortcut icon" href="{{ asset('/rasp.png') }}" type="image/x-icon">
  @else
  <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/png">
  @endif
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

<body>
<div>
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="/farmbreeding"><b>{{ trans('message.appname') }} | {{ trans('message.barctrl') }}</b></a>
      </div>
      @foreach($console_menus[0] as $home_menu)
      @if($home_menu->haschild == 0)
      <div class="nav navbar-nav">
        @if(isset($home_menu->isactive) && $home_menu->isactive == true)
        <li class="active">
        @else
        <li>
        @endif
          <a href="{{ App\Http\Controllers\CulliveBefore\AdminController::withurl($home_menu->action) }}">
            <i class="{{ $home_menu->img }}"></i><span> {{ $home_menu->name }}</span>
          </a>
        </li>
      </div>
      @else
      <div class="nav navbar-nav">
        @if(isset($home_menu->isactive) && $home_menu->isactive == true)
        <li class="active">
        @else
        <li>
        @endif
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="{{ $home_menu->img }}"></i>
            <span>{{ $home_menu->name }}</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
          <ul class="dropdown-menu dropdown-auto">
          @if(isset($console_menus[$home_menu->inode]))
          @foreach($console_menus[$home_menu->inode] as $child_menu)
            @if(isset($child_menu->isactive) && $child_menu->isactive == true)
            <li class="active">
            @else
            <li>
            @endif
              <a href="{{ App\Http\Controllers\CulliveBefore\AdminController::withurl($child_menu->action) }}">
                <i class="{{ $child_menu->img }}"></i><span> {{ $child_menu->name }}</span>
              </a>
            </li>
          @endforeach
          @else
            <li><a href="#"><i></i><span>None</span></a></li>
          @endif
          </ul>
        </li>
      </div>
      @endif
      @endforeach
    </div>
  </nav>
  <div class="col-md-12" style="margin-top: 50px;">
    <div class="col-md-6">
      <h1>
        {{ $page_title or end($select_menus)->name }}
        <small>{{ $page_description or null }}</small>
      </h1>
    </div>
    <div class="col-md-6">
      <!-- ol class="breadcrumb pull-right">
        <li><a href="{{ config('cullivebefore.mainrouter') }}/{{ $select_menus[0]->action }}"><i class="fa fa-dashboard"></i>{{ $select_menus[0]->name }}</a></li>
        @if(isset($page_title) || count($select_menus) > 1)
        <li class="active">{{ $page_title or end($select_menus)->name }}</li>
        @endif
      </ol -->
    </div>
    <div class="content col-md-12">
      @yield('content')
    </div>
  </div>
</div>

<script src="{{ asset('/adminlte/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<script src="{{ asset('/adminlte/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/adminlte/dist/js/app.min.js') }}"></script>
<script src="{{ asset('/js/socket.io.min.js') }}"></script>
<script src="{{ asset('/js/cullive-before.js') }}"></script>

@yield('conscript')
</body>
</html>
