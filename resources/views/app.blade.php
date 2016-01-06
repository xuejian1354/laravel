<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  
  <title>smartlab</title>
  
  <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
</head>
<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle Navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        @if (Auth::guest())
          <a class="navbar-brand" href="{{ url('/') }}">smartlab</a>
	    @else
          <a class="navbar-brand" href="#">smartlab</a>
        @endif
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	  @if (Auth::guest())
        <ul class="nav navbar-nav navbar-right">
	      <li><a href="{{ url('/auth/login') }}">Login</a></li>
	      <li><a href="{{ url('/auth/register') }}">Register</a></li>
        </ul>
	  @else
        <ul class="nav navbar-nav">
	      <li><a href="{{ url('/') }}">Home</a></li>
	    </ul>

	    <ul class="nav navbar-nav navbar-right">
	      <li class="dropdown">
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
  
  <!-- Scripts -->
  <script type="text/javascript" src="{{ asset('/js/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
</body>
</html>
