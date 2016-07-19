<div class="table-responsive">
<a id='weekedt' href="javascript:arrangeWeekEdt();" style="float: right;">
@if($user->grade == 2)
  <span>变更</span>
@elseif($user->grade == 3)
  <span>选课</span>
@else
  <span>编辑</span>
@endif
</a>
<table class="table table-striped table-bordered" style="min-width: 739px;">
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
  <td rowspan="2" class="classlisttitle"  style="width: 20px; padding: 5px;">上午</td>
  @elseif($t1 == '5,6')
  <td rowspan="2" class="classlisttitle" style="padding: 5px;">下午</td>
  @elseif($t1 == '9,10,11')
  <td rowspan="2" class="classlisttitle" style="padding: 5px;">晚上</td>
  @endif
  <td class="classsubtitle" style="padding: 5px;">第{{ $t1 }}节<br>({{ $coursetime[$t1] }})</td>
  @foreach(['一', '二', '三', '四', '五', '六', '日'] as $y => $t2)
    <td class="arrangeweekcourse" style="padding: 5px;">
      <button id="{{ $x.'-'.$y }}" sn="{{ $coursetable['星期'.$t2.'第'.$t1.'节']->sn }}" tval="{{ '星期'.$t2.'第'.$t1.'节' }}" snums="{{ $coursetable['星期'.$t2.'第'.$t1.'节']->studentnums }}" class="arrangeweekbtn" disabled="disabled" onclick="javascript:loadWeekEdt('{{ $x.'-'.$y }}');" style="min-height: 40px;">{!! $coursetable['星期'.$t2.'第'.$t1.'节']->table !!}</button>
    </td>
  @endforeach
</tr>
@endforeach
</tbody>
</table>
</div>
<script type="text/javascript">
function arrangeWeekEdt()
{
	if($('#weekedt').text() == '取消')
	{
@if($user->grade == 2)
		$('#weekedt').text('变更');
@elseif($user->grade == 3)
	$('#weekedt').text('选课');
	$('#classchoose').addClass('hidden');
	$('#warningchoose').addClass('hidden');
	$('#classcourse').removeClass('hidden');
	$('.arrangeweekbtn').attr('disabled', 'disabled');
@else
	$('#weekedt').text('编辑');
	$('.arrangeweekbtn').attr('disabled', 'disabled');
@endif
		$('.arrangeweekcourse').removeClass('arrangeweekcourseedt');
	}
	else
	{
		$('#weekedt').text('取消');
		$('.arrangeweekcourse').addClass('arrangeweekcourseedt');
@if($user->grade == 2)
    	$('.arrangeweekbtn').each(function(){
    		if($(this).text() != '')
    		{
    			$(this).removeAttr('disabled');
    		}
    	});
@elseif($user->grade == 3)
        if('{{$coursechoose["choose"]}}' == '1'
        			&& getCurDate().localeCompare('{{$coursechoose["dateline"]}}') <= 0)
        {
        	if({{ count($selcourses) }} > 0)
        	{
            	$('#classchoose').removeClass('hidden');
            	$('#classcourse').addClass('hidden');
        		$('.arrangeweekbtn').removeAttr('disabled');
        	}
        	else
    		{
    			$('#weekedt').text('选课');
        		$('.arrangeweekcourse').removeClass('arrangeweekcourseedt');
                alert('暂无排课，无法进行选课');
    		}
        }
        else
        {
        	$('#weekedt').text('选课');
    		$('.arrangeweekcourse').removeClass('arrangeweekcourseedt');
            alert('非选课时段，无法进行选课');
        }
@else
		$('.arrangeweekbtn').removeAttr('disabled');
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

		var spos = result[0].lastIndexOf('-');
		if(spos > 0)
		{
			$('#ucoursename').val(result[0].substr(0, spos));
			$('#ucourseclass').val(result[0].substr(spos+1));
		}
		else
		{
			$('#ucoursename').val(result[0]);
			$('#ucourseclass').val('');
		}

		$('#ucourseroom option').each(function(){
			if('('+$(this).text()+')' == result[1])
			{
				$(this).attr("selected", "selected");
			}
		});

		$('#ucoursestudnums').val(tbtn.attr('snums'));

		var coursetimes = 0;
		if(result[2] != null)
		{
			coursetimes = result[2].replace(/[^0-9]/ig, '');
		}
		$('#ucoursenums').val(coursetimes);

@elseif($user->grade == 2)
		if('{{$coursechoose["choose"]}}' == '1'
			&& getCurDate().localeCompare('{{ $coursechoose["dateline"] }}') <= 0)
		{
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
		}
		else
		{
			alert('不在选课时间内，无法响应变更请求');
		}
@endif
	}
	else
	{
@if($user->grade == 1 || $user->grade == 2)
		tbtn.removeAttr('data-target');
		tbtn.removeAttr('data-toggle');
@endif
@if($user->grade == 2)
		$('#coursestudsinfo').removeClass('hidden');
		//$('#coursestudsinfo').text($('#'+id).text());
		loadContent('coursestudsinfo', '/admin?action=usercourse/coursestudsinfo&coursesn=' + tbtn.attr('sn'));
@endif
	}
}
</script>