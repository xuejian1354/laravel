@section('useractivity')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h5 style="float: right;" >当前用户: {{ $user->name }}</h5>
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="nav-li tabrecv active"><a href="javascript:loadNewsContent(0);">收到</a></li>
    <li role="presentation" class="nav-li tabsend"><a href="javascript:loadNewsContent(1);">发布</a></li>
  </ul>

  <div class="divrecv">
  @foreach($news as $anew)
    @if($anew->isrecv)
    <div id="divrecvnews{{ $anew->id }}">
      <h3 style="margin-top: 20px;"><b>{{ $anew->title }}</b></h3>
      <div style="margin-right: 10px;">
        <p>时间: {{ $anew->updated_at }}</p><br>
      </div>
      <div>
        {!! $anew->subtitle !!}
      </div><br>
      <a href="admin?action=useractivity&id={{ $user->id }}&opt=more&newsid={{ $anew->id }}" style="margin-right: 4px;">更多</a>
      <a href="admin?action=useractivity&id={{ $user->id }}&opt=all&newsid={{ $anew->id }}">全部</a><hr>
    </div>
    @endif
  @endforeach
  </div>
  <div class="divsend hidden">
  @foreach($news as $anew)
    @if(!$anew->isrecv)
    <div id="divrecvnews{{ $anew->id }}">
      <h3 style="margin-top: 20px;"><b>{{ $anew->title }}</b></h3>
      <div style="margin-right: 10px;">
        <p>时间: {{ $anew->updated_at }}</p><br>
      </div>
      <div>
        {!! $anew->subtitle !!}
      </div><br>
      <a href="admin?action=useractivity&id={{ $user->id }}&opt=more&newsid={{ $anew->id }}" style="margin-right: 4px;">更多</a>
      <a href="admin?action=useractivity&id={{ $user->id }}&opt=all&newsid={{ $anew->id }}">全部</a><hr>
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
</script>
@endsection