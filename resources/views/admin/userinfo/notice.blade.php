<div id="noticebody">
<div class="table-responsive">
  <table class="table table-striped" style="min-width: 600px;">
    <thead>
      <tr>
        <th>#</th>
        <th>标题</th>
        <th>副标</th>
        <th>发布者</th>
        <th>允许访问</th>
        <th>创建时间</th>
        <th><a href="javascript:loadContent('noticebody', 'admin?action=userinfo/addnews');">添加</a></th>
        <th><input type="checkbox" class="newscheckall"></th>
      </tr>
    </thead>
    <tbody id="newstbody">
    @for($index=0; $index < $newspagetag->getRow(); $index++)
      @if($index < count($news))
      <tr>
        <td>{{ $index+1 }}</td>
        <td>{{ $news[$index]->title }}</td>
        <td>{{ $news[$index]->subtitle }}</td>
        <td>{{ $news[$index]->owner }}</td>
        <td>{{ $news[$index]->allowgradestr }}</td>
        <td>{{ $news[$index]->updated_at }}</td>
        <td><a href="javascript:loadContent('noticebody', 'admin?action=userinfo/newscontent&id={{ $news[$index]->id }}');">查看</a></td>
        <th><input type="checkbox" class="newscheck" eleid="{{ $news[$index]->id }}"></th>
      </tr>
      @elseif($newspagetag->isavaliable())
      <tr style="height: 39px;"></tr>
      @endif
    @endfor
    </tbody>
  </table>
  <div class="newsedt hidden" style="float: right;">
    <a href="javascript:newsEdtWin('{{ csrf_token() }}');" class="btn btn-primary" role="button">修改</a>
    <a href="javascript:newsDelAlert('{{ csrf_token() }}');" class="btn btn-danger" role="button">删除</a>
  </div>
  @if($newspagetag->isavaliable())
  <nav>
    <ul class="pagination">
      @if($newspagetag->start == 1)
      <li class="hidden disabled">
      @else
      <li>
      @endif
        <a href="admin?action=userinfo&tabpos=0&page={{ $newspagetag->start-1 }}" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
      </li>
      @for($index=$newspagetag->start; $index < $newspagetag->end; $index++)
        @if($newspagetag->getPage() == $index)
        <li class="active">
        @else
        <li>
        @endif
          <a href="admin?action=userinfo&tabpos=0&page={{ $index }}">{{ $index }}</a>
        </li>
      @endfor
      @if($newspagetag->end == $newspagetag->getPageSize() + 1)
      <li class="hidden disabled">
      @else
      <li>
      @endif
        <a href="admin?action=userinfo&tabpos=0&page={{ $newspagetag->end }}" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
      </li>
    </ul>
  </nav>
  @endif
</div>
</div>