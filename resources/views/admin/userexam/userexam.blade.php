<div>
  @if($user->grade == 2 || $user->grade == 3)
  <div style="margin-bottom: 10px;">
    <span>学期</span>
    <select id="termchoose" style="margin: 10 0px;">
      @foreach($terms as $aterm)
      <option
      @if($term->val == $aterm->val)
        selected="selected"
      @endif  
      ischoosen="{{ $aterm->coursechoose }}">{{ $aterm->val }}</option>
      @endforeach
    </select>
  </div>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>序列号</th>
          <th>考试</th>
          <th>时间</th>
          <th>考场</th>
          <th>教师</th>
           @if($user->grade == 2)
          <th><a href="" data-target="#examAddModal" data-toggle="modal">添加</a></th>
          @endif
        </tr>
      </thead>
      <tbody>
      @foreach($exams as $index => $exam)
      <tr class="examtab" isedt="0">
        <td>{{ $index+1 }}</td>
        <td class="examsn"><span>{{ $exam->sn }}</span></td>
        <td class="examname"><span>{{ $exam->name }}</span></td>
        <td class="examtime"><span>{{ $exam->time }}</span></td>
        <td class="examaddr"><span>{{ $exam->addr }}</span></td>
        <td class="examowner"><span>{{ $exam->owner }}</span></td>
        @if($user->grade == 2)
        <td class="examedtcheck"><input type="checkbox" class="examcheck"></td>
        @endif
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
  @if($user->grade == 2)
  <div class="nav navbar-nav navbar-right examedt hidden">
    <a href="javascript:examEdtRequest();" class="btn btn-primary" role="button">修改</a>
    <a href="javascript:examDelRequest();" class="btn btn-danger" role="button">删除</a>
  </div>
  <div class="modal fade" role="dialog" id="examAddModal">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header"><a class="close" data-dismiss="modal">×</a>
            <h3 id="examAddHeader">添加考试</h3>
          </div>
          <div id="examAddBody" class="modal-body container-fluid">
            <div class="table-responsive">
              <table class="table table-striped">
              <thead>
              <tr>
                <th>考试</th>
                <th>课程</th>
                <th>时间</th>
                <th>考场</th>
                <th>教师</th>
              </tr>
              </thead>
              <tbody>
                <td><input id="examAddname" type="text" style="width: 100px;"></td>
                <td>
                  <select id="examcourse">
                  @foreach($courses as $course)
                    <option sn="{{ $course->sn }}" addr="{{ $course->room }}" time="{{ $course->time }}">{{ $course->coursename }}</option>
                  @endforeach
                  </select>
                </td>
                <td><input id="examAddtime" type="text" style="width: 160px;"></td>
                <td><input id="examAddaddr" type="text" style="width: 60px;"></td>
                <td><input id="examAddowner" type="text" value="{{ $user->name }}" style="width: 60px;"></td>
              </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button onclick="javascript:examAddRequest();" type="submit" class="btn btn-primary">添加</button>
            <button type="button" class="btn" data-dismiss="modal">取消</button>
          </div>
      </div>
    </div>
  </div>
  @endif
  @endif
</div>

<script type="text/javascript">
@if($user->grade == 2)
function syncSelectVal()
{
	var opt = $('#examcourse option:selected');
	$('#examAddname').val(opt.val());
	$('#examAddtime').val(opt.attr('time'));
	$('#examAddaddr').val(opt.attr('addr'));
}

function examAddRequest()
{
	var tobj = new Object(); 
	tobj.name = $('#examAddname').val();
	tobj.coursesn = $('#examcourse option:selected').attr('sn');
	tobj.time = $('#examAddtime').val();
	tobj.addr = $('#examAddaddr').val();
	tobj.owner = $('#examAddowner').val();
	tobj.returnurl = 'admin?action=userexam&id={{ $user->id }}';

	//alert(JSON.stringify(tobj));
	dataPost('/admin/userexam/add', JSON.stringify(tobj), '{{ csrf_token() }}');
}

function examEdtRequest()
{
	var tobj = new Object(); 
	tobj.exams = new Array();
	$('.examtab').each(function(){
		if($(this).attr('isedt') == '1')
		{
			var exam = new Object();
			exam.sn = $(this).children('td.examsn').text();
			exam.name = $(this).children('td.examname').children('input').val();
			exam.time = $(this).children('td.examtime').children('input').val();
			exam.addr = $(this).children('td.examaddr').children('input').val();
			exam.owner = $(this).children('td.examowner').children('input').val();
			tobj.exams.push(exam);
		}
	});

	tobj.returnurl = '/admin?action=userexam&id={{ $user->id }}';

	//alert(JSON.stringify(tobj));
	dataPost('/admin/userexam/edt', JSON.stringify(tobj), '{{ csrf_token() }}', '确定要修改选中考试?');
}

function examDelRequest()
{
	var tobj = new Object(); 
	tobj.examsns = new Array();
	$('.examtab').each(function(){
		if($(this).attr('isedt') == '1')
		{
			var sn = $(this).children('td.examsn').text();
			tobj.examsns.push(sn);
		}
	});

	tobj.returnurl = '/admin?action=userexam&id={{ $user->id }}';

	//alert(JSON.stringify(tobj));
	dataPost('/admin/userexam/del', JSON.stringify(tobj), '{{ csrf_token() }}', '确定要删除选中考试?');
}

$('#examcourse').change(function(){
	syncSelectVal();
});
syncSelectVal();

$(".examcheck").click(function() {
  $(this).trigger("examEdtEvent");
});

$(".examcheck").bind("examEdtEvent", function() {
  var examtab = $(this).parent().parent();

  var examsn = examtab.children('td.examsn');
  var examname = examtab.children('td.examname');
  var examtime = examtab.children('td.examtime');
  var examaddr = examtab.children('td.examaddr');
  var examowner = examtab.children('td.examowner');

  var x;
  var examedts = new Array(examname, examtime, examaddr, examowner);

  $('.examedt').removeClass('hidden');

  if($(this).prop('checked'))
  {
	examtab.attr('isedt', '1');
    for(x in examedts)
	{
      if(examedts[x].children('span').width() > 0)
      {
        examedts[x].html('<input type="text" value="' + examedts[x].children('span').text() + '" style="width:' + examedts[x].children('span').width() + 'pt;"></input>');
      }
	}
  }
  else
  {
    var isDisappear = true;
    $('.examcheck').each(function(){
    	if($(this).prop('checked'))
    	{
    		isDisappear = false;
    	}
    });

    examtab.attr('isedt', '0');

    if(isDisappear)
    {
    	$('.examedt').addClass('hidden');
    }

	for(x in examedts)
	{
      if(examedts[x].children('input').val() != undefined)
      {
    	  examedts[x].html('<span>' + examedts[x].children('input').val() + '</span>');
      }
	}
  }
});
@endif

$('#termchoose').change(function(){
	var reurl = '/admin?action=userexam&id={{ $user->id }}&term='+$(this).val();
	location.replace(reurl);
});
</script>