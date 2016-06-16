@section('sidemenu')
@if(Auth::user()->grade == 1)
<div class="list-group">
  <a href="/course/arrange" class="list-group-item
    @if($title == 'arrange')
      {{ 'active' }}
    @endif
  ">教师排课</a>
  <a href="/course/choice" class="list-group-item
    @if($title == 'choice')
      {{ 'active' }}
    @endif
  ">学生选课</a>
</div>
@elseif(Auth::user()->grade == 2 || Auth::user()->grade == 3)
<div class="list-group">
  <a href="/course/query" class="list-group-item
    @if($title == 'query')
      {{ 'active' }}
    @endif
  ">课程查询</a>
  <a href="/course/exam" class="list-group-item
    @if($title == 'exam')
      {{ 'active' }}
    @endif
  ">考试安排</a>
  <a href="/course/score" class="list-group-item
    @if($title == 'score')
      {{ 'active' }}
    @endif
  ">成绩发布</a>
</div>
@endif
@endsection