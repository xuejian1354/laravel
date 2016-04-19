@section('sidemenu')
<div class="list-group">
  <a href="{{url('/setting/password')}}" class="list-group-item
  @if($title == 'password')
    {{ 'active' }}
  @endif
  ">Password</a>
</div>
@endsection