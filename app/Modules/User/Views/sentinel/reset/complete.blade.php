@extends('Auth::layouts.template_login')

@section('title')
Reset Password
@stop

@section('body')

<div id="login-box" class="login-box">
	<div class="position-relative">
		<div id="forgot-box" class="forgot-box widget-box no-border visible">
			<div class="widget-body">
				<div class="widget-main">

					<div class="page-header">
						<h1>Reset Password</h1>
					</div>

					{!! Form::open(['class' => 'form-horizontal']) !!}

						<div class="form-group">
							<label for="password" class="col-sm-5 control-label">New Password</label>
							<div class="col-sm-7">
								{!! Form::password('password', ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							<label for="password-confirmation" class="col-sm-5 control-label">Confirm Password</label>
							<div class="col-sm-7">
								{!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-8 col-sm-push-4">
								{!! Form::submit('Reset', ['class' => 'btn btn-lg btn-primary']) !!}
							</div>
						</div>

					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>

@stop
