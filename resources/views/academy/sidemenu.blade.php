@section('sidemenu')
<div class="list-group">
  <a href="{{url('/academy/info')}}" class="list-group-item
  @if($title == 'info')
    {{ 'active' }}
  @endif
  ">Info Manager</a>
  <a href="{{url('/academy/team')}}" class="list-group-item
  @if($title == 'team')
    {{ 'active' }}
  @endif
  ">Teacher Teams</a>
</div>
@endsection