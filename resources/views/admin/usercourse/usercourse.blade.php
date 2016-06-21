<div id="coursecontent">
  @if($user->grade == 1)
  <h3>1.教师排课</h3>
  @include('admin.usercourse.coursearrange')
  <br><br>
  <h3>2.学生选课</h3>
  @include('admin.usercourse.coursechoice')
  @elseif($user->grade == 2)
  <div class="alert alert-info" style="margin-top: 5px;">
    <span>学期：{{ $term->val }} ({{ date('Y年m月d日', strtotime($term->arrangestart)) }} ～ {{ date('Y年m月d日', strtotime($term->arrangeend)) }})</span>
    @if($coursechoose['choose'] == 1)
    <br><br><span><b>选课时间</b>，截止日期：{{$coursechoose['dateline']}}</span>
    @endif
  </div>
  <span>学期</span>
  <select id="coursequery">
    @foreach($terms as $t)
      @if($term->val == $t->val)
      <option selected="selected">{{ $t->val }}</option>
      @else
      <option>{{ $t->val }}</option>
      @endif
    @endforeach
  </select>
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
  <div id="coursestudsinfo" class="hidden"></div>
  <div class="modal fade" role="dialog" id="teachercourseModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" action="{{ url('/admin/addnews') }}">
          <div class="modal-header"><a class="close" data-dismiss="modal">×</a>
            <h3 id="teachercourseHeader">变更请求</h3>
          </div>
          <div id="teachercourseBody" class="modal-body container-fluid">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="returnurl" value="{{ $returnurl }}">
            <label>标题</label>
            <input id="teacherChangeTitle" name="title" type="text" class="form-control" readonly="true">
            <input name="allowgrade" type="hidden" class="form-control" value="指定用户">
            <label style="margin-top: 10px;">选择管理员</label> ( *建议使用 root )
            <select  name="visitor" class="form-control">
            @foreach($admins as $admin)
              @if($admin->name == 'root')
              <option selected="selected">{{ $admin->name }}</option>
              @else
              <option>{{ $admin->name }}</option>
              @endif
            @endforeach
            </select>
            <label style="margin-top: 10px;">说明</label>
            <textarea name="subtitle" rows="2" class="form-control" placeholder="请添加简短的说明文字，方便管理员处理"></textarea>
            <input type="hidden" name="optid" value="{{ $user->id }}">
            <input type="hidden" name="newsowner" value="{{ $user->name }}">
            <textarea name="text" rows="3" class="form-control hidden">来自 {{ $user->name }} 的课程变更消息，请尽快处理！</textarea>
          </div>
          <div class="modal-footer">
            <button onclick="#" type="submit" class="btn btn-primary">提交</button>
            <button type="button" class="btn" data-dismiss="modal">取消</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @elseif($user->grade == 3)
  <div class="alert alert-info" style="margin-top: 5px;">
    <span>学期：{{ $term->val }} ({{ date('Y年m月d日', strtotime($term->arrangestart)) }} ～ {{ date('Y年m月d日', strtotime($term->arrangeend)) }})</span>
    @if($coursechoose['choose'] == 1)
    <br><br><span><b>课程可选</b>，截止日期：{{$coursechoose['dateline']}}</span>
    @endif
  </div>
  @if(Input::get('choose') == 1)
  <div id="classcourse" class="hidden">
  @else
  <div id="classcourse">
  @endif
  <span>学期</span>
  <select id="coursequery">
    @foreach($terms as $t)
      @if($term->val == $t->val)
      <option selected="selected">{{ $t->val }}</option>
      @else
      <option>{{ $t->val }}</option>
      @endif
    @endforeach
  </select>
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
  <div class="modal fade" role="dialog" id="studentcourseModal">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header"><a class="close" data-dismiss="modal">×</a>
            <h3 id="studentcourseHeader">选课</h3>
          </div>
          <div id="studentcourseBody" class="modal-body container-fluid">
          </div>
          <div class="modal-footer">
            <button onclick="#" type="submit" class="btn btn-primary">提交</button>
            <button type="button" class="btn" data-dismiss="modal">取消</button>
          </div>
      </div>
    </div>
  </div>
  </div>
  @if(Input::get('warning') && Input::get('choose') == 1)
  <div id="warningchoose" class="alert alert-danger" style="margin-top: 5px;">
    <span>{!! Input::get('warning') !!}</span>
  </div>
  @endif
  @if(Input::get('choose') == 1)
  <div id="classchoose">
  @else
  <div id="classchoose" class="hidden">
  @endif
    <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>课程</th>
        <th>选择</th>
      </tr>
    </thead>
    <tbody>
    @foreach($selcourses as $iname => $selcourse)
      <tr>
        <td>{{ $iname }}</td>
        <td>
          @if(count($selcourse) > 0)
          <select class="studchoose" ids="" defids="" style="height: 26px;">
            @foreach($selcourse as $sindex => $scourse)
            <option ids="{{ json_encode($scourse->ids) }}" ischoose="{{ $scourse->ischoose }}"><span>{{ $sindex }}</span>
              @foreach($scourse->vals as $sel)
              <span>&nbsp;&nbsp;&nbsp;{{ $sel->room }} ({{ $sel->time }})</span>
              @endforeach
              <span>&nbsp;&nbsp;&nbsp;&nbsp;总数&nbsp;{{ $sel->studnums }}/已选&nbsp;{{ $sel->choosernums }}人</span>
            </option>
            @endforeach
          </select>
          @else
          <span>暂无排课</span>
          @endif
        </td>
      </tr>
    @endforeach
    </tbody>
    </table>
    <a href="javascript:studCourseChoose();" class="btn btn-primary">提交</a>
    <a href="javascript:arrangeWeekEdt();" class="btn btn-default" style="margin-left: 10px;">取消</a>
  </div>
  @else
  @endif
