@section('roomimport')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  <br>
  <h3 class="page-header">1. Excel 导入</h3>
  <form action="{{url('/xls/roomlist')}}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <p><input type="file" name="xlsfile" accept=".xls,.xlsx,.csv"></p>
    <p><input type="submit"></p>
  </form>
  <br>
  <h3 class="page-header">2. 手动添加</h3>
  <div class="table-responsive">
   <table class="table table-striped" style="min-width: 600px;">
      <thead>
       <tr>
          <th>#</th>
          <th>名称</th>
          <th>类型</th>
          <th>地点</th>
          <th>使用情况</th>
          <th>使用者</th>
          <th>管理者</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td></td>
          <td><input id="raddname" type="text"></td>
          <td>
            <select id="raddtype">
            @foreach($roomtypes as $roomtype)
              <option>{{ $roomtype }}</option>
            @endforeach
            </select>
          </td>
          <td>
            <select id="raddaddr">
            @foreach($roomaddrs as $roomaddr)
              <option>{{ $roomaddr }}</option>
            @endforeach
            </select>
          </td>
          <td>
            <select id="raddstatus">
              <option>未使用(0)</option>
              <option>正使用(1)</option>
            </select>
          </td>
          <td>
            <select id="radduser">
            @foreach($users as $user)
              <option>{{ $user }}</option>
            @endforeach
            </select>
          </td>
          <td>
            <select id="raddowner">
            @foreach($owners as $owner)
              <option>{{ $owner }}</option>
            @endforeach
            </select>
          </td>
          <td><a href="javascript:roomAddAlert('{{ csrf_token() }}')" class="btn btn-info" role="button">添加</a></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
