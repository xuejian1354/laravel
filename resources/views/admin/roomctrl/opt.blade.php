@section('opt')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  <br>
  <h3 class="sub-header">{{ $room->name.' ('.$room->sn.')' }}</h3>
  <div class="table-responsive">
    <table class="table table-striped table-dev" style="min-width: 1050px;">
      <thead>
       <tr>
          <th>#</th>
          <th>名称</th>
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
	  @for($index=0; $index < count($devices); $index++)
	    <tr>
	      <td>{{ $index+1 }}</td>
	      <td>{{ $devices[$index]->name }}</td>
	      <td>{{ $devices[$index]->dev_sn }}</td>
	      <td>{{ $devices[$index]->dev_type }}</td>
	      <td>{{ $devices[$index]->znet_status }}</td>
	      <td>{{ $devices[$index]->dev_data }}</td>
	      <td><a href="{{ url('/admin?action=devstats') }}" style="color: #333;">{{ $devices[$index]->gw_sn }}</a></td>
	      <td>{{ $devices[$index]->ispublic }}</td>
	      <td>{{ $devices[$index]->owner }}</td>
	      <td>{{ $devices[$index]->updated_at }}</td>
	      <td style="min-width: 160px;">
	        <button onclick="javascript:deviceOptDialog('{{ $devices[$index]->name }}', '{{ $devices[$index]->gw_sn }}', '{{ $devices[$index]->dev_sn }}', '{{ $devices[$index]->dev_type }}', '{{ $devices[$index]->iscmdfound }}');" type="button" class="btn btn-info" role="button" data-target="#devOptModal" data-toggle="modal">操作</button>
	        <button onclick="location='{{ url('/admin?action=devstats/devedit&id='.$devices[$index]->id).'&roomsn='.$room->sn }}'" type="button" class="btn btn-primary" role="button">修改</button>
	        <button onclick="javascript:deviceRemoveAreaAlert('{{ $devices[$index]->id }}', '{{ $devices[$index]->dev_sn }}', '{{ $room->sn }}', '{{ csrf_token() }}');" type="button" class="btn btn-danger" role="button">移除</button>
	      </td>
	    </tr>
	  @endfor
	</tbody>
    </table>
  </div>
  <div id="devopt">
    @include('admin.devstats.devopt')
  </div>
  <div id="devoptadd">
    @include('admin.devstats.devoptadd')
  </div>
</div>
<script type="text/javascript">
  self.setInterval("refreshDevTab()",3428)

  function refreshDevTab()
  {
	  var xmlhttp;

	  if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	  }
	  else
	  {// code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }

	  xmlhttp.onreadystatechange=function()
	  {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	      document.getElementById('devtbody').innerHTML=xmlhttp.responseText;
	    }
	  }

	  xmlhttp.open("GET", "/admin?action=devstats/async&tabpos=1&area={{ $room->name }}", true);
	  xmlhttp.send();
  }
</script>
@endsection
