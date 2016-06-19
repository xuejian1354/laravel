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
  @if($user->grade == 2)
  <span>选择考试：</span>
  <select id="optsel" class="setselect">
    <option class="setblank"></option>
  @foreach($exams as $exam)
    @if(Input::get('examsn') == $exam->sn)
    <option examsn="{{ $exam->sn }}" coursesn="{{ $exam->coursesn }}" selected="selected">{{ $exam->name }}</option>
    @else
    <option examsn="{{ $exam->sn }}" coursesn="{{ $exam->coursesn }}">{{ $exam->name }}</option>
    @endif
  @endforeach
  </select>
  <div id="optlist">
  </div>
  @elseif($user->grade == 3)
  <div class="table-responsive" style="max-width: 400px;">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>序列号</th>
          <th>考试</th>
          <th>成绩</th>
        </tr>
      </thead>
      <tbody>
      @foreach($exams as $index => $exam)
      <tr>
        <td>{{ $index+1 }}</td>
        <td><span>{{ $exam->sn }}</span></td>
        <td><span>{{ $exam->name }}</span></td>
        <td><span>{{ $exam->score }}</span></td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
  @endif
</div>
<script type="text/javascript">
@if($user->grade == 2)
function scoreEdtClick()
{
	if($('.scoreedt').text() != '修改')
	{
		$('.scoreedt').text('修改');
		$('.scorecommit').addClass('hidden');
		$('.scoreval').each(function(){
			var tval = $(this).find('input').val();
			$(this).text(tval);
		});
	}
	else
	{
		$('.scoreedt').text('取消');
		$('.scorecommit').removeClass('hidden');
		$('.scoreval').each(function(){
			var tval = $(this).text();
			$(this).html('<input class="scoreinputval" type="text" value="' + tval + '" style="width: ' + 26 + 'pt; border: 0; padding: 0; text-align:center; line-height: normal;">');
		});
	}
}

function examSelect()
{
	var examsn = $('#optsel option:selected').attr('examsn');
	var coursesn = $('#optsel option:selected').attr('coursesn');
	loadContent('optlist', '/admin?action=userscore/opt&id={{ $user->id }}&examsn='+examsn+'&coursesn='+coursesn);
}

function changeScoreRequest()
{
	var tobj = new Object();
	tobj.userid = {{ $user->id }};
	tobj.examsn = $('#optsel option:selected').attr('examsn');
	tobj.coursesn = $('#optsel option:selected').attr('coursesn');
	tobj.scores = new Array();

	$('.trlist').each(function(){
		var score = new Object();
		score.usersn = $(this).find('.studsn').text();
		score.scoreval = $(this).find('.scoreval input').val();
		if(score.scoreval.trim() != "")
		{
			tobj.scores.push(score);
		}
	});

	//alert(JSON.stringify(tobj));
	dataPost('/admin/userscore/edt', JSON.stringify(tobj), '{{ csrf_token() }}');
}

$('.setblank').remove();
@if(Input::get('examsn'))
examSelect();
@else
$('.setselect').val('');
@endif

$('#optsel').change(function(){
	examSelect();
});
@endif

$('#termchoose').change(function(){
	var reurl = '/admin?action=userscore&id={{ $user->id }}&term='+$(this).val();
	location.replace(reurl);
});
</script>