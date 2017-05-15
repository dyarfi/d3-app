@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Login</div>
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

					<form class="form-horizontal" role="form" method="POST" action="{{ route('login.post') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">{{ trans('label.email_address') }}</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ trans('label.email_address') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">{{ trans('label.password') }}</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password" placeholder="{{ trans('label.password') }}">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> {{trans('label.remember_me')}}
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">{{ trans('label.login') }}</button>

								<a class="btn btn-link" href="{{ url('/auth/password/email') }}">{{ trans('label.forgot_password') }}</a>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12 col-xs-12 col-md-offset-4">
								<a href="{{ url('auth/social/twitter') }}" title="{{ trans('label.login_with') }} Twitter" class="btn btn-info btn-md"><span class="fa fa-twitter"></span>&nbsp; {{ trans('label.login_with') }} Twitter</a>
								<a href="{{ url('auth/social/facebook') }}" title="{{ trans('label.login_with') }} Facebook" class="btn btn-primary btn-md"><span class="fa fa-facebook"></span>&nbsp; {{ trans('label.login_with') }} Facebook</a>
								<a href="{{ url('auth/social/linkedin') }}" title="{{ trans('label.login_with') }} Linkedin" class="btn btn-success btn-md"><span class="fa fa-linkedin"></span>&nbsp; {{ trans('label.login_with') }} LinkedIn</a>
								<a href="{{ url('auth/social/google') }}" title="{{ trans('label.login_with') }} Google" class="btn btn-warning btn-md"><span class="fa fa-google"></span>&nbsp; {{ trans('label.login_with') }} Google</a>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
