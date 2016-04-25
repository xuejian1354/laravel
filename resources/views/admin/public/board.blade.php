@section('board')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
      <ul class="nav nav-sidebar">
        @foreach ($menus as $menu)
          @if($menu->mmenu == $amenu->mmenu)
            @if($menu->cmenu == $amenu->cmenu)
              <li class="active"><a href="javascript:void(0);">
            @elseif($amenu->action == 'useractivity' || $amenu->action == 'usercourse' || $amenu->action == 'userclassgrade' || $amenu->action == 'userreport' || $amenu->action == 'userexam' || $amenu->action == 'userscore' || $amenu->action == 'userdetails' || $amenu->action == 'userrecord')
              <li><a href="{{ url('/admin?action='.$menu->action).'&id='.$user->id }}">
            @else
              <li><a href="{{ url('/admin?action='.$menu->action) }}">
            @endif
              {{ $menu->cmenu }}</a></li>
          @endif
        @endforeach
      </ul>
    </div>
    @yield($amenu->caction)
  </div>
</div>
@endsection

