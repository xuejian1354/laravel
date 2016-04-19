@section('sidemenu')
<div class="list-group">
  <a href="/classgrade/info" class="list-group-item
    @if($title == 'info')
      {{ 'active' }}
    @endif
  ">Class Info</a>
  <a href="/classgrade/details" class="list-group-item
    @if($title == 'details')
      {{ 'active' }}
    @endif
  ">Student Details</a>
</div>
@endsection