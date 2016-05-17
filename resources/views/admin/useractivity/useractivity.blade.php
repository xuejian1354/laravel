@section('useractivity')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h5 style="float: right;">当前用户: {{ $user->name }}<br>
  <a href="admin?action=usermanage&tabpos={{ $user->grade-1 }}" style="float: right; margin-top: 5px;">用户返回</a></h5>
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  <ul class="nav nav-tabs" role="tablist">
  @if(Input::get('tabpos') == 1)
    <li role="presentation" class="nav-li tabrecv"><a href="javascript:loadNewsContent(0);">收到</a></li>
    @if($user->grade != 4 && $user->privilege != 1)
    <li role="presentation" class="nav-li tabsend active"><a href="javascript:loadNewsContent(1);">发布</a></li>
    @endif
  @else
    <li role="presentation" class="nav-li tabrecv active"><a href="javascript:loadNewsContent(0);">收到</a></li>
    @if($user->grade != 4 && $user->privilege != 1)
    <li role="presentation" class="nav-li tabsend"><a href="javascript:loadNewsContent(1);">发布</a></li>
    @endif
  @endif
  </ul>

  @if(Input::get('tabpos') == 1)
  <div id="divrecv" class="divrecv hidden">
  @else
  <div id="divrecv" class="divrecv">
  @endif
  <div class="alert" style="margin-top: 20px; background: #f0f0f0;">
          收到消息：{{ $user->recvcount }} ， 未读：{{ $user->noreadcount }}
  </div>
  @if($recvnewspagetag->isavaliable())
  <nav>
    <ul class="pagination" style="margin: 0;">
      @if($recvnewspagetag->start == 1)
      <li class="hidden disabled">
      @else
      <li>
      @endif
        <a href="admin?action=useractivity&tabpos=0&id={{ $user->id }}&page={{ $recvnewspagetag->start-1 }}" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
      </li>
      @for($index=$recvnewspagetag->start; $index < $recvnewspagetag->end; $index++)
        @if($recvnewspagetag->getPage() == $index)
        <li class="active">
        @else
        <li>
        @endif
          <a href="admin?action=useractivity&tabpos=0&id={{ $user->id }}&page={{ $index }}">{{ $index }}</a>
        </li>
      @endfor
      @if($recvnewspagetag->end == $recvnewspagetag->getPageSize() + 1)
      <li class="hidden disabled">
      @else
      <li>
      @endif
        <a href="admin?action=useractivity&tabpos=0&id={{ $user->id }}&page={{ $recvnewspagetag->end }}" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
      </li>
    </ul>
  </nav>
  @endif
  @foreach($news as $anew)
    @if($anew->isrecv)
      @include('admin.userinfo.newsrecvlist')
    @endif
  @endforeach
  </div>
  @if($user->grade != 4 && $user->privilege != 1)
  @if(Input::get('tabpos') == 1)
  <div id="divsend" class="divsend">
  @else
  <div id="divsend" class="divsend hidden">
  @endif
  <div class="alert" style="margin-top: 20px; background: #f0f0f0;">
          发布消息：{{ $user->sendcount }}&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="javascript:loadContent('divsend', 'admin?action=useractivity&id={{ $user->id }}&opt=add&newsid={{ $anew->id }}&tabpos=1');">添加</a>
  </div>
  @if($sendnewspagetag->isavaliable())
  <nav>
    <ul class="pagination" style="margin: 0;">
      @if($sendnewspagetag->start == 1)
      <li class="hidden disabled">
      @else
      <li>
      @endif
        <a href="admin?action=useractivity&tabpos=1&id={{ $user->id }}&page={{ $sendnewspagetag->start-1 }}" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
      </li>
      @for($index=$sendnewspagetag->start; $index < $sendnewspagetag->end; $index++)
        @if($sendnewspagetag->getPage() == $index)
        <li class="active">
        @else
        <li>
        @endif
          <a href="admin?action=useractivity&tabpos=1&id={{ $user->id }}&page={{ $index }}">{{ $index }}</a>
        </li>
      @endfor
      @if($sendnewspagetag->end == $sendnewspagetag->getPageSize() + 1)
      <li class="hidden disabled">
      @else
      <li>
      @endif
        <a href="admin?action=useractivity&tabpos=1&id={{ $user->id }}&page={{ $sendnewspagetag->end }}" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
      </li>
    </ul>
  </nav>
  @endif
  @foreach($news as $anew)
    @if(!$anew->isrecv)
    <div id="divnews{{ $anew->id }}">
      <h3 style="font-family: SimSun; margin-top: 20px;">{{ $anew->title }}</h3>
      <div style="margin-right: 10px;">
        <p style="font-size: 95%; font-family: times;">发布 ：{{ $anew->owner }} , 可见：{{ $anew->allowtext }}<br>时间：{{ $anew->updated_at }}</p><br>
      </div>
      <div id="newssubtitle{{ $anew->id }}">
        {!! $anew->subtitle !!}
      </div>
      <div id="newscontent{{ $anew->id }}" class="hidden">
        {!! $anew->text !!}
      </div><br>
      <a id="usersubctrl{{ $anew->id }}" href="javascript:userActSubCheck('{{ $anew->id }}', '1');" style="margin-right: 4px;">更多</a>
      <a id="usersubdel{{ $anew->id }}" href="javascript:newsADelAlert('{{ $user->id }}', '{{ $anew->id }}', '1');" class="hidden" style="margin-right: 4px;">删除</a>
      <a id="usersubedt{{ $anew->id }}" href="javascript:loadContent('divsend', 'admin?action=useractivity&id={{ $user->id }}&opt=edt&newsid={{ $anew->id }}&page={{ $sendnewspagetag->getPage() }}&tabpos=1');" class="hidden" style="margin-right: 4px;">编辑</a>
      <a href="javascript:loadContent('divsend', 'admin?action=useractivity&id={{ $user->id }}&opt=all&newsid={{ $anew->id }}&page={{ $sendnewspagetag->getPage() }}&tabpos=1');">全部</a><hr>
    </div>
    @endif
  @endforeach
  </div>
  @endif
