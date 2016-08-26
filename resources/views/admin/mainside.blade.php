<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset('/bower_components/AdminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>Alexander Pierce</p>
        <!-- Status -->
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">智能农业系统</li>
      <!-- Optionally, you can add icons to the links -->
      <li class="active">
        <a href="{{ url('curinfo') }}"><i class="fa fa-paw"></i><span>当前信息</span></a>
      </li>
      <li class="treeview">
        <a href="#"><i class="fa fa-file-picture-o"></i> <span>场景监控</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="{{ url('areactrl') }}"><i class="fa fa-th-large"></i>大棚1</a>
          </li>
          <li>
            <a href="{{ url('areactrl') }}"><i class="fa fa-th-large"></i>大棚2</a>
          </li>
          <li>
            <a href="{{ url('areactrl') }}"><i class="fa fa-align-center"></i>鱼业基地</a>
          </li>
          <li>
            <a href="{{ url('areactrl') }}"><i class="fa fa-pause"></i>养猪场</a>
          </li>
        </ul>
      </li>
      <li>
        <a href="{{ url('devstats') }}"><i class="fa fa-chain"></i> <span>设备状态</span></a>
      </li>
      <li>
        <a href="{{ url('videoreal') }}"><i class="fa fa-video-camera"></i> <span>视频图像</span></a>
      </li>
      <li>
        <a href="{{ url('alarminfo') }}"><i class="fa fa-volume-up"></i> <span>报警提示</span></a>
      </li>
    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>
