<div id="coursecontent">
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
  <a href="javascript:courseChooseRequest();" class="btn btn-info">选课</a>
  <a href="javascript:courseChangeRequest();" class="btn btn-success" style="margin-left: 5px;">调课</a>
  <script type="text/javascript">
    function courseChooseRequest() {
      var url = "/course/choice";
      if($('#adminflag').text() == 1)
      {
          url = "/admin";
      }

      url += "?action=usercourse/choose&id={{ $user->id }}&term=" + $('#coursechoose').val();

      if($('#adminflag').text() == 1)
      {
	      url += "&adminmenus=1"
      }

      location.replace(url);
    }

    function courseChangeRequest() {
      var url = "/course/choice";
      if($('#adminflag').text() == 1)
      {
          url = "/admin";
      }

      url += "?action=usercourse/change&id={{ $user->id }}&term=" + $('#coursechoose').val();

      if($('#adminflag').text() == 1)
      {
	      url += "&adminmenus=1"
      }

      location.replace(url);
    }
  </script>
</div>