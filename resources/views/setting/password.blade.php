@extends('app')
@extends('setting.sidemenu')

@section('content')
<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-heading">密码修改</div>
		<div class="panel-body">
			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<strong>Whoops!</strong> There were some problems with your input.<br><br>
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			@if (isset($info))
				<div class="alert alert-success">
					<ul>
					  <li>{{ $info }}</li>
					</ul>
				</div>
			@endif
	
			<form class="form-horizontal" role="form" method="POST" action="{{ url('/setting/resetpass') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
	
				<div class="form-group">
					<label class="col-md-4 control-label">旧密码</label>
					<div class="col-md-6">
						<input type="password" class="form-control" name="old_pass">
					</div>
				</div>
	
				<div class="form-group">
					<label class="col-md-4 control-label">新密码</label>
					<div class="col-md-6">
						<input type="password" class="form-control" name="new_pass">
					</div>
				</div>
	
				<div class="form-group">
					<label class="col-md-4 control-label">密码确认</label>
					<div class="col-md-6">
						<input type="password" class="form-control" name="confirm_pass">
					</div>
				</div>
	
				<div class="form-group">
					<div class="col-md-6 col-md-offset-4">
						<button type="submit" class="btn btn-primary">重置</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection