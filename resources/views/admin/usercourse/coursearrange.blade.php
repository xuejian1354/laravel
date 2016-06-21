<div id="coursecontent">
  <span>学期</span>
  <select id="coursearrange" style="height: 26px;">
    @for($index=0; $index < count($terms); $index++)
    <option class="arropt"
    @if($term->val == $terms[$index]->val)
      selected="selected"
    @endif 
    isarranged="{{ $terms[$index]->coursearrange }}" start="{{ date('Y-m-d', strtotime($terms[$index]->arrangestart)) }}" end="{{ date('Y-m-d', strtotime($terms[$index]->arrangeend)) }}">{{ $terms[$index]->val }}</option>
    @endfor
  </select><br>
  @if($terms[0]->coursearrange)
  <div style="margin: 10px 0;"> 从：<input id="termstime" type="text" value="{{ date('Y-m-d', strtotime($terms[0]->arrangestart)) }}" style="margin-right: 10px;"> 到：<input id="termetime" type="text" value="{{ date('Y-m-d', strtotime($terms[0]->arrangeend)) }}"></div>
  @else
  <div style="margin: 10px 0;"> 从：<input id="termstime" type="text" style="margin-right: 10px;"> 到：<input id="termetime" type="text"></div>
  @endif
  <a id="coursearrangehref" href="javascript:courseArrangeRequest();" class="btn btn-primary" style="margin-bottom: 10px;">排课</a>
  <script type="text/javascript" src="{{ asset('/js/laydate.js') }}"></script>
  <script type="text/javascript">
    function courseArrangeRequest() {
      var url = "/course/arrange";
      if($('#adminflag').text() == 1)
      {
          url = "/admin";
      }

      url += "?action=usercourse/arrange&id={{ $user->id }}&term="
            	  + $('#coursearrange').val()
            	  + "&start="
            	  + $('#termstime').val()
            	  + "&end="
            	  + $('#termetime').val();

      if($('#adminflag').text() == 1)
      {
	      url += "&adminmenus=1"
      }

      location.replace(url);
    }

    courseArrangeChanged();

    laydate({elem: '#termstime', format: 'YYYY-MM-DD'});
    laydate({elem: '#termetime', format: 'YYYY-MM-DD'});
  </script>
</div>