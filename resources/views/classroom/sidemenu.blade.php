@section('sidemenu')
@if(Auth::user()->grade <= 3 || Auth::user()->privilege > 3)
<div class="list-group">
  <a href="/classroom/status" class="list-group-item
    @if($title == 'status')
      {{ 'active' }}
    @endif
  ">使用情况</a>
  @if(Auth::user()->grade == 1 || Auth::user()->privilege > 3)
  <a href="/classroom/opt" class="list-group-item
    @if($title == 'opt')
      {{ 'active' }}
    @endif
  ">教室操作</a>
  @endif
</div>
@endif
@endsection