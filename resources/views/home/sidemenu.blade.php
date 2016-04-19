@section('sidemenu')
<div class="list-group">
  <a href="/home/news" class="list-group-item
    @if($title == 'news')
      {{ 'active' }}
    @endif
  ">News</a>
  @if(Auth::user()->grade <= 2)
    <a href="/home/tactive" class="list-group-item
      @if($title == 'tactive')
        {{ 'active' }}
      @endif
    ">Teacher Activities</a>
  @endif
  @if(Auth::user()->grade == 1 || Auth::user()->grade == 3)
    <a href="/home/sactive" class="list-group-item
      @if($title == 'sactive')
        {{ 'active' }}
      @endif
    ">Student Activities</a>
  @endif
</div>
@endsection