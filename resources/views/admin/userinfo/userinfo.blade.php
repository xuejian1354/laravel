@section('userinfo')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>
  <ul class="nav nav-tabs" role="tablist">
    @foreach($grades as $grade)
      <li role="presentation" class="nav-li nav-li{{ $grade->grade }}"><a href="javascript:loadUserGrade({{ $grade->grade }});">{{ $grade->val }}</a></li>
    @endforeach
  </ul>
</div>
<script type="text/javascript">
  loadUserGrade({{ $grades[isset($_GET['tabpos'])&&$_GET['tabpos']<4?$_GET['tabpos']:'0']->grade }});
</script>
@endsection
