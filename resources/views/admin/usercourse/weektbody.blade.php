<a id='weekedt' href="javascript:arrangeWeekEdt();" style="float: right;">编辑</a>
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
    <td class="arrangeweekcourse" style="padding: 0;"><button id="{{ $x.'-'.$y }}" class="arrangeweekbtn" onclick="javascript:loadWeekEdt('{{ $x.'-'.$y }}');">{{ $coursetable['星期'.$t2.'第'.$t1.'节'] }}</button></td>
  @endforeach
</tr>
@endforeach
</tbody>
</table>