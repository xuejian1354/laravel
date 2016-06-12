<div class="table-responsive" style="max-width: 500px; margin-top: 25px;">
<div class="col-sm-6 col-md-6" style="padding: 0;">
  <h3><b>学生成绩表</b></h3>
</div>
<div class="col-sm-6 col-md-6" style="padding: 0; margin-top: 14px;">
  <a class="scoreedt" href="javascript:scoreEdtClick();" style="float: right;">修改</a>
  <a class="scorecommit hidden" href="javascript:changeScoreRequest();" style="float: right; margin-right: 5px;">提交</a>
</div>
<table class="table table-striped table-bordered">
<tbody>
<tr>
  <td><b>#</b>{{ count($studinfos) }}人</td>
  <th>学号</th>
  <th>用户</th>
  <th>姓名</th>
  <th>性别</th>
  <th>班级</th>
  <th><center>成绩</center></th>
</tr>
@foreach($studinfos as $index => $studinfo)
<tr class="trlist">
  <td>{{ $index+1 }}</td>
  <td class="studsn">{{ $studinfo->num }}</td>
  <td>{{ $studinfo->user }}</td>
  <td>{{ $studinfo->name }}</td>
  <td style="text-align: center;">{{ $studinfo->sexuality }}</td>
  <td>{{ $studinfo->class }}</td>
  <td class="scoreval" style="padding: 0, 8px; width: 62px; text-align:center;">{{ $studinfo->score }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>