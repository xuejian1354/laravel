<div>
  <div class="table-responsive">
   <table class="table table-striped" style="min-width: 600px;">
      <thead>
       <tr>
          <th>#</th>
          <th>序列号</th>
          <th>名称</th>
          <th>类型</th>
          <th>地点</th>
          <th>使用情况</th>
          <th>使用者</th>
          <th>管理者</th>
          <th>更新时间</th>
          <th><input type="checkbox" class="roomcheckall"></th>
        </tr>
      </thead>
      <tbody id="roomtbody">
      @for($index=0; $index < $pagetag->getRow(); $index++)
        @if($index < count($rooms))
        <tr class="roomcol">
          <td><span>{{ $index+1 }}</span></td>
          <td class="roomid hidden"><span>{{ $rooms[$index]->id }}</span></td>
          <td class="roomsn"><span>{{ $rooms[$index]->sn }}</span></td>
          <td class="roomname"><span>{{ $rooms[$index]->name }}</span></td>
          <td class="roomtype"><span>{{ $rooms[$index]->roomtypestr }}</span></td>
          <td class="roomaddr"><span>{{ $rooms[$index]->addrstr }}</span></td>
          <td class="roomstatus"><span>{{ $rooms[$index]->statusstr }}</span></td>
          <td class="roomuser"><span>{{ $rooms[$index]->user }}</span></td>
          <td class="roomadmin"><span>{{ $rooms[$index]->owner }}</span></td>
          <td><span>{{ $rooms[$index]->updated_at }}</span></td>
          <td class="roomedtcheck"><input type="checkbox" class="roomcheck"></td>
        </tr>
        @elseif($pagetag->isavaliable())
        <tr style="height: 39px;"></tr>
        @endif
      @endfor
      </tbody>
    </table>
  </div>
  <div class="nav navbar-nav navbar-right">
    <a href="javascript:roomEditAlert('{{ csrf_token() }}');" class="btn btn-primary roomEdtBtn hidden" role="button">修改</a>
    <a href="javascript:roomDelAlert('{{ csrf_token() }}');" class="btn btn-danger roomEdtBtn hidden" role="button">删除</a>
  </div>
  <div class="hidden">
    <span id="typexml">{{ $roomtypestr }}</span>
    <span id="addrxml">{{ $roomaddrstr }}</span>
    <span id="userxml">{{ $userstr }}</span>
    <span id="ownerxml">{{ $ownerstr }}</span>
  </div>
  @if($pagetag->isavaliable())
  <nav>
    <ul class="pagination">
      @if($pagetag->start == 1)
      <li class="hidden disabled">
      @else
      <li>
      @endif
        <a href="/admin?action=roomstats&page={{ $pagetag->start-1 }}" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
      </li>
      @for($index=$pagetag->start; $index < $pagetag->end; $index++)
        @if($pagetag->getPage() == $index)
        <li class="active">
        @else
        <li>
        @endif
          <a href="/admin?action=roomstats&page={{ $index }}">{{ $index }}</a>
        </li>
      @endfor
      @if($pagetag->end == $pagetag->getPageSize() + 1)
      <li class="hidden disabled">
      @else
      <li>
      @endif
        <a href="/admin?action=roomstats&page={{ $pagetag->end }}" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
      </li>
    </ul>
  </nav>
  @endif
</div>
