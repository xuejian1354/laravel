@section('courselist')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="nav-li active"><a href="javascript:void(0);">日期</a></li>
    <li role="presentation" class="nav-li"><a href="javascript:void(0);">教室</a></li>
    <li role="presentation" class="nav-li"><a href="javascript:void(0);">班级</a></li>
  </ul>
  <div class="table-responsive">
   <table class="table table-striped" style="min-width: 600px;">
      <thead>
       <tr>
          <th>#</th>
          <th>序列号</th>
          <th>课程</th>
          <th>教室</th>
          <th>时间</th>
          <th>周期</th>
          <th>学期</th>
          <th>教师</th>
          <th>更新时间</th>
          <th><input type="checkbox" class="coursecheckall"></th>
        </tr>
      </thead>
      <tbody id="coursetbody">
      @for($index=0; $index < count($courses); $index++)
        <tr class="coursecol">
          <td>{{ $index+1 }}</td>
          <td class="courseid hidden"><span>{{ $courses[$index]->id }}</span></td>
          <td class="coursesn"><span>{{ $courses[$index]->sn }}</span></td>
          <td class="course"><span>{{ $courses[$index]->course }}</span></td>
          <td class="courseroom"><span>{{ $courses[$index]->room }}</span></td>
          <td class="coursetime"><span>{{ $courses[$index]->time }}</span></td>
          <td class="coursecycle"><span>{{ $courses[$index]->cycle }}</span></td>
          <td class="courseterm"><span>{{ $courses[$index]->term }}</span></td>
          <td class="courseteacher"><span>{{ $courses[$index]->teacher }}</span></td>
          <td>{{ $courses[$index]->updated_at }}</td>
          <td class="courseedtcheck"><input type="checkbox" class="coursecheck"></td>
        </tr>
      @endfor
      </tbody>
    </table>
  </div>
  <div class="nav navbar-nav navbar-right courseedt hidden">
    <a href="javascript:courseEdtAlert('{{ csrf_token() }}');" class="btn btn-primary" role="button">修改</a>
    <a href="javascript:courseDelAlert('{{ csrf_token() }}');" class="btn btn-danger" role="button">删除</a>
  </div>
  <div class="hidden">
    <span id="roomxml">{{ $roomnamestr }}</span>
    <span id="cyclexml">{{ $cyclestr }}</span>
    <span id="termxml">{{ $termstr }}</span>
    <span id="teacherxml">{{ $teacherstr }}</span>
  </div>
</div>
@endsection