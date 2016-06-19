<div id="divnews{{ $anew->id }}">
  @if($anew->isread)
  <h3 style="font-family: SimSun; margin-top: 20px;">{{ $anew->title }}</h3>
  <div style="margin-right: 10px;">
    <p style="font-size: 95%; font-family: times;">发布 ：{{ $anew->owner }} , 可见：{{ $anew->allowtext }}<br>时间：{{ $anew->updated_at }}</p><br>
  </div>
  <div id="newssubtitle{{ $anew->id }}">
    {!! $anew->subtitle !!}
  </div>
  @else
  <h3 style="font-family: SimHei; margin-top: 20px;">{{ $anew->title }}</h3>
  <div style="margin-right: 10px;">
    <p style="font-size: 95%; font-family: times; font-weight: bold;">发布 ：{{ $anew->owner }} , 可见：{{ $anew->allowtext }}<br>时间：{{ $anew->updated_at }}</p><br>
  </div>
  <div id="newssubtitle{{ $anew->id }}" style="font-weight: bold;">
    {!! $anew->subtitle !!}
  </div>
  @endif
  <div id="newscontent{{ $anew->id }}" class="hidden">
    {!! $anew->text !!}
  </div><br>
  <a id="usersubctrl{{ $anew->id }}" href="javascript:userActSubCheck('{{ $anew->id }}', '{{ $anew->isread }}');" style="margin-right: 4px;">更多</a>
  @if($user->privilege == 5 && $user->grade == 1)
  <a id="usersubdel{{ $anew->id }}" href="javascript:newsADelAlert('{{ $user->id }}', '{{ $anew->id }}', '0');" class="hidden" style="margin-right: 4px;">删除</a>
  <a id="usersubedt{{ $anew->id }}" href="javascript:loadContent('divrecv', '/admin?action=useractivity&id={{ $user->id }}&opt=edt&newsid={{ $anew->id }}&page={{ $recvnewspagetag->getPage() }}&tabpos=0');" class="hidden" style="margin-right: 4px;">编辑</a>
  @endif
  <a href="javascript:loadContent('divrecv', '/admin?action=useractivity&id={{ $user->id }}&opt=all&newsid={{ $anew->id }}&page={{ $recvnewspagetag->getPage() }}&tabpos=0');">全部</a><hr>
</div>