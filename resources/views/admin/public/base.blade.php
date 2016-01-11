<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>smartlab | console</title>
  
  <link href="{{ asset('/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/smartlab.css') }}" rel="stylesheet">
</head>
<body>
  <nav class="smartlab-nav navbar navbar-fixed-top">
    <div class="container-fluid">
	  <div class="navbar-header">
        <a class="navbar-brand smartlab-brand" href="#">SmartLab</a>
      </div>
      @foreach ($nmenus as $nmenu)
        <div class="nav navbar-nav dropdown">
          <a class="menu
            @if($nmenu->mmenu == $amenu->mmenu)
              active
            @endif
          " href="{{ url('/admin?action='.$nmenu->action) }}">{{ $nmenu->mmenu }}</a>
          <!-- ul class="dropdown-menu dropdown-auto">
            @foreach ($menus as $tmenu)
              @if($nmenu->mmenu == $tmenu->mmenu)
	            <li><a href="{{ url('/admin?action='.$tmenu->action) }}">{{ $tmenu->cmenu }}</a></li>
	          @endif
	        @endforeach
	      </ul-->
      </div>
      @endforeach
	  <div class="nav navbar-nav navbar-right dropdown">
        <a id="user-info" class="homemenu dropdown-toggle" data-toggle="dropdown" href="">{{ Auth::user()->name }}</a>
        <ul id="user-list" class="dropdown-menu">
          <li><a href="/admin?action=setting">设置</a></li>
          <li><a href="{{ url('/auth/logout') }}">退出</a></li>
        </ul>
      </div>
      <a class="nav navbar-nav navbar-right smartlab-nav-item" href="{{ url('/home') }}">前台</a>
    </div>
  </nav>

  @yield('menuboard')
  
  <!-- Scripts -->
  <script type="text/javascript" src="{{ asset('/js/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
</body>
</html>