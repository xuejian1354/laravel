<div style="margin: 10px">
  <h4><a href="admin?action=userinfo&tabpos=0" style="margin-top: 200px;">返回</a></h4>
</div>
<h1 style="text-align: center; margin-top: 20px;">{{ $news->title }}</h1>
<hr>
<div style="text-align: right; margin-right: 10px;">
  <p>{{ 'Author: '.$news->owner }}<br>{{ $news->updated_at }}</p>
</div>
<div style="padding: 10px;">
  {!! $news->text !!}
</div>