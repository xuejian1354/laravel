@section('gwedit')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  <h2 class="sub-header">网关编辑</h2>
  @for($index=0; $index < count($gateways); $index++)
    <table class="table table-striped">
      <thead>
        <tr>
          <th>{{ 'id='.$gateways[$index]->id }}</th>
          <th>字段</th>
          <th>数值</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>名称</td>
          <td><input id="{{ 'gwname'.$gateways[$index]->id }}" type="text" value="{{ $gateways[$index]->name }}"></td>
        </tr>
        <tr>
          <td>2</td>
          <td>序列号</td>
          <td>{{ $gateways[$index]->gw_sn }}</td>
        </tr>
        <tr>
          <td>3</td>
          <td>协议</td>
          <td>{{ $gateways[$index]->transtocol }}</td>
        </tr>
        <tr>
          <td>4</td>
          <td>区域位置</td>
          <td>
            <!--input id="{{ 'gwarea'.$gateways[$index]->id }}" type="text" value="{{ $gateways[$index]->area }}"-->
            <select id="{{ 'gwarea'.$gateways[$index]->id }}">
              @foreach($areas as $area)
                <option
                  @if($gateways[$index]->area == $area->name)
                    selected = "selected"
                  @endif
                >{{ $area->name }}</option>
              @endforeach
            </select>
          </td>
        </tr>
        <tr>
          <td>5</td>
          <td>共享</td>
          <td>
            <select id="{{ 'gwispublic'.$gateways[$index]->id }}">
              <option
                @if($gateways[$index]->ispublic == 0)
                  selected = "selected"
                @endif
              >0</option>
              <option
                @if($gateways[$index]->ispublic == 1)
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
            <select id="{{ 'gwowner'.$gateways[$index]->id }}">
              @foreach($users as $user)
                <option
                  @if($gateways[$index]->owner == $user->name)
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
          <td>{{ $gateways[$index]->updated_at }}</td>
        </tr>
      </tbody>
    </table>
  @endfor
  <div class="nav navbar-nav navbar-right">
    <a href="javascript:gatewayEditAlert('{{ $gateways[0]->id }}','{{ csrf_token() }}');" class="btn btn-info" role="button">执行</a>
  </div>
</div>
@endsection
