<div id="devlist{{ $listid }}">
  <div class="box-body">
    <div class="table-responsive">
      <table class="table no-margin">
      <thead hidden>
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
      @for($index=0; $index < count($devices); $index++)
        <tr class="devtr">
          <td hidden>{{ ($pagetag->getPage()-1)*$pagetag->getRow()+$index+1 }}</td>
          <td hidden>
            @if(App\Globalval::getVal('record_support') == true && $devices[$index]->attr == 1)
            <a class="devsna" href="{{ '/areactrl/'.$area->sn.'/record?sn='.$devices[$index]->sn }}">{{ $devices[$index]->sn }}</a>
            @else
            <a class="devsna">{{ $devices[$index]->sn }}</a>
            @endif
          </td>
          <td hidden><i class="{{ $devices[$index]->rel_type->img }}"><span>&nbsp;&nbsp;{{ $devices[$index]->name }}</span></td>
          <td hidden>
          @if($devices[$index]->data == null)
            <span id="devsta{{ $devices[$index]->sn }}" class="label label-danger">离线</span>
          @else
            <span id="devsta{{ $devices[$index]->sn }}" class="label label-success">{{ $devices[$index]->data }}</span>
          @endif
          </td>
          @if($devices[$index]->attr == 2)
          <td><center>
          @for($i=0; $i<$devices[$index]->rel_devopt->channel; $i++)
            <button type="button" class="btn btn-warning devbtn{{ $i }}" onClick="javascript:devOptCtrl('{{ $devices[$index]->sn }}', '{{ $devices[$index]->psn }}', '{{ $devices[$index]->rel_devopt->method }}', '{{ $devices[$index]->rel_devopt->channel }}', '{{ $i }}', '{{ $devices[$index]->rel_devopt->data }}');" style="margin: 10px 14px;">{{ App\DevbtName::find($i)->content }}</button>
            @if($i%2==1)
            <br>
            @endif
          @endfor
          </center></td>
          @else
          <td height="40"><span id="selopt{{ $devices[$index]->sn }}">{{ \App\Http\Controllers\DeviceController::getDevValueBySN($devices[$index]->sn) }}</span></td>
          @endif
          <td hidden id="devat{{ $devices[$index]->sn }}">{{ \App\Http\Controllers\ComputeController::getTimeFlag($devices[$index]->updated_at) }}</td>
        </tr>
      @endfor
      @while($index++ < $pagetag->getRow())
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
        <a href="javascript:updateDevListPost('/{{ $request->path() }}', 'devlist{{ $listid }}', '{{ $pagetag->start-1 }}', '{{ csrf_token() }}')" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
      </li>
    @for($index=$pagetag->start; $index < $pagetag->end; $index++)
      @if($pagetag->getPage() == $index)
      <li class="active">
      @else
      <li>
      @endif
        <a href="javascript:updateDevListPost('/{{ $request->path() }}', 'devlist{{ $listid }}', '{{ $index }}', '{{ csrf_token() }}')">{{ $index }}</a>
      </li>
    @endfor
    @if($pagetag->end == $pagetag->getPageSize() + 1)
      <li class="hidden disabled">
    @else
      <li>
    @endif
        <a href="javascript:updateDevListPost('/{{ $request->path() }}', 'devlist{{ $listid }}', '{{ $pagetag->end }}', '{{ csrf_token() }}')" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
      </li>
    </ul>
  @else
    <div style="height: 35px;"></div>
  @endif
  </div>
</div>