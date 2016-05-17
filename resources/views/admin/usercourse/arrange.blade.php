@section('arrange')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h5 style="float: right;">当前用户: {{ $user->name }}<br>
  <a href="admin?action=usermanage&tabpos={{ $user->grade-1 }}" style="float: right; margin-top: 5px;">用户返回</a></h5>
  <h1 class="page-header">教师排课</h1>
  <a href="admin?action=usercourse&id={{ $user->id }}">返回</a><br>
  @if($user->grade == 1)
  <div class="alert alert-info" style="margin-top: 5px;">
    学期：{{ $term->val }} ({{ date('Y年m月d日', strtotime($term->arrangestart)) }} ～ {{ date('Y年m月d日', strtotime($term->arrangeend)) }})
  </div>
  <div>
    <span>选择教师：</span>
    <select id="arrangeteacher">
    @foreach($teachers as $teacher)
      @if($arrangename == $teacher->name)
      <option selected='selected'>{{ $teacher->name }}</option>
      @else
      <option>{{ $teacher->name }}</option>
      @endif
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
  <div class="modal fade" role="dialog" id="usercourseOptModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"><a class="close" data-dismiss="modal">×</a>
          @if(Input::get('exist') == 1)
            <h3 id="usercourseOptHeader">{{ Input::get('etime') }}</h3>
          @else
            <h3 id="usercourseOptHeader"></h3>
          @endif
        </div>
        <div id="usercourseOptBody" class="modal-body container-fluid">
          <div class="col-sm-4 col-md-4">
            <span>课程：
              @if(Input::get('exist') == 1)
                <input id="ucoursename" type="text" value="{{ Input::get('ecourse') }}" style="width: 70%;">
              @else
                <input id="ucoursename" type="text" style="width: 70%;">
              @endif
            </span>
          </div>
          <div class="col-sm-4 col-md-4">
            <span>教室：
              <select id="ucourseroom" style="width: 70%; height: 26px;">
                @foreach($rooms as $room)
                  @if(Input::get('exist') == 1 && Input::get('eroom') == $room->name)
                    <option selected="selected">{{ $room->name }}</option>
                  @else
                    <option>{{ $room->name }}</option>
                  @endif
                @endforeach
              </select>
            </span>
          </div>
          <div class="col-sm-4 col-md-4">
            <span>课时：
              @if(Input::get('exist') == 1)
                <input id="ucourseremarks" type="text" value="{{ Input::get('eremarks') }}" style="width: 70%;">
              @else
                <input id="ucourseremarks" type="text" style="width: 70%;">
              @endif
            </span>
          </div>
        </div>
        <div class="modal-footer">
          <button onclick="javascript:courseArrangeAlert('{{ csrf_token() }}', '0')" type="button" class="btn btn-primary">确定</button>
          <button onclick="javascript:courseArrangeDelAlert('{{ csrf_token() }}')" type="button" class="btn btn-danger">删除</button>
          <button type="button" class="btn" data-dismiss="modal">取消</button>
        </div>
      </div>
    </div>
  </div>
  @elseif($user->grade == 2)
  @elseif($user->grade == 3)
  @else
  @endif
</div>
@if($user->grade == 1)
<script type="text/javascript">
function courseArrangeAlert(token, force) {

	var tobj = new Object(); 
	tobj.course = $('#ucoursename').val();
	tobj.room = $('#ucourseroom').val();
	tobj.time = $('#usercourseOptHeader').text();
	tobj.cycle = '每周';
	tobj.term = '{{ $term->val }}';
	tobj.teacher = $('#arrangeteacher').val();
	tobj.remarks = $('#ucourseremarks').val();
	
	if($.trim(tobj.course).length > 0)
	{
	    var postForm = document.createElement("form");
	    postForm.method="post";
	    postForm.action = '/admin/usercourse/coursearrange';

	    var dataInput = document.createElement("input");
	    dataInput.setAttribute("name", "data");
	    dataInput.setAttribute("value", JSON.stringify(tobj));
	    postForm.appendChild(dataInput);

	    var returnurlInput = document.createElement("input");
	    returnurlInput.setAttribute("name", "returnurl");
	    returnurlInput.setAttribute("value", "admin?action=usercourse/arrange&edit=1&id={{ $user->id }}&term={{ $term->val }}&start={{ date('Y-m-d-', strtotime($term->arrangestart)) }}&end={{ date('Y-m-d-', strtotime($term->arrangeend)) }}&teacher="+$('#arrangeteacher').val());
	    postForm.appendChild(returnurlInput);

	    var tokenInput = document.createElement("input");
	    tokenInput.setAttribute("name", "_token");
	    tokenInput.setAttribute("value", token);
	    postForm.appendChild(tokenInput);

	    var forceInput = document.createElement("input");
	    forceInput.setAttribute("name", "force");
	    forceInput.setAttribute("value", force);
	    postForm.appendChild(forceInput);

	    document.body.appendChild(postForm);
	    postForm.submit();
	    document.body.removeChild(postForm);
	}
	else
	{
		alert('课程名称不能为空');
	}
}

function courseArrangeDelAlert(token) {

	var tobj = new Object(); 
	tobj.room = $('#ucourseroom').val();
	tobj.time = $('#usercourseOptHeader').text();
	tobj.term = '{{ $term->val }}';
	tobj.teacher = $('#arrangeteacher').val();
	
	if(confirm("确定删除"+tobj.term+tobj.time+"位于"+tobj.room+"处的课程？"))
	{
	    var postForm = document.createElement("form");
	    postForm.method="post";
	    postForm.action = '/admin/usercourse/coursearrangedel';

	    var dataInput = document.createElement("input");
	    dataInput.setAttribute("name", "data");
	    dataInput.setAttribute("value", JSON.stringify(tobj));
	    postForm.appendChild(dataInput);

	    var returnurlInput = document.createElement("input");
	    returnurlInput.setAttribute("name", "returnurl");
	    returnurlInput.setAttribute("value", "admin?action=usercourse/arrange&edit=1&id={{ $user->id }}&term={{ $term->val }}&start={{ date('Y-m-d-', strtotime($term->arrangestart)) }}&end={{ date('Y-m-d-', strtotime($term->arrangeend)) }}&teacher="+$('#arrangeteacher').val());
	    postForm.appendChild(returnurlInput);

	    var tokenInput = document.createElement("input");
	    tokenInput.setAttribute("name", "_token");
	    tokenInput.setAttribute("value", token);
	    postForm.appendChild(tokenInput);

	    document.body.appendChild(postForm);
	    postForm.submit();
	    document.body.removeChild(postForm);
	}
}

$('#arrangeteacher').change(function(){
	loadContent('weektbody', 'admin?action=usercourse/arrange&id={{ $user->id }}&term={{ $term->val }}&teacher=' + $('#arrangeteacher').val() + '&isweektbody=true');
});

@if(Input::get('edit') == 1)
  arrangeWeekEdt();
@endif

@if(Input::get('exist') == 1)
  if(confirm("{{ Input::get('warning') }}")) {
	setTimeout("courseArrangeAlert('{{ csrf_token() }}', '1')", 200);
  }
@endif
</script>
@endif
@endsection