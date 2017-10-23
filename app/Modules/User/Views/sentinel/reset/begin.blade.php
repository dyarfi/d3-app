@extends('Admin::layouts.template_login')

@section('title')
Reset Password
@stop

@section('body')
<!--div class="page-header">
	<h1>Reset Password</h1>
</div-->

<div id="login-box" class="login-box">
	<div class="position-relative">
		<div id="forgot-box" class="forgot-box widget-box no-border visible">
			<div class="widget-body">
				<div class="widget-main">
					<h4 class="header red lighter bigger">
					<i class="ace-icon fa fa-key"></i>
					Retrieve Password
					</h4>
					<div class="space-6"></div>
					<p> Enter your email and to receive instructions </p>
					{!! Form::open(['class' => 'form-horizontal']) !!}
						<fieldset>
							<label class="block clearfix">
								<span class="block input-icon input-icon-right">
									{!! Form::email('email', null, ['class' => 'form-control']) !!}
									<i class="ace-icon fa fa-envelope"></i>
								</span>
							</label>
							<div class="clearfix">
								<?php /* {!! Form::submit('Reset', ['class' => 'width-35 pull-right btn btn-sm btn-danger','type'=.'button']) !!} */ ?>
								<button class="width-35 pull-right btn btn-sm btn-danger" type="submit">
									<i class="ace-icon fa fa-lightbulb-o"></i>
									<span class="bigger-110">Send Me!</span>
								</button>
							</div>
						</fieldset>
					{!! Form::close() !!}
				</div>
				<div class="toolbar center">
					<!--a class="back-to-login-link" href="{{ route('admin.login') }}" data-target="#login-box"-->
					<a class="back-to-login-link" href="{{ route('admin.login') }}">
					Back to login
					<i class="ace-icon fa fa-arrow-right"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

@stop
