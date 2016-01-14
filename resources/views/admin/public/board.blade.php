@section('board')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
      <ul class="nav nav-sidebar">
        @foreach ($menus as $menu)
          @if($menu->mmenu == $amenu->mmenu)
            <li
              @if($menu->cmenu == $amenu->cmenu)
                class="active"><a href="javascript:void(0);">
              @else
                ><a href="{{ url('/admin?action='.$menu->action) }}">
              @endif{{ $menu->cmenu }}</a></li>
          @endif
        @endforeach
      </ul>
    </div>
    @yield($amenu->action)
  </div>
</div>
@endsection

