@extends('layouts.master')

@section('content')

<div class="page-header">
	<div class="pull-left"><a href="{{ route('career') }}"><span class="fa fa-chevron-left"></span> {{ trans('label.back') }}</a></div>
	<h1>{{ $career->name }} <small><span class="fa fa-lock"></span> {{ $career->end_date }}</small></h1>
</div>
<div class="container">
	@if ($career->image != '')
	    <!--a href="{{ asset('uploads/'.$career->image) }}" target="_blank" title="{{ $career->image }}"/>
	        <img src="{{ asset('uploads/'.$career->image) }}" class="img-thumbnail"/>
	    </a-->
	@endif
	<p>{{ $career->description }}</p>
	<hr/>
</div>
<div class="container-fluid">
	<h4>{{ trans('label.apply_social') }}</h4>
	<div class="form-group">
		<div class="col-lg-12 col-md-12 col-xs-12">
			<a href="{{ url('auth/social/twitter') }}" title="Apply with Twitter" class="btn btn-info btn-md"><span class="fa fa-twitter"></span>&nbsp; Apply with Twitter</a>
			<a href="{{ url('auth/social/facebook') }}" title="Apply with Facebook" class="btn btn-primary btn-md"><span class="fa fa-facebook"></span>&nbsp; Apply with Facebook</a>
			<a href="{{ url('auth/social/linkedin') }}" title="Apply with Linkedin" class="btn btn-success btn-md"><span class="fa fa-linkedin"></span>&nbsp; Apply with LinkedIn</a>
			<a href="{{ url('auth/social/google') }}" title="Apply with Google" class="btn btn-warning btn-md"><span class="fa fa-google-plus"></span>&nbsp; Apply with Google</a>
		</div>
	</div>
</div>
<div style="margin:60px auto"></div>
{!! Form::model($career,
	[
		'route' => ['career.apply', $career->slug],
		'files' => true,
		'class' => ''
	])
!!}
<div class="form-group{{ $errors->first('name', ' has-error') }}">
	{!! Form::label('name', trans('label.name')); !!}
	{!! Form::text('name',Request::old('name', $applicant->name),[
		'placeholder'=>trans('label.enter_name'),
		'name'=>'name',
		'id'=>'name',
		'class' => 'form-control']); !!}
	<span class="help-block">{{{ $errors->first('name', ':message') }}}</span>
</div>
<div class="form-group{{ $errors->first('email', ' has-error') }}">
	{!! Form::label('email', trans('label.email_address')); !!}
	{!! Form::text('email',Request::old('email', $applicant->email),[
		'placeholder'=>trans('label.enter_email'),
		'name'=>'email',
		'id'=>'email',
		'class'=>'form-control']); !!}
	<span class="help-block">{{{ $errors->first('email', ':message') }}}</span>
</div>
<div class="form-group{{ $errors->first('phone', ' has-error') }}">
	{!! Form::label('phone', trans('label.phone_number')); !!}
	{!! Form::text('phone',Request::old('phone', $applicant->phone),[
		'placeholder'=>trans('label.enter_phone'),
		'name'=>'phone',
		'id'=>'phone',
		'class'=>'form-control']); !!}
	<span class="help-block">{{{ $errors->first('phone', ':message') }}}</span>
</div>
<div class="form-group{{ $errors->first('description', ' has-error') }}">
	{!! Form::label('description', trans('label.description')); !!}
	{!! Form::textarea('description',Request::old('description', $applicant->description),[
		'placeholder'=>trans('label.enter_description'),
		'name'=>'description',
		'id'=>'description',
		'class' => 'form-control',
		'rows' => '4'
	]); !!}
	<span class="help-block">{{{ $errors->first('description', ':message') }}}</span>
</div>
<div class="form-group">
	{!! Form::label('image', ($applicant->image) ? 'Replace Image:' : 'Image:', ['class' => 'control-label']) !!}
	@if ($applicant->image)
		{{$applicant->image}}
	@endif
	{!! Form::file('image') !!}
</div>

{!! Form::submit(trans('label.apply'), ['class' => 'btn btn-primary btn-md']) !!}

{!! Form::close() !!}

<div style="margin:60px auto"></div>

@stop
