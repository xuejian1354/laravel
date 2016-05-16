@section('courseimport')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  <br>
  <h3 class="page-header">1. Excel 导入</h3>
  <form action="{{url('/xls/courselist')}}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <p><input type="file" name="xlsfile" accept=".xls,.xlsx,.csv"></p>
    <p><input type="submit"></p>
  </form>
  <br>
  <h3 class="page-header">2. 手动添加</h3>
  <div class="table-responsive">
   <table class="table table-striped">
      <thead>
       <tr>
          <th>#</th>
          <th>课程</th>
          <th>类型</th>
          <th>教室</th>
          <th>时间</th>
          <th>周期</th>
          <th>学期</th>
          <th>教师</th>
          <th>备注</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td></td>
          <td><input id="caddcourse" type="text" style="width: 100px;"></td>
          <td>
            <select id="caddtype" style="height: 26px;">
              <option>静态</option>
              <option>动态</option>
            </select>
          </td>
          <td>
            <select id="caddroom" style="height: 26px;">
            @foreach($roomnames as $roomname)
              <option>{{ $roomname }}</option>
            @endforeach
            </select>
          </td>
          <td><input id="caddtime" type="text"></td>
          <td>
            <select id="caddcycle" style="height: 26px;">
            @foreach($cycles as $cycle)
              <option>{{ $cycle }}</option>
            @endforeach
            </select>
          </td>
          <td>
            <select id="caddterm" style="height: 26px;">
            @foreach($terms as $term)
              <option>{{ $term }}</option>
            @endforeach
            </select>
          </td>
          <td>
            <select id="caddteacher" style="height: 26px;">
            @foreach($teachers as $teacher)
              <option>{{ $teacher }}</option>
            @endforeach
            </select>
          </td>
          <td><input id="caddremarks" type="text" style="width: 50px;"></td>
          <td><a href="javascript:courseAddAlert('{{ csrf_token() }}')" class="btn btn-info" role="button">添加</a></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<!-- script type="text/javascript" src="{{ asset('/js/laydate.js') }}"></script>
<script type="text/javascript">
        laydate({
            elem: '#caddtime',
            format: 'YYYY年MM月DD日( hh:mm )',
            istime: true,
            istoday: false,
        });
</script-->
@endsection
