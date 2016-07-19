@section('sidemenu')
<div class="list-group">
  <a href="/service/email" class="list-group-item
    @if($title == 'email')
      {{ 'active' }}
    @endif
  ">E-Mail</a>
  <a href="/service/file" class="list-group-item
    @if($title == 'file')
      {{ 'active' }}
    @endif
  ">File</a>
  <a href="/service/note" class="list-group-item
    @if($title == 'note')
      {{ 'active' }}
    @endif
  ">Note</a>
</div>
@endsection