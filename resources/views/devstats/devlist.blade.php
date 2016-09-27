<div id= "devlist">
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
          <a href="javascript:updateDevListPost('devlist', '{{ $pagetag->start-1 }}')" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
        </li>
      @for($index=$pagetag->start; $index < $pagetag->end; $index++)
        @if($pagetag->getPage() == $index)
        <li class="active">
        @else
        <li>
        @endif
          <a href="javascript:updateDevListPost('devlist', '{{ $index }}')">{{ $index }}</a>
        </li>
      @endfor
      @if($pagetag->end == $pagetag->getPageSize() + 1)
        <li class="hidden disabled">
      @else
        <li>
      @endif
          <a href="javascript:updateDevListPost('devlist', '{{ $pagetag->end }}')" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
        </li>
      </ul>
    @endif
    </div>
  </div>
</div>