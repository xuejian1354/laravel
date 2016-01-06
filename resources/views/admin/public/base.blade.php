<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>smartlab | console</title>
  
  <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
</head>
<body>
  <div class="panel-header">
    <nav class="navbar navbar-inverse">
      <div class="navbar-header">
        @if (Auth::guest())
          <a class="navbar-brand" href="{{ url('/') }}">smartlab</a>
	    @else
          <a class="navbar-brand" href="#">smartlab</a>
        @endif
      </div>
      <div class="collapse navbar-collapse navbar-collapse-example">
        <ul id="nav_bar" class="nav navbar-nav">
          <li><a href="{{ url('#') }}">User</a></li>
          <li><a href="{{ url('#') }}">Device</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="{{ url('/home') }}">Front</a></li>
	      <li class="dropdown">
		    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
		    <ul class="dropdown-menu" role="menu">
		      <li><a href="{{ url('#') }}">Setting</a></li>
		      <li class="divider"></li>
			  <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
		    </ul>
	      </li>
	    </ul>
      </div>
    </nav>
  </div>
  
  @yield('content')
  
  <!-- Scripts -->
  <script type="text/javascript" src="{{ asset('/js/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
</body>
</html>