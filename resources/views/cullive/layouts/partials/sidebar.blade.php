<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                </div>
            </div>
        @endif

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('message.console') }}</li>
            <!-- Optionally, you can add icons to the links -->
            @foreach($dashconfig['header'] as $header)
            @if($header['action'] == $curreq)
            <li id="menu_{{ $header['action'] }}" class="active">
            @else
            <li id="menu_{{ $header['action'] }}">
            @endif
              <a href="javascript:updateMenuView('menu_{{ $header['action'] }}', '{{ $header['link'] }}')">
                <i class="{{ $header['img'] }}"></i>
                <span>{{ $header['menu'] }}</span>
              </a>
            </li>
            @endforeach
        </ul><!-- /.sidebar-menu -->
    </section>
    <script type="text/javascript">
      function updateMenuView(myele, path) {
    	  updateViewPost(path, 'contentwrap', '', '{{ csrf_token() }}');
    	  $('.sidebar-menu li').removeClass('active');
    	  $('#'+myele).addClass('active');
      }
    </script>
    <!-- /.sidebar -->
</aside>
