@section('courselist')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="nav-li active"><a href="javascript:void(0);">日期</a></li>
    <li role="presentation" class="nav-li"><a href="javascript:void(0);">教室</a></li>
    <li role="presentation" class="nav-li"><a href="javascript:void(0);">班级</a></li>
  </ul>
  <div class="table-responsive">
   <table class="table table-striped table-gw" style="min-width: 600px;">
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
          <th></th>
        </tr>
      </thead>
      <tbody id="coursetbody">
      @for($index=0; $index < count($courses); $index++)
        <tr>
          <td>{{ $index+1 }}</td>
          <td>{{ $courses[$index]->sn }}</td>
          <td>{{ $courses[$index]->course }}</td>
          <td>{{ $courses[$index]->room }}</td>
          <td>{{ $courses[$index]->time }}</td>
          <td>{{ $courses[$index]->cycle }}</td>
          <td>{{ $courses[$index]->term }}</td>
          <td>{{ $courses[$index]->teacher }}</td>
          <td>{{ $courses[$index]->updated_at }}</td>
        </tr>
      @endfor
      </tbody>
    </table>
  </div>
</div>
@endsection