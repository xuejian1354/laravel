<div id="msglist">
  <div id="external-events">
  @foreach($msgboards as $msgboard)
    <div class="external-event" style="background-color: {{ $msgboard->bgcolor }}; border-color:{{ $msgboard->bgcolor }}; color: #fff">{!! $msgboard->content !!}</div>
  @endforeach
  </div>
</div>