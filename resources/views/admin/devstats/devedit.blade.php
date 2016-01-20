@section('devedit')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  <h2 class="sub-header">设备编辑</h2>
  @for($index=0; $index < count($devices); $index++)
    <table class="table table-striped">
      <thead>
        <tr>
          <th>{{ 'id='.$devices[$index]->id }}</th>
          <th>字段</th>
          <th>数值</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>名称</td>
          <td><input id="{{ 'devname'.$devices[$index]->id }}" type="text" value="{{ $devices[$index]->name }}"></td>
        </tr>
        <tr>
          <td>2</td>
          <td>序列号</td>
          <td>{{ $devices[$index]->dev_sn }}</td>
        </tr>
        <tr>
          <td>3</td>
          <td>类型</td>
          <td>{{ $devices[$index]->dev_type.'('.$devices[$index]->devtypename.')' }}</td>
        </tr>
        <tr>
          <td>3</td>
          <td>在线</td>
          <td>{{ $devices[$index]->znet_status }}</td>
        </tr>
        <tr>
          <td>3</td>
          <td>数据</td>
          <td>{{ $devices[$index]->dev_data }}</td>
        </tr>
        <tr>
          <td>3</td>
          <td>所属网关</td>
          <td>{{ $devices[$index]->gw_sn }}</td>
        </tr>
        <tr>
          <td>4</td>
          <td>区域位置</td>
          <td><input id="{{ 'devarea'.$devices[$index]->id }}" type="text" value="{{ $devices[$index]->area }}"></td>
        </tr>
        <tr>
          <td>5</td>
          <td>共享</td>
          <td>
            <select id="{{ 'devispublic'.$devices[$index]->id }}">
              <option
                @if($devices[$index]->ispublic == 0)
                  selected = "selected"
                @endif
              >0</option>
              <option
                @if($devices[$index]->ispublic == 1)
                  selected = "selected"
                @endif
              >1</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>6</td>
          <td>所有者</td>
          <td>
            <select id="{{ 'devowner'.$devices[$index]->id }}">
              @foreach($users as $user)
                <option
                  @if($devices[$index]->owner == $user->name)
                    selected = "selected"
                  @endif
                >{{ $user->name }}</option>
              @endforeach
            </select>
          </td>
        </tr>
        <tr>
          <td>7</td>
          <td>修改时间</td>
          <td>{{ $devices[$index]->updated_at }}</td>
        </tr>
      </tbody>
    </table>
  @endfor
  <div class="nav navbar-nav navbar-right">
    <a href="javascript:deviceEditAlert('{{ $devices[0]->id }}','{{ csrf_token() }}');" class="btn btn-info" role="button">执行</a>
  </div>
</div>
@endsection
