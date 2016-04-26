@section('useractivity')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h5 style="float: right;">当前用户: {{ $user->name }}<br>
  <a href="admin?action=usermanage&tabpos={{ $user->grade-1 }}" style="float: right; margin-top: 5px;">返回</a></h5>
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="nav-li tabrecv active"><a href="javascript:loadNewsContent(0);">收到</a></li>
    <li role="presentation" class="nav-li tabsend"><a href="javascript:loadNewsContent(1);">发布</a></li>
  </ul>

  <div id="divrecv" class="divrecv">
  @foreach($news as $anew)
    @if($anew->isrecv)
    <div id="divnews{{ $anew->id }}">
      <h3 style="margin-top: 20px;"><b>{{ $anew->title }}</b></h3>
      <div style="margin-right: 10px;">
        <p style="font-size: 95%; font-family: times;">发布 ：{{ $anew->owner }} , 可见：{{ $anew->allowtext }}<br>时间：{{ $anew->updated_at }}</p><br>
      </div>
      <div id="newssubtitle{{ $anew->id }}">
        {!! $anew->subtitle !!}
      </div>
      <div id="newscontent{{ $anew->id }}" class="hidden">
        {!! $anew->text !!}
      </div><br>
      <a id="usersubctrl{{ $anew->id }}" href="javascript:userActSubCheck('{{ $anew->id }}');" style="margin-right: 4px;">更多</a>
      <a href="javascript:loadContent('divrecv', 'admin?action=useractivity&id={{ $user->id }}&opt=all&newsid={{ $anew->id }}&tabpos=0');">全部</a><hr>
    </div>
    @endif
  @endforeach
  </div>
  <div id="divsend" class="divsend hidden">
  @foreach($news as $anew)
    @if(!$anew->isrecv)
    <div id="divnews{{ $anew->id }}">
      <h3 style="margin-top: 20px;"><b>{{ $anew->title }}</b></h3>
      <div style="margin-right: 10px;">
        <p style="font-size: 95%; font-family: times;">发布 ：{{ $anew->owner }} , 可见：{{ $anew->allowtext }}<br>时间：{{ $anew->updated_at }}</p><br>
      </div>
      <div id="newssubtitle{{ $anew->id }}">
        {!! $anew->subtitle !!}
      </div>
      <div id="newscontent{{ $anew->id }}" class="hidden">
        {!! $anew->text !!}
      </div><br>
      <a id="usersubctrl{{ $anew->id }}" href="javascript:userActSubCheck('{{ $anew->id }}');" style="margin-right: 4px;">更多</a>
      <a href="javascript:loadContent('divsend', 'admin?action=useractivity&id={{ $user->id }}&opt=all&newsid={{ $anew->id }}&tabpos=1');">全部</a><hr>
    </div>
    @endif
  @endforeach
  </div>
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

function userActSubCheck(id)
{
	var actrl = $('#usersubctrl' + id);
	var subtitle = $('#newssubtitle' + id);
	var content = $('#newscontent' + id);

	if(actrl.text() == '更多')
	{
		actrl.text('收起');
		subtitle.addClass('hidden');
		content.removeClass('hidden');
	}
	else
	{
		actrl.text('更多');
		subtitle.removeClass('hidden');
		content.addClass('hidden');
	}
}
</script>
@endsection