</div>

@if($user->grade == 2 || $user->grade == 3)
<script type="text/javascript">
$("#coursequery").change(function() {
	var returl = "/course/query";
	if($('#adminflag').text() == 1)
	{
		returl = "/admin";
	}
	returl += "?action=usercourse&id={{ $user->id }}&term="+$("#coursequery").val();
	if($('#adminflag').text() == 1)
	{
		returl += "&adminmenus=1";
	}

	location.replace(returl);
});
@if($user->grade == 2)
$('.arrangeweekbtn').each(function(){
	if($(this).text() != '')
	{
		$(this).removeAttr('disabled');
	}
});
@endif
@if($user->grade == 3)
$('.studchoose').change(function(){
	$(this).attr('ids', $(this).find('option:selected').attr('ids'));
});

function studCourseChoose()
{
	var tobj = new Object(); 
	var ids = new Array();
	var defids = new Array();
	$('.studchoose').each(function(){
		if($(this).val() != null)
		{
			if($(this).attr('ids') != '')
			{
				ids = ids.concat(JSON.parse($(this).attr('ids')));
			}

			if($(this).attr('defids') != '')
			{
				defids = defids.concat(JSON.parse($(this).attr('defids')));
			}
		}
	});

	var reids = ids.slice();
	var redefids = defids.slice();
	/*$.each(ids, function(ikey, ival){
		$.each(defids, function(dkey, dval){
			if(ival == dval)
			{
				reids.splice($.inArray(ival, reids), 1);
				redefids.splice($.inArray(dval, redefids), 1);
			}
		});
	});*/

	tobj.ids = reids;
	tobj.defids = redefids;
	tobj.userid = '{{ $user->id }}';
	tobj.username = '{{ $user->name }}';
	tobj.term = '{{ $term->val }}';

	tobj.adminflag = 0;
	if($('#adminflag').text() == 1)
	{
		tobj.adminflag = 1;
	}

	dataPost('/admin/usercourse/choose/studsave', JSON.stringify(tobj), '{{ csrf_token() }}', null);
}

$('.studchoose').val('');
$('.studchoose option').each(function(){
	if($(this).attr('ischoose') == 1)
	{
		var slt = $(this).parent();
		slt.attr('ids', $(this).attr('ids'));
		slt.attr('defids', $(this).attr('ids'));
		$(this).attr('selected', 'selected');
	}
});
@endif
</script>
@endif