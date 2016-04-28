<div style="margin: 10px">
@if(isset($returnurl))
  <h4>
    @if($tabpos == 1)
    <a href="javascript:loadContent('divsend', 'admin?action=useractivity&id={{ $userid }}&opt=edt&newsid={{ $news->id }}&tabpos=1');" style="margin-top: 200px;">编辑</a>
    @endif
    <a href="{{ $returnurl }}" style="margin-top: 200px;">返回</a>
  </h4>
@else
  <h4><a href="admin?action=userinfo&tabpos=0" style="margin-top: 200px;">返回</a></h4>
@endif
</div>
<h1 style="text-align: center; margin-top: 20px;">{{ $news->title }}</h1>
<hr>
<div style="text-align: right; margin-right: 10px;">
  <p>{{ '发布：'.$news->owner.' , 可见：'.$news->allowtext }}<br>{{ $news->updated_at }}</p>
</div>
<div style="padding: 10px;">
  {!! $news->text !!}
</div>