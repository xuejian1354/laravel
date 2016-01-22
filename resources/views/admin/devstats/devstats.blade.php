@section('devstats')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="nav-li nav-li-gw active"><a href="javascript:loadDeviceContent(0);">网关</a></li>
    <li role="presentation" class="nav-li nav-li-dev"><a href="javascript:loadDeviceContent(1);">设备</a></li>
  </ul>
  <div class="table-responsive">
   <table class="table table-striped table-gw" style="min-width: 728px;">
      <thead>
       <tr>
          <th>#</th>
          <th>名称</th>
          <th>序列号</th>
          <th>协议</th>
          <th>区域位置</th>
          <th>共享</th>
          <th>所有者</th>
          <th>修改时间</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="gwtbody">
        @for($index=0; $index < count($gateways); $index++)
          <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $gateways[$index]->name }}</td>
            <td>{{ $gateways[$index]->gw_sn }}</td>
            <td>{{ $gateways[$index]->transtocol }}</td>
            <td>{{ $gateways[$index]->area }}</td>
            <td>{{ $gateways[$index]->ispublic }}</td>
            <td>{{ $gateways[$index]->owner }}</td>
            <td>{{ $gateways[$index]->updated_at }}</td>
            <td>
              <a href="{{ url('/admin?action=devstats/gwedit&id='.$gateways[$index]->id) }}" class="btn btn-primary" role="button">修改</a>
              <a href="javascript:gatewayDelAlert('{{ $gateways[$index]->id }}', '{{ $gateways[$index]->gw_sn }}', '0', '{{ csrf_token() }}');" class="btn btn-danger" role="button">删除</a>
            </td>
          </tr>
        @endfor
      </tbody>
    </table>
    <table class="table table-striped table-dev hidden" style="min-width: 1050px;">
      <thead>
       <tr>
          <th>#</th>
          <th>名称</th>
          <th>序列号</th>
          <th>类型</th>
          <th>在线</th>
          <th>数据</th>
          <th>所属网关</th>
          <th>区域位置</th>
          <th>共享</th>
          <th>所有者</th>
          <th>修改时间</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="devtbody">
        @for($index=0; $index < count($devices); $index++)
          <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $devices[$index]->name }}</td>
            <td>{{ $devices[$index]->dev_sn }}</td>
            <td>{{ $devices[$index]->dev_type }}</td>
            <td>{{ $devices[$index]->znet_status }}</td>
            <td>{{ $devices[$index]->dev_data }}</td>
            <td>{{ $devices[$index]->gw_sn }}</td>
            <td>{{ $devices[$index]->area }}</td>
            <td>{{ $devices[$index]->ispublic }}</td>
            <td>{{ $devices[$index]->owner }}</td>
            <td>{{ $devices[$index]->updated_at }}</td>
            <td>
              <a href="javascript:void(0);" class="btn btn-info" role="button">操作</a>
              <a href="{{ url('/admin?action=devstats/devedit&id='.$devices[$index]->id) }}" class="btn btn-primary" role="button">修改</a>
              <a href="javascript:deviceDelAlert('{{ $devices[$index]->id }}', '{{ $devices[$index]->dev_sn }}', '1', '{{ csrf_token() }}');" class="btn btn-danger" role="button">删除</a>
            </td>
          </tr>
        @endfor
      </tbody>
    </table>
  </div>
</div>
<script type="text/javascript">
  loadDeviceTab({{ isset($_GET['tabpos'])&&$_GET['tabpos']<2?$_GET['tabpos']:'0' }});

  self.setInterval("refreshDevTab()",5137)
  self.setInterval("refreshGWTab()",10371)

  function refreshDevTab()
  {
	  loadDeviceContent(1);
  }

  function refreshGWTab()
  {
	  loadDeviceContent(0);
  }
</script>
@endsection
