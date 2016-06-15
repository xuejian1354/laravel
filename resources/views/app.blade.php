<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  
  <title>{{ $globalvals['title'] }}</title>
  
  <link rel="shortcut icon" href="{{ asset('/img/favicon.icon') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/smartlab.css') }}">
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
	      <li class="dropdown-link"><a href="{{ url('/home') }}">Home</a>
	        <ul class="dropdown-menu">
	          <li><a href="{{ url('/home/news') }}">News</a></li>
	          @if(Auth::user()->grade <= 2)
	            <li><a href="{{ url('/home/tactive') }}">Teacher Activities</a></li>
	          @endif
	          @if(Auth::user()->grade == 1 || Auth::user()->grade == 3)
	            <li><a href="{{ url('/home/sactive') }}">Student Activities</a></li>
	          @endif
	        </ul>
	      </li>
	      @if(Auth::user()->grade <= 2)
	        <li class="dropdown-link"><a href="{{ url('/academy') }}">Academy</a>
	          <ul class="dropdown-menu">
	            <li><a href="{{ url('/academy/info') }}">Info Manager</a></li>
	            <li><a href="{{ url('/academy/team') }}">Teacher Teams</a></li>
	          </ul>
	        </li>
	      @endif
	      @if(Auth::user()->grade == 1 || Auth::user()->grade == 3)
	        <li class="dropdown-link"><a href="{{ url('/classgrade') }}">Class</a>
	          <ul class="dropdown-menu">
	            <li><a href="{{ url('/classgrade/info') }}">Class Info</a></li>
	            <li><a href="{{ url('/classgrade/details') }}">Student Details</a></li>
	          </ul>
	        </li>
	      @endif
	      @if(Auth::user()->grade <= 3)
	        <li class="dropdown-link"><a href="{{ url('/report') }}">Report</a>
	          <ul class="dropdown-menu">
	            <li><a href="{{ url('/report/check') }}">Check Records</a></li>
	            <li><a href="{{ url('/report/work') }}">Report Works</a></li>
	          </ul>
	        </li>
	        <li class="dropdown-link"><a href="{{ url('/service') }}">Service</a>
	          <ul class="dropdown-menu">
	            <li><a href="{{ url('/service/email') }}">E-Mail</a></li>
	            <li><a href="{{ url('/service/file') }}">File</a></li>
	            <li><a href="{{ url('/service/note') }}">Note</a></li>
	          </ul>
	        </li>
	      @endif
	    </ul>

	    <ul class="nav navbar-nav navbar-right homenav-bar">
	      <li class="dropdown" style="margin-right: -15px;">
		    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
		    <ul class="dropdown-menu" role="menu">
		      @if(Auth::user()->grade == 1 || Auth::user()->privilege == 5)
		        <li><a href="{{ url('/admin') }}">Console</a></li>
		      @endif
		      <li><a href="{{ url('/setting') }}">Setting</a></li>
		      <li class="divider"></li>
			  <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
		    </ul>
	      </li>
	    </ul>
	  @endif
      </div>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row">
     @if (Auth::guest())
       <div class="container">
        @yield('content')
      </div>
     @else
      <div class="col-sm-3 col-md-2 appside">
	    @yield('sidemenu')
      </div>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
        @yield('content')
      </div>
    @endif
    </div>
  </div>
</body>
</html>
