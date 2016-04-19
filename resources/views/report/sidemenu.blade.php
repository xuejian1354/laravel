@section('sidemenu')
<div class="list-group">
  <a href="/report/check" class="list-group-item
    @if($title == 'check')
      {{ 'active' }}
    @endif
  ">Check Records</a>
  <a href="/report/work" class="list-group-item
    @if($title == 'work')
      {{ 'active' }}
    @endif
  ">Report Works</a>
</div>
@endsection