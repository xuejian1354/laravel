@section('edit')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  <h2 class="sub-header">用户编辑</h2>
  @foreach ($args as $arg)
    <table class="table table-striped">
      <thead>
        <tr>
          <th>{{ 'id='.$arg->id }}</th>
          <th>字段</th>
          <th>数值</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>用户名</td>
          <td><input id="{{ 'username'.$arg->id }}" type="text" value="{{ $arg->name }}"></td>
        </tr>
        <tr>
          <td>2</td>
          <td>邮箱</td>
          <td>{{ $arg->email }}</td>
        </tr>
        <tr>
          <td>3</td>
          <td>身份</td>
          <td>
            <select id="{{ 'usergrade'.$arg->id }}">
              @foreach($grades as $grade)
                <option
                @if($arg->grade == $grade->grade)
                  selected = "selected"
                @endif
                >{{ $grade->val }}</option>
              @endforeach
            </select>
          </td>
        </tr>
        <tr>
          <td>4</td>
          <td>权限</td>
          <td>
            <select id="{{ 'userprivilege'.$arg->id }}">
              @foreach($privileges as $privilege)
                <option
                  @if($arg->privilege == $privilege->privilege)
                    selected = "selected"
                  @endif
                >{{ $privilege->privilege.'('.$privilege->val.')' }}</option>
              @endforeach
            </select>
          </td>
        </tr>
        <tr>
          <td>5</td>
          <td>位置</td>
          <td>
            <select id="{{ 'userarea'.$arg->id }}">
              @foreach($areas as $area)
                <option
                  @if($arg->area == $area->name)
                    selected = "selected"
                  @endif
                >{{ $area->name }}</option>
              @endforeach
            </select>
          </td>
        </tr>
        <tr>
          <td>6</td>
          <td>修改时间</td>
          <td>{{ $arg->updated_at }}</td>
        </tr>
      </tbody>
    </table>
  @endforeach
  <div class="nav navbar-nav navbar-right">
    <a href="javascript:userEditAlert('{{ $args[0]->id }}','{{ csrf_token() }}');" class="btn btn-primary" role="button">执行</a>
    <a href="admin?action=usermanage&tabpos={{ $arg->grade-1 }}" class="btn btn-info" role="button">返回</a>
  </div>
</div>
@endsection
