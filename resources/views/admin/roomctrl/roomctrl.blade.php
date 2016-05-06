@section('roomctrl')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
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
          <th>操作</th>
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
          <td><button onclick="location='{{ url('/admin?action=roomctrl/opt&roomsn='.$rooms[$index]->sn) }}'" class="btn btn-primary" role="button">进入</button></td>
        </tr>
        @elseif($pagetag->isavaliable())
        <tr style="height: 40px;"></tr>
        @endif
      @endfor
      </tbody>
    </table>
  </div>
  @if($pagetag->isavaliable())
  <nav>
    <ul class="pagination">
      @if($pagetag->start == 1)
      <li class="hidden disabled">
      @else
      <li>
      @endif
        <a href="admin?action=roomctrl&page={{ $pagetag->start-1 }}" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
      </li>
      @for($index=$pagetag->start; $index < $pagetag->end; $index++)
        @if($pagetag->getPage() == $index)
        <li class="active">
        @else
        <li>
        @endif
          <a href="admin?action=roomctrl&page={{ $index }}">{{ $index }}</a>
        </li>
      @endfor
      @if($pagetag->end == $pagetag->getPageSize() + 1)
      <li class="hidden disabled">
      @else
      <li>
      @endif
        <a href="admin?action=roomctrl&page={{ $pagetag->end }}" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
      </li>
    </ul>
  </nav>
  @endif
</div>
@endsection
