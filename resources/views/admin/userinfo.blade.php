@section('userinfo')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="nav-li active"><a href="javascript:void(0);">管理员</a></li>
    <li role="presentation" class="nav-li"><a href="javascript:void(0);">教师</a></li>
    <li role="presentation" class="nav-li"><a href="javascript:void(0);">学生</a></li>
  </ul>
</div>
@endsection
