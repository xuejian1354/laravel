<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>Cul</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>{{ trans('message.appname') }}</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li><a title="{{ $dashconfig['header']['feedback']['menu'] }}" href="javascript:updateMenuView('menu_{{ $dashconfig['header']['feedback']['action'] }}', '{{ $dashconfig['header']['feedback']['link'] }}')">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-success">4</span>
                </a></li>
                <li><a title="{{ $dashconfig['header']['optrecord']['menu'] }}" href="javascript:updateMenuView('menu_{{ $dashconfig['header']['optrecord']['action'] }}', '{{ $dashconfig['header']['optrecord']['link'] }}')">
                  <i class="fa fa-flag-o"></i>
                  <span class="label label-danger">9</span>
                 </a></li>
                <li><a title="{{ $dashconfig['header']['alarminfo']['menu'] }}" href="javascript:updateMenuView('menu_{{ $dashconfig['header']['alarminfo']['action'] }}', '{{ $dashconfig['header']['alarminfo']['link'] }}')">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">10</span>
                </a></li>
                @if (Auth::guest())
                    <li><a href="{{ url('/register') }}">Register</a></li>
                    <li><a href="{{ url('/login') }}">Login</a></li>
                @else
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{ Gravatar::get($user->email) }}" class="user-image" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                                <p>
                                    {{ Auth::user()->name }}
                                    <small>Member since {{ date('j M. Y', strtotime(Auth::user()->created_at)) }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Sign out
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input type="submit" value="logout" style="display: none;">
                                    </form>

                                </div>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>
