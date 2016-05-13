@section('usercourse')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h5 style="float: right;">当前用户: {{ $user->name }}<br>
  <a href="admin?action=usermanage&tabpos={{ $user->grade-1 }}" style="float: right; margin-top: 5px;">用户返回</a></h5>
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  @if($user->grade == 1)
  <h3>1.新学期排课</h3>
  <span>学期</span>
  <select id="coursearrange">
    @for($index=0; $index < count($terms); $index++)
    <option class="arropt" isarranged="{{ $terms[$index]->coursearrange }}" start="{{ date('Y-m-d', strtotime($terms[$index]->arrangestart)) }}" end="{{ date('Y-m-d', strtotime($terms[$index]->arrangeend)) }}">{{ $terms[$index]->val }}</option>
    @endfor
  </select><br>
  @if($terms[0]->coursearrange)
  <div style="margin: 10px 0;"> 从：<input id="termstime" type="text" value="{{ date('Y-m-d', strtotime($terms[0]->arrangestart)) }}"> 到：<input id="termetime" type="text" value="{{ date('Y-m-d', strtotime($terms[0]->arrangeend)) }}"></div>
  @else
  <div style="margin: 10px 0;"> 从：<input id="termstime" type="text"> 到：<input id="termetime" type="text"></div>
  @endif
  <a id="coursearrangehref" href="javascript:courseArrangeRequest();" class="btn btn-primary" style="margin-bottom: 10px;">进入排课</a>
  <br><br>
  <h3>2.学生选课</h3>
  <span>学期</span>
  <select id="coursechoose">
    @foreach($terms as $term)
    <option ischoosen="{{ $term->coursechoose }}">{{ $term->val }}</option>
    @endforeach
  </select>
  <a href="admin?action=usercourse/choose&id={{ $user->id }}" class="btn btn-primary">学生选课</a>
  @elseif($user->grade == 2)
  @elseif($user->grade == 3)
  @else
  @endif
</div>

<script type="text/javascript" src="{{ asset('/js/laydate.js') }}"></script>
<script type="text/javascript">
function courseArrangeRequest() {
  var xmlhttp;

  if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
        document.write(xmlhttp.responseText);
    }
  }

  xmlhttp.open("GET", "admin?action=usercourse/arrange&id={{ $user->id }}&term="
		  + $('#coursearrange').val()
		  + "&start="
		  + $('#termstime').val()
		  + "&end="
		  + $('#termetime').val(), true);

  xmlhttp.send();
}

laydate({elem: '#termstime', format: 'YYYY-MM-DD'});
laydate({elem: '#termetime', format: 'YYYY-MM-DD'});

</script>
@endsection