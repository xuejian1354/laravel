
@section('menuboard')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
      <ul class="nav nav-sidebar">
        <li class="active"><a href="#">总览</a></li>
	    <li><a href="#">统计</a></li>
      </ul>
    </div>
    @yield('content')
  </div>
</div>
@endsection