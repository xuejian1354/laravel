@section('content')
<section class="content">
  <div class="callout callout-info">
    <h4>功能提示！</h4>
    <p>此处用于添加已有的摄像头到{{ $area->name }}！</p>
  </div>
  <div class="box">
    <div class="box-header with-border"><h3 class="box-title"></h3></div>
    <div class="box-body table-responsive">
    <table class="table table-bordered">
      <tr>
        <td class="pull-right">位置</td>
        <td>{{ $area->name }}</td>
      </tr>
      <tr>
        <td class="pull-right">摄像头</td>
        <td>
          <select id="selcamera">
          @foreach($cameras as $camera)
            <option value="{{ $camera->sn }}">{{ $camera->name }}</option>
          @endforeach
          </select>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <button class="btn btn-success" onclick="javascript:addCameraToArea();" style="font-weight: bold;">添加</button>
          <button class="btn btn-default" onclick="window.location.href='{{ config('cullivebefore.mainrouter') }}/areactrl/{{ $area->sn }}';" style="margin-left: 10px;">返回</button>
        </td>
      </tr>
    </table>
    </div>
  </div>
</section>
@endsection

@section('conscript')
<script>
function addCameraToArea() {
  $.post("{{ config('cullivebefore.mainrouter') }}/areactrl/{{ $area->sn }}/camadd", { _token:'{{ csrf_token() }}', camerasn: $('#selcamera').val() },
    function(data, status) {
      if(status != 'success') {
	    alert("Status: " + status);
      }
      else if(data == 'OK') {
        alert('添加『 ' + $.trim($('#selcamera option:selected').text()) + ' 』到 "{{ $area->name }}" 成功！');
      }
      else {
        alert(data);
      }
  });
}
</script>
@endsection

@extends(config('cullivebefore.mainrouter').'.admin.dashboard')