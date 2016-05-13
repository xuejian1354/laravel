@section('arrange')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h5 style="float: right;">当前用户: {{ $user->name }}<br>
  <a href="admin?action=usermanage&tabpos={{ $user->grade-1 }}" style="float: right; margin-top: 5px;">用户返回</a></h5>
  <h1 class="page-header">新学期排课</h1>
  <a href="admin?action=usercourse&id={{ $user->id }}">返回</a><br>
  @if($user->grade == 1)
  <div class="alert alert-info" style="margin-top: 5px;">
    学期：{{ $term->val }} ({{ date('Y年m月d日', strtotime($term->arrangestart)) }} ～ {{ date('Y年m月d日', strtotime($term->arrangeend)) }})
  </div>
  <div>
    <span>选择教师：</span>
    <select id="arrangeteacher">
    @foreach($teachers as $teacher)
      <option>{{ $teacher->name }}</option>
    @endforeach
    </select>
  </div>
  <div style="margin: 10px 0;">
    <span>查看方式：</span>
    <select>
      <option>按周查看</option>
      <!-- option>按月查看</option -->
    </select>
  </div>
  <div id="weektbody">
    @include('admin.usercourse.weektbody')
  </div>
  @elseif($user->grade == 2)
  @elseif($user->grade == 3)
  @else
  @endif
</div>
@if($user->grade == 1)
<script type="text/javascript">
function arrangeWeekEdt()
{
	if($('#weekedt').text() == '编辑')
	{
		$('#weekedt').text('取消');
		$('.arrangeweekcourse').addClass('arrangeweekcourseedt');
	}
	else
	{
		$('#weekedt').text('编辑');
		$('.arrangeweekcourse').removeClass('arrangeweekcourseedt');
	}
}

function loadWeekEdt(id)
{
	if($('#weekedt').text() == '取消')
	{
		alert($('#'+id).text());
	}
}

$('#arrangeteacher').change(function(){
	loadContent('weektbody', 'admin?action=usercourse/arrange&id={{ $user->id }}&term={{ $term->val }}&teacher=' + $('#arrangeteacher').val() + '&isweektbody=true');
});
</script>
@endif
@endsection