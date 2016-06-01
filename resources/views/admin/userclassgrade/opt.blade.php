<div class="table-responsive">
  <table class="table table-striped table-dev" style="min-width: 906px;">
    <thead>
      <tr>
        <th>#</th>
        <th>设备</th>
        <th>序列号</th>
        <th>类型</th>
        <th>在线</th>
        <th>数据</th>
        <th>所属网关</th>
        <th>共享</th>
        <th>所有者</th>
        <th>修改时间</th>
        <th></th>
      </tr>
    </thead>
    <tbody id="devtbody">
	@foreach($devices as $index => $device)
	  <tr>
	    <td>{{ $index+1 }}</td>
	    <td>{{ $device->name }}</td>
	    <td>{{ $device->dev_sn }}</td>
	    <td>{{ $device->dev_type }}</td>
	    <td>{{ $device->znet_status }}</td>
	    <td>{{ $device->dev_data }}</td>
	    <td><a href="{{ url('/admin?action=devstats') }}" style="color: #333;">{{ $device->gw_sn }}</a></td>
	    <td>{{ $device->ispublic }}</td>
	    <td>{{ $device->owner }}</td>
	    <td>{{ $device->updated_at }}</td>
	    <td>
	      <button onclick="javascript:deviceOptDialog('{{ $device->name }}', '{{ $device->gw_sn }}', '{{ $device->dev_sn }}', '{{ $device->dev_type }}', '{{ $device->iscmdfound }}');" type="button" class="btn btn-info" role="button" data-target="#devOptModal" data-toggle="modal">操作</button>
	    </td>
	  </tr>
	@endforeach
	</tbody>
  </table>
</div>
<div id="devopt">
  @include('admin.devstats.devopt')
</div>
<div id="devoptadd">
  @include('admin.devstats.devoptadd')
</div>