</div>

<script type="text/javascript">
loadNewsContent({{ isset($_GET['tabpos'])&&$_GET['tabpos'] }});

function loadNewsContent(i)
{
	if(i == 0)
	{
		$('.tabrecv').addClass('active');
		$('.tabsend').removeClass('active');
		$('.divrecv').removeClass('hidden');
		$('.divsend').addClass('hidden');
	}
	else if(i == 1)
	{
		$('.tabrecv').removeClass('active');
		$('.tabsend').addClass('active');
		$('.divrecv').addClass('hidden');
		$('.divsend').removeClass('hidden');
	}
}

function userActSubCheck(id, isread)
{
	var actrl = $('#usersubctrl' + id);
	var adel = $('#usersubdel' + id);
	var aedt = $('#usersubedt' + id);
	var subtitle = $('#newssubtitle' + id);
	var content = $('#newscontent' + id);

	if(actrl.text() == '更多')
	{
		actrl.text('收起');
		if(adel != null)
		{
			adel.removeClass('hidden');
			aedt.removeClass('hidden');
		}
		subtitle.addClass('hidden');
		content.removeClass('hidden');
	}
	else
	{
		actrl.text('更多');
		if(adel != null)
		{
			adel.addClass('hidden');
			aedt.addClass('hidden');
		}
		subtitle.removeClass('hidden');
		content.addClass('hidden');
	}

	if(isread != '1')
	{
		loadContent('divnews'+id, 'admin?action=useractivity&id={{ $user->id }}&opt=more&newsid='+id+'&page={{ $recvnewspagetag->getPage() }}&tabpos=0');
	}
}

function newsADelAlert(userid, newsid, tabpos) {

  if(confirm('确定要删除该活动通知?')) {
    var postForm = document.createElement("form");
    postForm.method="post";
    postForm.action = '/admin/newsadel';

    var useridInput = document.createElement("input");
    useridInput.setAttribute("name", "userid");
    useridInput.setAttribute("value", userid);
    postForm.appendChild(useridInput);

    var newsidInput = document.createElement("input");
    newsidInput.setAttribute("name", "newsid");
    newsidInput.setAttribute("value", newsid);
    postForm.appendChild(newsidInput);

    var tabposInput = document.createElement("input");
    tabposInput.setAttribute("name", "tabpos");
    tabposInput.setAttribute("value", tabpos);
    postForm.appendChild(tabposInput);

    var tokenInput = document.createElement("input");
    tokenInput.setAttribute("name", "_token");
    tokenInput.setAttribute("value", '{{ csrf_token() }}');
    postForm.appendChild(tokenInput);

    document.body.appendChild(postForm);
    postForm.submit();
    document.body.removeChild(postForm);
  }
}
</script>
@endsection