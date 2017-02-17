@extends('cullive.layouts.app')

@section('htmlheader_title')
	{{ trans('message.home') }}
@endsection


@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Home</div>

					<div class="panel-body">
						{{ trans('cullive.message.logged') }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
