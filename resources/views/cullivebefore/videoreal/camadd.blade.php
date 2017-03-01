@section('content')
<section class="content">
  <div class="callout callout-info">
    <h4>功能提示！</h4>
    <p>请在此处添加摄像头，设置名称、流信息等参数！</p>
  </div>
  <div class="box">
    <div class="box-header with-border"><h3 class="box-title">摄像头添加</h3></div>
    <div class="box-body table-responsive">
    <table class="table table-bordered">
      <tr>
        <td class="pull-right">名称(序列号)</td>
        <td><input id="devname" type="text"></td>
      </tr>
      <tr>
        <td class="pull-right">流类型</td>
        <td>
          <select id="devtype">
            <option value="rtsp">RTSP</option>
            <option value="rtmp">RTMP</option>
            <option value="hls">HLS</option>
          </select>
        </td>
      </tr>
      <tr>
        <td class="pull-right">URL 源</td>
        <td><input id="devurl" type="text" style="min-width: 300px;"></td>
      </tr>
      <tr>
        <td></td>
        <td>
          <button class="btn btn-success" onclick="javascript:addCameraToList();" style="font-weight: bold;">提交</button>
          <button class="btn btn-default" onclick="window.location.href='/videoreal';" style="margin-left: 10px;">返回</button>
        </td>
      </tr>
    </table>
    </div>
  </div>
</section>
@endsection

@section('conscript')
<script>
function addCameraToList() {
  var sname = $('#devname').val();
  var stype = $('#devtype').val();
  var surl = $('#devurl').val();

  if($.trim(sname).length == 0) {
    alert('名称(序列号) 不能为空');
    return;
  }

  if($.trim(surl).length == 0) {
    alert('URL 不能为空');
    return;
  }

  $.post('/videoreal/camadd', { _token:'{{ csrf_token() }}', sn: sname, type: stype, url: surl },
    function(data, status) {
      if(status != 'success') {
	    alert("Status: " + status);
      }
      else if(data == 'OK'){
    	$('#devname').val('');
    	$('#devurl').val('');

        alert('添加成功');
      }
  });
}
</script>
@endsection

@extends('admin.dashboard')