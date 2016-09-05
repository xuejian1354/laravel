<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset('/user.png') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->name }}</p>
        <!-- Status -->
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">智能农业系统</li>
      <!-- Optionally, you can add icons to the links -->
      @foreach($console_menus[0] as $home_menu)
        @if($home_menu->haschild == 0)
        @if(isset($home_menu->isactive) && $home_menu->isactive == true)
        <li class="active">
        @else
        <li>
        @endif
          <a href="{{ App\Http\Controllers\AdminController::withurl($home_menu->action) }}">
            <i class="{{ $home_menu->img }}"></i><span>{{ $home_menu->name }}</span>
          </a>
        </li>
        @else
        @if(isset($home_menu->isactive) && $home_menu->isactive == true)
        <li class="treeview active">
        @else
        <li class="treeview">
        @endif
          <a href="#"><i class="{{ $home_menu->img }}"></i>
            <span>{{ $home_menu->name }}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          @if(isset($console_menus[$home_menu->inode]))
            @foreach($console_menus[$home_menu->inode] as $child_menu)
            @if(isset($child_menu->isactive) && $child_menu->isactive == true)
            <li class="active">
            @else
            <li>
            @endif
              <a href="{{ App\Http\Controllers\AdminController::withurl($child_menu->action) }}">
                <i class="{{ $child_menu->img }}"></i><span>{{ $child_menu->name }}</span>
              </a>
            </li>
            @endforeach
          @else
            <li><a href="#"><i></i><span>None</span></a></li>
          @endif
          </ul>
        </li>
        @endif
      @endforeach
    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>
