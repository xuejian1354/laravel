@section('roomstats')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  <div class="table-responsive">
   <table class="table table-striped table-gw" style="min-width: 600px;">
      <thead>
       <tr>
          <th>#</th>
          <th>序列号</th>
          <th>名称</th>
          <th>类型</th>
          <th>地点</th>
          <th>使用情况</th>
          <th>使用者</th>
          <th>管理者</th>
          <th>更新时间</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="roomtbody">
      @for($index=0; $index < count($rooms); $index++)
        <tr>
          <td>{{ $index+1 }}</td>
          <td>{{ $rooms[$index]->sn }}</td>
          <td>{{ $rooms[$index]->name }}</td>
          <td>{{ $rooms[$index]->roomtypestr }}</td>
          <td>{{ $rooms[$index]->addrstr }}</td>
          <td>{{ $rooms[$index]->statusstr }}</td>
          <td>{{ $rooms[$index]->user }}</td>
          <td>{{ $rooms[$index]->owner }}</td>
          <td>{{ $rooms[$index]->updated_at }}</td>
        </tr>
      @endfor
      </tbody>
    </table>
  </div>
</div>
@endsection
