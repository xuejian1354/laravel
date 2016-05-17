<a id='weekedt' href="javascript:arrangeWeekEdt();" style="float: right;">
@if($user->grade != 2)
    编辑
@else
    变更
@endif
</a>
<table class="table table-striped table-bordered">
<tbody>
<tr>
  <td colspan="2"></td>
  <td class="classlisttitle">星期一</td>
  <td class="classlisttitle">星期二</td>
  <td class="classlisttitle">星期三</td>
  <td class="classlisttitle">星期四</td>
  <td class="classlisttitle">星期五</td>
  <td class="classlisttitle">星期六</td>
  <td class="classlisttitle">星期日</td>
</tr>
@foreach(['1,2', '3,4', '5,6', '7,8', '9,10,11'] as $x => $t1)
<tr>
  @if($t1 == '1,2')
  <td rowspan="2" class="classlisttitle"  style="width: 20px;">上午</td>
  @elseif($t1 == '5,6')
  <td rowspan="2" class="classlisttitle">下午</td>
  @elseif($t1 == '9,10,11')
  <td rowspan="2" class="classlisttitle">晚上</td>
  @endif
  <td class="classsubtitle">第{{ $t1 }}节<br>({{ $coursetime[$t1] }})</td>
  @foreach(['一', '二', '三', '四', '五', '六', '日'] as $y => $t2)
    <td class="arrangeweekcourse" style="padding: 0;">
      <button id="{{ $x.'-'.$y }}" tval="{{ '星期'.$t2.'第'.$t1.'节' }}" class="arrangeweekbtn" disabled="disabled" onclick="javascript:loadWeekEdt('{{ $x.'-'.$y }}');">{{ $coursetable['星期'.$t2.'第'.$t1.'节'] }}</button>
    </td>
  @endforeach
</tr>
@endforeach
</tbody>
</table>
<script type="text/javascript">
function arrangeWeekEdt()
{
	if($('#weekedt').text() == '取消')
	{
@if($user->grade != 2)
		$('#weekedt').text('编辑');
@else
		$('#weekedt').text('变更');
@endif
		$('.arrangeweekcourse').removeClass('arrangeweekcourseedt');
		$('.arrangeweekbtn').attr('disabled', 'disabled');
	}
	else
	{
		$('#weekedt').text('取消');
		$('.arrangeweekcourse').addClass('arrangeweekcourseedt');
@if($user->grade != 2)
		$('.arrangeweekbtn').removeAttr('disabled');
@else
		$('.arrangeweekbtn').each(function(){
			if($(this).text() != '')
			{
				$(this).removeAttr('disabled');
			}
		});
@endif
	}
}

function loadWeekEdt(id)
{
	var tbtn = $('#'+id);
	if($('#weekedt').text() == '取消')
	{
@if($user->grade == 1)
		//alert($('#'+id).text());
		$('#usercourseOptHeader').text(tbtn.attr('tval'));
		tbtn.attr( 'data-target', '#usercourseOptModal');
		tbtn.attr( 'data-toggle', 'modal');

		var result = tbtn.text().split(' ');
		$('#ucoursename').val(result[0]);

		$('#ucourseroom option').each(function(){
			if('('+$(this).text()+')' == result[1])
			{
				$(this).attr("selected", "selected");
			}
		});

		$('#ucourseremarks').val(result[2]);

@elseif($user->grade == 2)
		if(confirm('课程变更通知\n\n是否通知管理员请求更换课程安排？\n'))
		{
			$('#teacherChangeTitle').val($('#username').text()+' 请求变更『'+tbtn.attr('tval')+'』课程安排');
			tbtn.attr( 'data-target', '#teachercourseModal');
			tbtn.attr( 'data-toggle', 'modal');
		}
		else
		{
			tbtn.removeAttr('data-target');
			tbtn.removeAttr('data-toggle');
		}
@endif
	}
	else
	{
@if($user->grade == 1 || $user->grade == 2)
		tbtn.removeAttr('data-target');
		tbtn.removeAttr('data-toggle');
@endif
	}
}
</script>