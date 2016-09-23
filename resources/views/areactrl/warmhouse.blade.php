@section('content')
<!-- Info boxes -->
<div class="row">
@foreach($areaboxes as $areabox)
  @if($areabox->column == 4)
  <div class="col-md-3 col-sm-6 col-xs-12">
  @elseif($areabox->column == 3)
  <div class="col-md-4 col-sm-6 col-xs-12">
  @elseif($areabox->column == 2)
  <div class="col-md-6 col-sm-6 col-xs-12">
  @elseif($areabox->column == 1)
  <div class="col-md-12 col-sm-12 col-xs-12">
  @else
  <div class="col-md-4 col-sm-6 col-xs-12">
  @endif
    <div class="info-box">
      <span class="info-box-icon {{ $areabox->color_class }}"><i class="fa {{ $areabox->icon_class }}"></i></span>
      <div class="info-box-content">
        <span class="info-box-number">{{ $areabox->title }}</span>
        <p class="info-box-text">
        @foreach($areabox->contents as $index => $areaboxcontent)
          {{ $areaboxcontent->key }}{{ $areaboxcontent->key && $areaboxcontent->val?'：':''}}<span id="devspan{{ $areaboxcontent->id }}">{{ $areaboxcontent->val }}</span><br>
        @endforeach
        @while($index++ < 2)
          <br>
        @endwhile
        </p>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
@endforeach
</div>
<!-- /.row -->

<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <div class="col-md-8">
    <!-- TABLE: LATEST ORDERS -->
    <div class="box box-info">
      <div class="box-header with-border">
        <span class="box-title">控制设备</span>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="table-responsive">
          <table class="table no-margin">
            <thead>
              <tr>
                <th>#</th>
                <th>序列号</th>
                <th>名称</th>
                <th>状态</th>
                <th>操作</th>
                <th>时间</th>
              </tr>
            </thead>
            <tbody>
            @foreach($devices as $index => $device)
              <tr class="devtr">
                <td>{{ $index+1 }}</td>
                <td><a class="devsna" href="#">{{ $device->sn }}</a></td>
                <td><i class="{{ $device->rel_type->img }}"><span>&nbsp;&nbsp;{{ $device->name }}</span></td>
                <td>
                @if($device->data == null)
                  <span id="devsta{{ $device->sn }}" class="label label-danger">离线</span>
                @else
                  <span id="devsta{{ $device->sn }}" class="label label-success">{{ $device->data }}</span>
                @endif
                </td>
                <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-xs btn-info" onClick="javascript:devCtrlPost(1, '{{ $device->sn }}');"><b>开</b></button>
                    <button type="button" class="btn btn-xs btn-default" onClick="javascript:devCtrlPost(0, '{{ $device->sn }}');"><b>关</b></button>
                  </div>
                </td>
                <td id="devat{{ $device->sn }}">{{ \App\Http\Controllers\ComputeController::getTimeFlag($device->updated_at) }}</td>
              </tr>
            @endforeach
            @while(++$index < $pagetag->getRow())
              <tr><td height="37"></td></tr>
            @endwhile
            </tbody>
          </table>
        </div>
        <!-- /.table-responsive -->
      </div>
      <!-- /.box-body -->
      <!-- box-footer -->
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
      <!-- /.box-footer -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->

  <div class="col-md-4">
    <!-- MAP & BOX PANE -->
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">视频</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body no-padding">
        <div class="pad">
          <div class="embed-responsive embed-responsive-4by3">
            <video class="embed-responsive-item" allowfullscreen controls loop>
  			  <source src="{{ '/video/'.$video_file }}" type="video/mp4">
			</video>
          </div>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
@endsection

@section('conscript')
<!-- Sparkline -->
<script src="/bower_components/AdminLTE/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/bower_components/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/bower_components/AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="/bower_components/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js"></script>

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
  if(devdata.attr == 1) {
    for (var item in devdata.areaboxcontent){
      $('#devspan'+item).text(devdata.areaboxcontent[item]);
    }
  }
  else if(devdata.attr == 2) {
    $('.devtr').each(function() {
      var devsn = $(this).find('.devsna').text();
      if(devsn == devdata.sn) {
        devstaSwitch(devsn, devdata.data, devdata.updated_at);
      }
    });
  }
});
</script>
@endsection

@extends('admin.dashboard')

