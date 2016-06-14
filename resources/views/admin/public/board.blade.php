@section('board')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
      <ul class="nav nav-sidebar">
        @foreach ($menus as $menu)
          @if($menu->mmenu == $amenu->mmenu)
            @if($menu->cmenu == 'NULL')
              <li class="disabled hidden"><a href="#">
            @elseif($menu->cmenu == $amenu->cmenu)
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
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      @if($amenu->mmenu == '功能')
      <h5 style="float: right;">当前用户: {{ $user->name }}<br>
      <a href="admin?action=usermanage&tabpos={{ $user->grade-1 }}" style="float: right; margin-top: 5px;">用户返回</a></h5>
      @endif
      <h1 class="page-header">{{ $amenu->cmenu }}</h1>
      @include('admin.'.$amenu->action.'.'.$amenu->caction)
    </div>
  </div>
</div>
@endsection

