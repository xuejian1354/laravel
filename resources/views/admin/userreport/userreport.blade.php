<div>
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