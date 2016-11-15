<div id="devlist">
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
            @include('devopt')
          </td>
          <td id="devat{{ $device->sn }}">{{ \App\Http\Controllers\ComputeController::getTimeFlag($device->updated_at) }}</td>
        </tr>
      @endforeach
      @if(isset($index))
      @while(++$index < $pagetag->getRow())
        <tr><td height="40"></td></tr>
      @endwhile
      @endif
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
        <a href="javascript:updateDevListPost('{{ $request->path() }}', 'devlist', '{{ $pagetag->start-1 }}', '{{ csrf_token() }}')" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
      </li>
    @for($index=$pagetag->start; $index < $pagetag->end; $index++)
      @if($pagetag->getPage() == $index)
      <li class="active">
      @else
      <li>
      @endif
        <a href="javascript:updateDevListPost('{{ $request->path() }}', 'devlist', '{{ $index }}', '{{ csrf_token() }}')">{{ $index }}</a>
      </li>
    @endfor
    @if($pagetag->end == $pagetag->getPageSize() + 1)
      <li class="hidden disabled">
    @else
      <li>
    @endif
        <a href="javascript:updateDevListPost('{{ $request->path() }}', 'devlist', '{{ $pagetag->end }}', '{{ csrf_token() }}')" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
      </li>
    </ul>
  @endif
  </div>
</div>