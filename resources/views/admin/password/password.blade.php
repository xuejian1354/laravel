<div>
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
	
			<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/resetpass') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
	
				<div class="form-group">
					<label class="col-md-4 control-label">帐号</label>
					<div class="col-md-6">
						<select class="form-control" name="email">
						@foreach($users as $user)
						  @if(Auth::user()->email == $user->email)
						    <option selected = "selected">{{ $user->email }}</option>
						  @else
						    <option>{{ $user->email }}</option>
						  @endif
						@endforeach
						</select>
					</div>
				</div>
	
				<div class="form-group">
					<label class="col-md-4 control-label">新密码</label>
					<div class="col-md-6">
						<input type="password" class="form-control" name="new_pass">
					</div>
				</div>
	
				<div class="form-group">
					<label class="col-md-4 control-label">确认密码</label>
					<div class="col-md-6">
						<input type="password" class="form-control" name="confirm_pass">
					</div>
				</div>
	
				<div class="form-group">
					<div class="col-md-6 col-md-offset-4">
						<button type="submit" class="btn btn-primary">确定</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
