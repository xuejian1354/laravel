@section('usermanage')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  <ul class="nav nav-tabs" role="tablist">
    @foreach($grades as $grade)
      <li role="presentation" class="nav-li nav-li{{ $grade->grade }}"><a href="javascript:loadUserGrade({{ $grade->grade }});">{{ $grade->val }}</a></li>
    @endforeach
  </ul>
  <div class="table-responsive">
   <table class="table table-striped" style="min-width: 602px;">
      <thead>
       <tr>
          <th>#</th>
          <th>用户名</th>
          <th>邮箱</th>
          <th>身份</th>
          <th>权限</th>
          <th>修改时间</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($args as $arg)
          <tr class="targ targlist{{$arg->grade}} hidden"
            @if($arg->index % 2 == 0)
              style="background-color: #ffffff;"
            @else
              style="background-color: #f9f9f9;"
            @endif
          >
            <td>{{ $arg->index }}</td>
            <td>{{ $arg->name }}</td>
            <td>{{ $arg->email }}</td>
            <td>{{ $arg->gradename }}</td>
            <td>{{ $arg->privilege }}</td>
            <td>{{ $arg->updated_at }}</td>
            <td>
              <a href="{{ url('/admin?action=usermanage/edit&id='.$arg->id) }}"
                @if(Auth::user()->privilege < 5)
                  class="btn btn-primary disabled"
                @else
                  class="btn btn-primary"
                @endif
                  role="button">修改</a>
              <a href="javascript:userDelAlert('{{ $arg->id }}','{{ Auth::user()->id }}','{{ $arg->grade-1 }}','{{ csrf_token() }}');"
                @if(Auth::user()->name == $arg->name || Auth::user()->privilege < 5)
                  class="btn btn-danger disabled"
                @else
                  class="btn btn-danger"
                @endif
                role="button">删除</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<script type="text/javascript">
  loadUserGrade({{ $grades[isset($_GET['tabpos'])&&$_GET['tabpos']<4?$_GET['tabpos']:'0']->grade }});
</script>
@endsection
