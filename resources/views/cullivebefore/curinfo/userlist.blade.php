<div id="userlist">
  <div class="box">
    <div class="box-header with-border"><h3 class="box-title">用户列表</h3></div>
      <div class="box-body">
      <table class="table table-bordered">
        <tr>
          <th style="width: 10px">#</th>
          <th>序列号</th>
          <th>名称</th>
          <th>邮箱</th>
          <th>状态</th>
          <th>活跃率</th>
          <th style="width: 40px"></th>
        </tr>
        @foreach($users as $index => $user)
        <tr>
          <td><input class="licheck" type="checkbox"></td>
          <td class="usersn">{{ $user->sn }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          @if($user->active == true)
          <td id='tdact{{ $user->sn }}'>可用</td>
          @else
          <td id='tdact{{ $user->sn }}'><a href="javascript:activeForUser('{{ $user->sn }}')">激活</a></td>
          @endif
          <td>
            <div class="progress progress-xs">
              <div class="progress-bar progress-bar-danger" style="width: {{ $user->actcount }}%"></div>
            </div>
          </td>
          <td><span class="badge bg-green">{{ $user->actcount }}%</span></td>
        </tr>
        @endforeach
        @while(++$index < $pagetag->getRow())
        <tr><td height="39"></td></tr>
        @endwhile
      </table>
      </div>
    <div class="box-footer clearfix">
      <div class="mailbox-controls col-md-6">
        <button onclick="javascript:licheckAll()" type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
        <div class="btn-group">
          <a href="javascript:delChoiceUser()" type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></a>
          <a href="{{ config('cullivebefore.mainrouter') }}/{{ $request->path() }}?page={{ $pagetag->getPage() }}" type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></a>
        </div>
      </div>
      <div class="col-md-6">
    @if($pagetag->isavaliable())
      <ul class="pagination pagination-sm no-margin pull-right">
      @if($pagetag->start == 1)
        <li class="hidden disabled">
      @else
        <li>
      @endif
          <a href="javascript:updateUserListPost('userlist', '{{ $pagetag->start-1 }}')" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
        </li>
      @for($index=$pagetag->start; $index < $pagetag->end; $index++)
        @if($pagetag->getPage() == $index)
        <li class="active">
        @else
        <li>
        @endif
          <a href="javascript:updateUserListPost('userlist', '{{ $index }}')">{{ $index }}</a>
        </li>
      @endfor
      @if($pagetag->end == $pagetag->getPageSize() + 1)
        <li class="hidden disabled">
      @else
        <li>
      @endif
          <a href="javascript:updateUserListPost('userlist', '{{ $pagetag->end }}')" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
        </li>
      </ul>
    @endif
    </div>
    </div>
  </div>
</div>