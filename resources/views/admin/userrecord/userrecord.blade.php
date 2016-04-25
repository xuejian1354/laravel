@section('userrecord')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h5 style="float: right;" >当前用户: {{ $user->name }}</h5>
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
</div>
@endsection