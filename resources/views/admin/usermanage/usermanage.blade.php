<div>
  <ul class="nav nav-tabs" role="tablist">
    @foreach($grades as $grade)
      <li role="presentation" class="nav-li nav-li{{ $grade->grade }}"><a href="javascript:loadUserGrade({{ $grade->grade }});">{{ $grade->val }}</a></li>
    @endforeach
  </ul>
  <div class="table-responsive">
   <table class="table table-striped" style="min-width: 602px;">
      <thead>
       <tr>
          <th>#</th>
          <th>用户名</th>
          <th>邮箱</th>
          <th>身份</th>
          <th>权限</th>
          <th>位置</th>
          <th>修改时间</th>
          <th>功能</th>
          <th>编辑</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($args as $arg)
          <tr class="targ targlist{{$arg->grade}} hidden"
            @if($arg->index % 2 == 0)
              style="background-color: #ffffff;"
            @else
              style="background-color: #f9f9f9;"
            @endif
          >
            <td>{{ $arg->index }}</td>
            <td>{{ $arg->name }}</td>
            <td>{{ $arg->email }}</td>
            <td>{{ $arg->gradename }}</td>
            <td>{{ $arg->privilege }}</td>
            <td>{{ $arg->area }}</td>
            <td>{{ $arg->updated_at }}</td>
            <td>
              <a href="{{ url('/admin?action=userfunc&id='.$arg->id.'&adminmenus=1') }}" class="btn btn-sm btn-primary">操作</a>
            </td>
            <td>
              <a href="{{ url('/admin?action=usermanage/edit&tabpos='.Input::get('tabpos').'&page='.Input::get('page').'&id='.$arg->id) }}"
                @if(Auth::user()->privilege < 5)
                  class="hidden"
                @endif
                >修改</a>
              <a href="javascript:userDelAlert('{{ $arg->id }}','{{ Auth::user()->id }}','{{ $arg->grade-1 }}','{{ csrf_token() }}');"
                @if(Auth::user()->name == $arg->name || Auth::user()->privilege < 5)
                  class="hidden"
                @endif
                >删除</button>
            </td>
          </tr>
        @endforeach
        @for($i=0; $i < count($pagetags); $i++)
          @if($pagetags[$i]->getRow() > $pagetags[$i]->getListNum())
            @for($index=0; $index < $pagetags[$i]->getRow() - $pagetags[$i]->getListNum(); $index++)
              <tr class="targ targlist{{ $i+1 }} hidden" style="height: 40px;"></tr>
            @endfor
          @endif
        @endfor
      </tbody>
    </table>
  </div>
  @for($i=0; $i < count($pagetags); $i++)
  @if($pagetags[$i]->isavaliable())
  <nav class="targ targlist{{ $i+1 }} hidden">
    <ul class="pagination">
      @if($pagetags[$i]->start == 1)
      <li class="hidden disabled">
      @else
      <li>
      @endif
        <a href="/admin?action=usermanage&tabpos={{ $i }}&page={{ $pagetags[$i]->start-1 }}" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
      </li>
      @for($index=$pagetags[$i]->start; $index < $pagetags[$i]->end; $index++)
        @if($pagetags[$i]->getPage() == $index)
        <li class="active">
        @else
        <li>
        @endif
          <a href="/admin?action=usermanage&tabpos={{ $i }}&page={{ $index }}">{{ $index }}</a>
        </li>
      @endfor
      @if($pagetags[$i]->end == $pagetags[$i]->getPageSize() + 1)
      <li class="hidden disabled">
      @else
      <li>
      @endif
        <a href="/admin?action=usermanage&tabpos={{ $i }}&page={{ $pagetags[$i]->end }}" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
      </li>
    </ul>
  </nav>
  @endif
  @endfor
</div>
<script type="text/javascript">
  loadUserGrade({{ $grades[isset($_GET['tabpos'])&&$_GET['tabpos']<4?$_GET['tabpos']:'0']->grade }});
</script>
