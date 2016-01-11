
@section('menuboard')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
      <ul class="nav nav-sidebar">
        @foreach ($menus as $menu)
          @if($menu->mmenu == $amenu->mmenu)
            <li
              @if($menu->cmenu == $amenu->cmenu)
                class="active"
              @endif
            ><a href="{{ url('/admin?action='.$menu->action) }}">{{ $menu->cmenu }}</a></li>
          @endif
        @endforeach
      </ul>
    </div>
    @yield('content')
  </div>
</div>
@endsection