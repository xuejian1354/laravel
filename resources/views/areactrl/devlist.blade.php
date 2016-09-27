<div id="devlist">
  <div class="box box-info">
    <div class="box-header with-border"><span class="box-title">控制设备</span></div>
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
            <td>{{ ($pagetag->getPage()-1)*$pagetag->getRow()+$index+1 }}</td>
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