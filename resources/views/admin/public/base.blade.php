<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>{{ $globalvals['title'] }} | 控制台 | {{ $amenu->cmenu }}</title>
  
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/img/favicon.icon') }}">
  <link rel="icon" type="image/x-icon" href="{{ asset('/img/favicon.icon') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap-submenu.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/smartlab.css') }}">
  <!-- Scripts -->
  <script type="text/javascript" src="{{ asset('/js/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/socket.io.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/bootstrap-submenu.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/smartlab.js') }}"></script>
</head>
<body>
  <nav class="smartlab-nav navbar navbar-fixed-top">
    <div class="container-fluid">
	  <div class="navbar-header">
        <a class="navbar-brand smartlab-brand" href="#">{{ $globalvals['title'] }}</a>
      </div>
      @foreach ($nmenus as $nmenu)
        <div class="nav navbar-nav dropdown">
          @if($nmenu->mmenu != '设置' && $nmenu->mmenu != '功能')
            @if($nmenu->mmenu == $amenu->mmenu)
              <a class="menu disabled active" href="javascript:void(0);">{{ $nmenu->mmenu }}</a>
            @else
              <a class="menu disabled " href="{{ url('/admin?action='.$nmenu->action) }}">{{ $nmenu->mmenu }}</a>
            @endif
          @endif
          <ul class="dropdown-menu dropdown-auto">
            @foreach ($menus as $tmenu)
              @if($nmenu->mmenu == $tmenu->mmenu)
	            <li><a href="{{ url('/admin?action='.$tmenu->action) }}">{{ $tmenu->cmenu }}</a></li>
	          @endif
	        @endforeach
	      </ul>
        </div>
      @endforeach
	  <div class="nav navbar-nav navbar-right dropdown">
        <a id="user-info" class="homemenu dropdown-toggle" data-toggle="dropdown" href="">{{ Auth::user()->name }}</a>
        <ul id="user-list" class="dropdown-menu">
          <li><a class="smartlab-nav-item" href="{{ url('/home') }}">前台</a></li>
          <li><a href="/admin?action=setting">设置</a></li>
          <li><a href="{{ url('/auth/logout') }}">退出</a></li>
        </ul>
      </div>
      <a class="nav navbar-nav navbar-right smartlab-nav-item" href="{{ url('/home') }}">前台</a>
    </div>
  </nav>
  @yield('board')
</body>
</html>