<h3 style="margin-top: 50px;"><b>学生信息表</b></h3>
<table class="table table-striped table-bordered" style="max-width: 340px;">
<tbody>
<tr>
  <td><b>#</b>{{ count($studinfos) }}人</td>
  <th>学号</th>
  <th>姓名</th>
  <th>性别</th>
  <th>班级</th>
</tr>
@foreach($studinfos as $index => $studinfo)
<tr>
  <td>{{ $index+1 }}</td>
  <td>{{ $studinfo->num }}</td>
  <td>{{ $studinfo->name }}</td>
  <td>{{ $studinfo->sexuality }}</td>
  <td>{{ $studinfo->class }}</td>
</tr>
@endforeach
</tbody>
</table>