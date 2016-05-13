@section('choose')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h5 style="float: right;">当前用户: {{ $user->name }}<br>
  <a href="admin?action=usermanage&tabpos={{ $user->grade-1 }}" style="float: right; margin-top: 5px;">用户返回</a></h5>
  <h1 class="page-header">学生选课</h1>
  <a href="admin?action=usercourse&id={{ $user->id }}">返回</a><br>
  @if($user->grade == 1)
  @elseif($user->grade == 2)
  @elseif($user->grade == 3)
  @else
  @endif
</div>
@endsection