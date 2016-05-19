@section('usercourse')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h5 style="float: right;">当前用户: {{ $user->name }}<br>
  <span id="username" class="hidden">{{ $user->name }}</span>
  <a href="admin?action=usermanage&tabpos={{ $user->grade-1 }}" style="float: right; margin-top: 5px;">用户返回</a></h5>
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  @if($user->grade == 1)
  <h3>1.教师排课</h3>
  <span>学期</span>
  <select id="coursearrange" style="height: 26px;">
    @for($index=0; $index < count($terms); $index++)
    <option class="arropt"
    @if($term->val == $terms[$index]->val)
      selected="selected"
    @endif 
    isarranged="{{ $terms[$index]->coursearrange }}" start="{{ date('Y-m-d', strtotime($terms[$index]->arrangestart)) }}" end="{{ date('Y-m-d', strtotime($terms[$index]->arrangeend)) }}">
      {{ $terms[$index]->val }}
    </option>
    @endfor
  </select><br>
  @if($terms[0]->coursearrange)
  <div style="margin: 10px 0;"> 从：<input id="termstime" type="text" value="{{ date('Y-m-d', strtotime($terms[0]->arrangestart)) }}" style="margin-right: 10px;"> 到：<input id="termetime" type="text" value="{{ date('Y-m-d', strtotime($terms[0]->arrangeend)) }}"></div>
  @else
  <div style="margin: 10px 0;"> 从：<input id="termstime" type="text" style="margin-right: 10px;"> 到：<input id="termetime" type="text"></div>
  @endif
  <a id="coursearrangehref" href="javascript:courseArrangeRequest();" class="btn btn-primary" style="margin-bottom: 10px;">进入排课</a>
  <br><br>
  <h3>2.学生选课</h3>
  <span>学期</span>
  <select id="coursechoose" style="height: 26px; margin-right: 10px;">
    @foreach($terms as $aterm)
    <option
    @if($term->val == $aterm->val)
      selected="selected"
    @endif  
    ischoosen="{{ $aterm->coursechoose }}">{{ $aterm->val }}</option>
    @endforeach
  </select>
  <a href="javascript:courseChooseRequest();" class="btn btn-primary">进入选课</a>
  @elseif($user->grade == 2)
  <div class="alert alert-info" style="margin-top: 5px;">
    学期：{{ $term->val }} ({{ date('Y年m月d日', strtotime($term->arrangestart)) }} ～ {{ date('Y年m月d日', strtotime($term->arrangeend)) }})
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
  <div class="modal fade" role="dialog" id="teachercourseModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" action="{{ url('/admin/addnews') }}">
          <div class="modal-header"><a class="close" data-dismiss="modal">×</a>
            <h3 id="teachercourseHeader">变更请求</h3>
          </div>
          <div id="teachercourseBody" class="modal-body container-fluid">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="returnurl" value="admin?action=usercourse&id={{ $user->id }}">
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
  @else
  @endif
</div>

@if($user->grade == 1)
<script type="text/javascript" src="{{ asset('/js/laydate.js') }}"></script>
<script type="text/javascript">
function courseArrangeRequest() {
  location.replace("admin?action=usercourse/arrange&id={{ $user->id }}&term="
            		  + $('#coursearrange').val()
            		  + "&start="
            		  + $('#termstime').val()
            		  + "&end="
            		  + $('#termetime').val());
}

function courseChooseRequest() {
  location.replace("admin?action=usercourse/choose&id={{ $user->id }}&term="
            		  + $('#coursechoose').val());
}

laydate({elem: '#termstime', format: 'YYYY-MM-DD'});
laydate({elem: '#termetime', format: 'YYYY-MM-DD'});
</script>

@elseif($user->grade == 2)
<script type="text/javascript">
$("#coursequery").change(function() {
	location.replace("admin?action=usercourse&id={{ $user->id }}&term="+$("#coursequery").val());
});
</script>
@endif

@endsection