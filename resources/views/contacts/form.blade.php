@extends('layouts.master')

@section('content')

<div class="page-header">
	<h1>{{ $menu->name }}</h1>
</div>
<div class="container">
	@if ($menu->image != '')
	    <!--a href="{{ asset('uploads/'.$career->image) }}" target="_blank" title="{{ $career->image }}"/>
	        <img src="{{ asset('uploads/'.$career->image) }}" class="img-thumbnail"/>
	    </a-->
	@endif
	<p>{{ $menu->description }}</p>
	<hr/>
</div>
<div style="margin:60px auto"></div>
{!! Form::model($contact,
	[
		'route' => ['contact.send'],
		'class' => ''
	])
!!}

<div class="form-group{{ $errors->first('name', ' has-error') }}">
	{!! Form::label('name', trans('label.name'), ['class'=>'control-label']); !!}
	{!! Form::text('name',Request::old('name', $contact->name),[
		'placeholder'=>trans('label.enter_name'),
		'name'=>'name',
		'id'=>'name',
		'class' => 'form-control']); !!}
	<span class="help-block">{{{ $errors->first('name', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('email', ' has-error') }}">
	{!! Form::label('email', trans('label.email_address'), ['class'=>'control-label']); !!}
	{!! Form::text('email',Request::old('email', $contact->email),[
		'placeholder'=>trans('label.enter_email'),
		'name'=>'email',
		'id'=>'email',
		'class'=>'form-control']); !!}
	<span class="help-block">{{{ $errors->first('email', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('subject', ' has-error') }}">
	{!! Form::label('subject', trans('label.subject'), ['class'=>'control-label']); !!}
	{!! Form::text('phone',Request::old('subject', $contact->subject),[
		'placeholder'=>trans('label.enter_subject'),
		'name'=>'subject',
		'id'=>'subject',
		'class'=>'form-control']); !!}
	<span class="help-block">{{{ $errors->first('subject', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('description', ' has-error') }}">
	{!! Form::label('description', trans('label.description'), ['class'=>'control-label']); !!}
	{!! Form::textarea('description',Request::old('description', $contact->description),[
		'placeholder'=>trans('label.enter_description'),
		'name'=>'description',
		'id'=>'description',
		'class' => 'form-control',
		'rows' => '4'
	]); !!}
	<span class="help-block">{{{ $errors->first('description', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('g-recaptcha-response', ' has-error') }}">
	{!! Form::label('captcha', 'Captcha', ['class'=>'control-label']); !!}
	{!! app('captcha')->display(); !!}
	<span class="help-block">{{{ $errors->first('g-recaptcha-response', ':message') }}}</span>
</div>

<div class="clearfix">
	{!! Form::submit(trans('label.submit'), ['class' => 'btn btn-primary btn-md']) !!}
</div>

{!! Form::close() !!}

<div style="margin:60px auto"></div>

@stop
