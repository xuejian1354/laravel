@section('sidemenu')
<div class="list-group">
  <a href="{{url('/setting/password')}}" class="list-group-item
  @if($title == 'password')
    {{ 'active' }}
  @endif
  ">密码修改</a>
  <a href="{{url('/setting/details')}}" class="list-group-item
  @if($title == 'details')
    {{ 'active' }}
  @endif
  ">个人资料</a>
  <a href="{{url('/setting/records')}}" class="list-group-item
  @if($title == 'records')
    {{ 'active' }}
  @endif
  ">操作记录</a>
</div>
@endsection