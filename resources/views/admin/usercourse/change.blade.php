<div>
  <a href="/admin?action=usercourse&id={{ $user->id }}">返回</a><br>
  @if($user->grade == 1)
  <div class="alert alert-info" style="margin-top: 5px;">
    学期：{{ $term->val }} ({{ date('Y年m月d日', strtotime($term->arrangestart)) }} ～ {{ date('Y年m月d日', strtotime($term->arrangeend)) }})
  </div>
  @if($coursechoose['choose'] == 1
        && strcmp(date('Y-m-d'), $coursechoose['dateline']) <= 0)
  <div class="alert alert-success">
    <span style="font-size: 18pt; font-weight:bold;">学生选课功能已启动</span>
    <br><span>必须结束选课后才能进行调课</span>
  </div>
  <a href="javascript:EndforCourseAlert();" class="btn btn-danger" style="margin-right: 10px;">结束选课</a>
  @else
  <table class="table table-striped" style="min-width: 858px;">
  <thead>
    <tr>
      <th>#</th>
      <th>序列号</th>
      <th>课程</th>
      <th>地点, 时间</th>
      <th>教师</th>
      <td><b>学生</b>(<a href="javascript:void(0);">*可调</a>)</td>
      <th>人数/容量</th>
      <th>课时</th>
    </tr>
  </thead>
  <tbody>
    @foreach($courses as $course)
    <tr class="coursetr">
      <td class="courseindex">{{ $course->index+1 }}</td>
      <td class="coursesn">{{ $course->sn }}</td>
      <td class="coursename">{{ $course->course }}</td>
      <td class="courseaddrtime">
      @foreach($course->addrtimes as $addrtime)
        {{ $addrtime }}&nbsp;&nbsp;&nbsp;
      @endforeach
      </td>
      <td class="courseteacher">{{ $course->teacher }}</td>
      <td class="coursestudents">
        <div class="dropdown">
          @if(count($course->students) > 0)
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-submenu>{{ $course->students[0]->name }}</a>
          <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="studLabel">
          @foreach($course->students as $student)
            <li class="dropdown-submenu">
              <a tabindex="-1" href="">{{ $student->name }}</a>
              <ul class="dropdown-menu">
                @foreach($student->selcourses as  $iname => $selcourse)
                @foreach($selcourse as $sindex => $scourse)
                  @if($scourse->ischoose != 1)
                    @if($scourse->isconflict == false)
                    <li><a id="{{ $course->sn.$student->id.$scourse->index }}" href="javascript: studCourseChange('{{ $course->sn.$student->id.$scourse->index }}');" userid="{{ $student->id }}" username="{{ $student->name }}" termval="{{ $term->val }}" ids="{{ json_encode($scourse->ids) }}">
                      <span>{{ $sindex }}</span>
                      @foreach($scourse->vals as $sel)
                      <span>&nbsp;&nbsp;&nbsp;{{ $sel->room }} ({{ $sel->time }})</span>
                      @endforeach
                      <span>&nbsp;&nbsp;&nbsp;&nbsp;总数&nbsp;{{ $sel->studnums }}/已选&nbsp;{{ $sel->choosernums }}人</span>
                    </a></li>
                    @endif
                  @else
                  <input type="hidden" value="{{ json_encode($scourse->ids) }}">
                  @endif
                @endforeach
                @endforeach
              </ul>
            </li>
          @endforeach
          </ul>
          @else
          <span>无</span>
          @endif
        </div>
      </td>
      <td class="coursestudnums">{{ count($course->students ).'/'.$course->studnums }}</td>
      <td class="coursenums">{{ $course->coursenums }}</td>
    </tr>
    @endforeach
  </tbody>
  </table>
  @endif
  @endif
</div>
<script type="text/javascript" src="{{ asset('/js/laydate.js') }}"></script>
<script type="text/javascript">
function EndforCourseAlert()
{
	var tobj = new Object();
	tobj.term = '{{ $term->val }}';
	tobj.userid = '{{ $user->id }}';
	tobj.choose = '0';

	tobj.returnurl = '/admin?action=usercourse/change&id={{ $user->id }}&term={{ $term->val }}';

	dataPost('/admin/usercourse/choose/start', JSON.stringify(tobj), '{{ csrf_token() }}', null);	
}

function studCourseChange(id)
{
	var tlink = $('#'+id);
	var tobj = new Object();

	tobj.userid = tlink.attr('userid');
	tobj.username = tlink.attr('username');
	tobj.term = tlink.attr('termval');
	tobj.ids = JSON.parse(tlink.attr('ids'));
	tobj.defids = JSON.parse(tlink.parent().parent().children('input').val());
	tobj.returnurl = '/admin?action=usercourse/change&id={{ $user->id }}&term={{ $term->val }}';

	//alert(JSON.stringify(tobj));
	dataPost('/admin/usercourse/choose/studsave', JSON.stringify(tobj), '{{ csrf_token() }}', null);
}

/*$(".coursetr").hover(function(){
  var colors = new Array("#56A5EC", "#43BFC7", "#3EA055", "#FFA62F", "#F75D59", "#C48793", "#E45E9D");
  var index = $(this).children('.courseindex').text();
  $(this).css("background-color", colors[(index-1)%colors.length]);
},function(){
  $(this).css("background-color","white");
});*/

$('[data-submenu]').submenupicker();

@if(Input::get('warning') != null)
alert("{!! Input::get('warning') !!}");
@endif
</script>