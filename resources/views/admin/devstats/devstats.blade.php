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
      @include('admin.devstats.gwasync')
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
      @include('admin.devstats.devasync')
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
