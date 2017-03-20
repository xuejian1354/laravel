<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width">
  <title>{{ \App\Globalval::getVal('title').' | '.$select_menus[0]->name}}
  @if(isset($page_title) || count($select_menus) > 1)
    | {{ $page_title or end($select_menus)->name }}
  @endif
  @if(isset($page_description))
    | {{ $page_description }}
  @endif
  </title>
  @if(\App\Globalval::getVal('matrix') == 'raspberrypi')
  <link rel="shortcut icon" href="{{ asset('/rasp.png') }}" type="image/x-icon">
  @else
  <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/png">
  @endif
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ asset('/adminlte/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css') }}">
  <!-- fullCalendar 2.2.5-->
  <link rel="stylesheet" href="{{ asset('/adminlte/plugins/fullcalendar/fullcalendar.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/adminlte/plugins/fullcalendar/fullcalendar.print.css') }}" media="print">
  <!-- Morris charts -->
  <link rel="stylesheet" href="{{ asset('/adminlte/plugins/morris/morris.css') }}">
  <!-- bootstrap slider -->
  <link rel="stylesheet" href="{{ asset('/adminlte/plugins/bootstrap-slider/slider.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/adminlte/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="{{ asset('/adminlte/dist/css/skins/skin-blue.min.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
@if(isset($reurl['menu_stats']) && $reurl['menu_stats'] == 'mini')
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
@else
<body class="hold-transition skin-blue sidebar-mini">
@endif
<div class="wrapper">

  <!-- Main Header -->
  @include('admin.header')
  <!-- Left side column. contains the logo and sidebar -->
  @include('admin.mainside')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

  <ul class="nav nav-tabs" role="tablist">
  @foreach($console_menus[0] as $home_menu)
  @if($home_menu->haschild && isset($home_menu->isactive) 
    && $home_menu->isactive == true && isset($console_menus[$home_menu->inode]))
    @foreach($console_menus[$home_menu->inode] as $child_menu)
    @if(isset($child_menu->isactive) && $child_menu->isactive == true)
    <li role="presentation" class="nav-li active">
    @else
    <li role="presentation" class="nav-li">
    @endif
      <a href="{{ App\Http\Controllers\AdminController::withurl($child_menu->action) }}">
        </i><h4>{{ $child_menu->name }}</h4>
      </a>
    </li>
    @endforeach
  @endif
  @endforeach
  </ul>

  @if(isset(end($select_menus)->haschild))
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ $page_title or end($select_menus)->name }}
        <small>{{ $page_description or null }}</small>
      </h1>
      <!-- You can dynamically generate breadcrumbs here -->
      <ol class="breadcrumb">
        <li><a href="/{{ $select_menus[0]->action }}"><i class="fa fa-dashboard"></i>{{ $select_menus[0]->name }}</a></li>
        @if(isset($page_title) || count($select_menus) > 1)
        <li class="active">{{ $page_title or end($select_menus)->name }}</li>
        @endif
      </ol>
    </section>
  @endif

    <!-- Main content -->
    <section class="content">
      <!-- Your Page Content Here -->
      @yield('content')
    </section><!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  @include('admin.footer')

  <!-- Control Sidebar -->
  <!-- include('admin.setside') -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset('/adminlte/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('/adminlte/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/adminlte/dist/js/app.min.js') }}"></script>
<!-- socket.io -->
<script src="{{ asset('/js/socket.io.min.js') }}"></script>
<!-- Cullive -->
<script src="{{ asset('/js/cullive.js') }}"></script>

<!-- Page script -->
@yield('conscript')
</body>
</html>
