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
      <div class="nav navbar-nav dropdown">
        <a class="menu active">状态</a>
        <ul class="dropdown-menu dropdown-auto">
	      <li><a href="#">总览</a></li>
	      <li><a href="#">统计</a></li>
	    </ul>
      </div>
      <div class="nav navbar-nav dropdown">
        <a class="menu">课程</a>
	    <ul class="dropdown-menu dropdown-auto">
	      <li><a href="#">查看</a></li>
	      <li><a href="#">录入</a></li>
        </ul>
      </div>
      <div class="nav navbar-nav dropdown">
        <a class="menu">教室</a>
        <ul class="dropdown-menu dropdown-auto">
          <li><a href="#">使用情况</a></li>
          <li><a href="#">教室控制</a></li>
        </ul>
      </div>
	  <div class="nav navbar-nav dropdown">
        <a class="menu">设备</a>
        <ul class="dropdown-menu dropdown-auto">
          <li><a href="#">状态</a></li>
          <li><a href="#">操作</a></li>
        </ul>
      </div>
	  <div class="nav navbar-nav dropdown">
        <a class="menu">用户</a>
        <ul class="dropdown-menu dropdown-auto">
          <li><a href="#">教师</a></li>
          <li><a href="#">学生</a></li>
        </ul>
      </div>
	  
	  <div class="nav navbar-nav navbar-right dropdown">
        <a id="user-info" class="homemenu dropdown-toggle" data-toggle="dropdown" href="">{{ Auth::user()->name }}</a>
        <ul id="user-list" class="dropdown-menu">
          <li><a href="#">设置</a></li>
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