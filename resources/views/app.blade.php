<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  
  <title>{{ $globalvals['title'] }}</title>
  
  <link rel="shortcut icon" href="{{ asset('/img/favicon.icon') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/smartlab.css') }}">
  <!-- Scripts -->
  <script type="text/javascript" src="{{ asset('/js/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
</head>
<body>
  <nav class="homenav navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header homenav-bar">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle Navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        @if (Auth::guest())
          <a class="navbar-brand" href="{{ url('/') }}">{{ $globalvals['title'] }}</a>
	    @else
          <a class="navbar-brand" href="#">{{ $globalvals['title'] }}</a>
        @endif
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	  @if (Auth::guest())
        <ul class="nav navbar-nav navbar-right homenav-bar">
	      <li><a href="{{ url('/auth/login') }}">Login</a></li>
	      <li><a href="{{ url('/auth/register') }}">Register</a></li>
        </ul>
	  @else
        <ul class="nav navbar-nav homenav-bar">
	      <li><a href="{{ url('/') }}">Home</a></li>
	    </ul>

	    <ul class="nav navbar-nav navbar-right homenav-bar">
	      <li class="dropdown" style="margin-right: -15px;">
		    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
		    <ul class="dropdown-menu" role="menu">
		      <li><a href="{{ url('/admin') }}">Console</a></li>
		      <li><a href="{{ url('#') }}">Setting</a></li>
		      <li class="divider"></li>
			  <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
		    </ul>
	      </li>
	    </ul>
	  @endif
      </div>
    </div>
  </nav>

  @yield('content')
</body>
</html>
