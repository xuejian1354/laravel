@section('userreport')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h5 style="float: right;">当前用户: {{ $user->name }}<br>
  <a href="admin?action=usermanage&tabpos={{ $user->grade-1 }}" style="float: right; margin-top: 5px;">用户返回</a></h5>
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
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
</div>
<script type="text/javascript">
$('#termchoose').change(function(){
	var reurl = 'admin?action=userreport&id={{ $user->id }}&term='+$(this).val();
	location.replace(reurl);
});
</script>
@endsection