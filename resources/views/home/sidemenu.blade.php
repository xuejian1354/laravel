@section('sidemenu')
<div class="list-group">
  <a href="/home/status" class="list-group-item
    @if($title == 'status')
      {{ 'active' }}
    @endif
  ">总览</a>
  <a href="/home/news" class="list-group-item
    @if($title == 'news')
      {{ 'active' }}
    @endif
  ">活动通知</a>
</div>
@endsection