@section('courseimport')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  <form action="{{url('/xls/courselist')}}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <p><input type="file" name="xlsfile" accept=".xls,.xlsx,.csv"></p>
    <p><input type="submit"></p>
  </form>
</div>
@endsection
