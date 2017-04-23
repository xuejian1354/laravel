<!-- Main Header -->
<header class="main-header">

  <!-- Logo -->
  <a href="/" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>C</b>ul</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>{{ App\Globalval::getVal('title') }}</b></span>
  </a>

  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li><a href="/devstats"><i class="fa fa-gears"></i></a></li>
        <li class="dropdown user user-menu">
          <!-- Menu Toggle Button -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- The user image in the navbar-->
            <img src="{{ asset('/user.png') }}" class="user-image" alt="User Image">
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <span class="hidden-xs">{{ Auth::user()->name }}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- The user image in the menu -->
            <li class="user-header">
              <img src="{{ asset('/user.png') }}" class="img-circle" alt="User Image">

              <p>
                {{ Auth::user()->name }}
                <small>Member since {{ date('j M. Y', strtotime(Auth::user()->created_at)) }}</small>
              </p>
            </li>

            <li class="user-footer">
              <div class="pull-left">
                <a href="/curinfo/user" class="btn btn-default btn-flat">设置</a>
              </div>
              <div class="pull-right">
                <a href="{{ url('/logout') }}" class="btn btn-default btn-flat"
                      onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">退出</a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <!-- li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li -->
      </ul>
    </div>
  </nav>
</header>