@extends('admin.public.base')
@extends('admin.public.menuboard')

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  <div class="row"></div>
</div>
@endsection
