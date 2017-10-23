@extends('Admin::layouts.template_login')

@section('title')
Please Wait
@stop

@section('body')
<div id="login-box" class="login-box">
	<div class="position-relative">
		<div id="forgot-box" class="forgot-box widget-box no-border visible">
			<div class="widget-body">
				<div class="widget-main">
					<div class="page-header">
						<h1>Please Wait</h1>
					</div>
					<span>
						Very shortly, you will receive an email with instructions on how to continue.
					</span>
					<div class="space-12"></div>
					<div class="clearfix">
						<a class="width-35 pull-right btn btn-sm btn-primary" href={{ route('home') }}>
							<i class="ace-icon glyphicon glyphicon-ok"></i> <span class="bigger-110">Continue</span>
						</a>
					</div>
					<div class="space-10"></div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
