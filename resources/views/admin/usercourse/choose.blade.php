<div>
  <a href="{{ $returnurl }}">返回</a><br>
  @if($user->grade == 1)
  <div class="alert alert-info" style="margin-top: 5px;">
    学期：{{ $term->val }} ({{ date('Y年m月d日', strtotime($term->arrangestart)) }} ～ {{ date('Y年m月d日', strtotime($term->arrangeend)) }})
  </div>
  @if($coursechoose['choose'] == 1)
  @if(strcmp(date('Y-m-d'), $coursechoose['dateline']) <= 0)
  <div class="alert alert-success">
    <span style="font-size: 18pt; font-weight:bold;">学生选课功能已启动</span>
  @else
  <div class="alert" style="background-color: #e0e0e0;">
    <span style="font-size: 18pt; font-weight:bold;">学生选课已过期</span>
  @endif
    <br>截止时间：<span style="font-weight:bold;">{{ $coursechoose['dateline'] }}</span>
  </div>
  <a href="javascript:StartCourseAlert('0');" class="btn btn-danger" style="margin-right: 10px;">结束选课</a>
  @else
  <a href="javascript:StartCourseAlert('1');" class="btn btn-primary" style="margin-right: 10px;">启动选课</a>
  <br>
  <h3 style="margin-top: 40px;">1.时间设置</h3>
    截止时间：<input id="coursechoosetime" type="text" value="{{ $coursechoose['dateline'] }}">
  <h3 style="margin-top: 40px;">2.班级设置</h3>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>班级</th>
        <th>添加选课</th>
        <th>可选课程</th>
        <th style="width: 100px;"><a href="javascript:tSaveCourseAlert();" class="btn btn-info">暂存设置</a></th>
      </tr>
    </thead>
    <tbody>
      @foreach($classgrades as $index => $classgrade)
      <tr>
        <td style="width: 120px;">{{ $classgrade->val }}</td>
        <td style="width: 80px;">
          <select id="setcourse{{ $index }}" class="setcourse" idval="{{ $index }}" style="height: 26px;">
            <option class="setblank"></option>
            <option>-----------清除-----------</option>
            <option>-----------重置-----------</option>
            @foreach($courses as $course)
            <option>{{ $course->course }}</option>
            @endforeach
          </select>
        </td>
        <td><span id="coursesval{{ $index }}" class="coursesval" idval="{{ $index }}" classgrade="{{ $classgrade->classgrade }}" deval="{{ $classgrade->termcourse }}">{{ $classgrade->termcourse }}</span></td>
        <td></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @endif
  @endif
</div>
<script type="text/javascript" src="{{ asset('/js/laydate.js') }}"></script>
<script type="text/javascript">
function getCoursesObj()
{
	var tobj = new Object(); 
	tobj.term = '{{ $term->val }}';
	tobj.userid = '{{ $user->id }}';

	tobj.returnurl = "/course/choice";
    if($('#adminflag').text() == 1)
    {
    	tobj.returnurl = "/admin";
    }
    tobj.returnurl += "?action=usercourse/choose&id={{ $user->id }}";
    if($('#adminflag').text() == 1)
    {
    	tobj.returnurl += "&adminmenus=1";
    }

	tobj.courses = new Array();

	$('.coursesval').each(function(){
		var setcourse = $('#setcourse' + $(this).attr('idval'));
		if(setcourse.val() != null
			&& !(setcourse.val()).match('重置')
			&& $(this).text() != '')
		{
			var course = new Array($(this).attr('classgrade'), $(this).text());
			tobj.courses.push(course);
		}
	});

	return tobj;
}

function tSaveCourseAlert()
{
	var tobj = getCoursesObj();
	dataPost('/admin/usercourse/choose/tsave', JSON.stringify(tobj), '{{ csrf_token() }}', null);
}

function StartCourseAlert(choose)
{
	var dateStr = getCurDate();

	var tobj = getCoursesObj();

	tobj.choose = choose;
	tobj.dateline = $('#coursechoosetime').val();
	if(choose == '1' && dateStr.localeCompare(tobj.dateline) >= 0)
	{
		alert('截止日期必须大于今天 '+dateStr);
		return;
	}

	dataPost('/admin/usercourse/choose/start', JSON.stringify(tobj), '{{ csrf_token() }}', null);	
}

laydate({elem: '#coursechoosetime', format: 'YYYY-MM-DD'});

if($('#coursechoosetime').val() == '')
{
	$('#coursechoosetime').val(getCurDate());
}

$('.setblank').remove();
$('.setcourse').val('');

$('.setcourse').change(function(){
  var idval = $(this).attr('idval');
  var courses = $('#coursesval'+idval);

  if($(this).val().match('清除'))
  {
	  courses.text('');
  }
  else if($(this).val().match('重置'))
  {
	  courses.text(courses.attr('deval'));
  }
  else
  {
	  var btext = courses.text();
	  if(btext != '')
	  {
		  if(!btext.match($(this).val()))
		  {
		      courses.text(btext + ', ' + $(this).val());
		  }
	  }
	  else
	  {
		  courses.text($(this).val());
	  }
  }
});
</script>