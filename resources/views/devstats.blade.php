@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="box box-info">
      <div class="box-header with-border"><h3 class="box-title">设备</h3></div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table no-margin">
            <thead>
            <tr>
              <th>#</th>
              <th>序列号</th>
              <th>名称</th>
              <th>位置</th>
              <th>状态/值</th>
              <th><center>操作</center></th>
              <th>时间</th>
            </tr>
            </thead>
            <tbody>
            @foreach($devices as $index => $device)
            <tr class="devtr">
              <td>{{ ($pagetag->getPage()-1)*$pagetag->getRow()+$index+1 }}</td>
              <td><a class="devsna" href="#">{{ $device->sn }}</a></td>
              <td><i class="{{ $device->rel_type->img }}"><span>&nbsp;&nbsp;{{ $device->name }}</span></td>
              <td>{{ $device->rel_area->name }}</td>
              <td>
              @if($device->data == null)
                <span id="devsta{{ $device->sn }}" class="label label-danger">离线</span>
              @else
                <span id="devsta{{ $device->sn }}" class="label label-success">{{ $device->data }}</span>
              @endif
              </td>
              @if($device->attr == 2)
              <td><center>
                <div class="btn-group">
                  <button type="button" class="btn btn-xs btn-info" onClick="javascript:devCtrlPost(1, '{{ $device->sn }}');"><b>开</b></button>
                  <button type="button" class="btn btn-xs btn-default" onClick="javascript:devCtrlPost(0, '{{ $device->sn }}');"><b>关</b></button>
                </div>
              </center></td>
              @else
              <td height="40"><center>---</center></td>
              @endif
              <td id="devat{{ $device->sn }}">{{ \App\Http\Controllers\ComputeController::getTimeFlag($device->updated_at) }}</td>
            </tr>
            @endforeach
            @while(++$index < $pagetag->getRow())
            <tr><td height="40"></td></tr>
            @endwhile
            </tbody>
          </table>
        </div>
      </div>
      <div class="box-footer clearfix">
      @if($pagetag->isavaliable())
        <ul class="pagination pagination-sm no-margin">
        @if($pagetag->start == 1)
          <li class="hidden disabled">
        @else
          <li>
        @endif
            <a href="{{ '/'.$request->path().'?page='.($pagetag->start-1) }}" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
          </li>
        @for($index=$pagetag->start; $index < $pagetag->end; $index++)
          @if($pagetag->getPage() == $index)
          <li class="active">
          @else
          <li>
          @endif
            <a href="{{ '/'.$request->path().'?page='.$index }}">{{ $index }}</a>
          </li>
        @endfor
        @if($pagetag->end == $pagetag->getPageSize() + 1)
          <li class="hidden disabled">
        @else
          <li>
        @endif
            <a href="{{ '/'.$request->path().'?page='.$pagetag->end }}" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
          </li>
        </ul>
      @endif
      </div>
    </div>
    <div class="box box-default">
      <div class="box-header with-border">
        <i class="fa fa-h-square"></i>
        <h3 class="box-title">智能贴士</h3>
      </div>
      <div class="box-body">
        <div class="alert alert-info alert-dismissible">
          <h4><i class="icon fa fa-info"></i> 设备统计</h4>
          <span>共用 {{ $pagetag->getAllcols() }} 个设备，其中 监测类 {{ App\Device::where('attr', 1)->count() }}，控制类 {{ App\Device::where('attr', 2)->count() }}</span>
        </div>
        <div class="alert alert-warning alert-dismissible">
          <h4><i class="icon fa fa-warning"></i> 状态警告</h4>
          <span>有 {{ App\Device::where('attr', '!=', 3)->where('data', null)->count() }} 个设备处于无数据状态</span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="box box-widget">
      <div class="box-header with-border"><h3 class="box-title">设备导航</h3></div>
      <div class="box-body" style="display: block;">
        <img class="img-responsive pad" src="/bower_components/AdminLTE/dist/img/photo2.png" alt="Photo">
        <p>I took this photo this morning. What do you guys think?</p>
      </div>
    </div>
  </div>
</div>
@endsection

@section('conscript')
<script type="text/javascript">
function devstaSwitch(devsn, data, at) {
  if(data == '打开' || data == '关闭') {
    $('#devsta'+devsn).removeClass('label-danger');
    $('#devsta'+devsn).addClass('label-success');
    $('#devsta'+devsn).text(data);
    $('#devat'+devsn).text(at);
  }
  else {
	$('#devsta'+devsn).addClass('label-danger');
	$('#devsta'+devsn).removeClass('label-success');
	$('#devsta'+devsn).text('离线');
	}
}

function devstaChange(devsn, data, at) {
  if(data.length > 0) {
    $('#devsta'+devsn).removeClass('label-danger');
	$('#devsta'+devsn).addClass('label-success');
	$('#devsta'+devsn).text(data);
	$('#devat'+devsn).text(at);
  }
  else {
    $('#devsta'+devsn).addClass('label-danger');
    $('#devsta'+devsn).removeClass('label-success');
    $('#devsta'+devsn).text('离线');
  }
}

function devCtrlPost(sw, devsn) {
  $.post('/devctrl/'+devsn, { _token:'{{ csrf_token() }}', data:sw }, function(data, status) {
	  if(status != 'success') {
		alert("Status: " + status);
	  }
	  else {
		devstaSwitch(devsn, data[0], data[1]);
	  }
  });
}
</script>

<script src="//cdn.bootcss.com/pusher/3.0.0/pusher.min.js"></script>
<script>
var pusher = new Pusher("{{env('PUSHER_KEY')}}")
var channel = pusher.subscribe('devdata-updating');
channel.bind('update', function(devdata) {
    $('.devtr').each(function() {
      var devsn = $(this).find('.devsna').text();
      if(devsn == devdata.sn) {
    	if(devdata.attr == 1) {
    	  devstaChange(devsn, devdata.data, devdata.updated_at);
    	}
    	else if(devdata.attr == 2) {
          devstaSwitch(devsn, devdata.data, devdata.updated_at);
        }
      }
    });
});
</script>
@endsection

@extends('admin.dashboard')
