@extends('Auth::layouts.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>{{ $mode == 'create' ? 'Create Applicant' : 'Update Applicant' }} <small>{{ $mode === 'update' ? $row->name : null }}</small></h1>
</div>
<!--form method="post" action="" autocomplete="off"-->
{!! Form::open([
    'route' => ($mode == 'create') ? 'admin.applicants.create' : ['admin.applicants.update', $row->id]
]) !!}

	<div class="form-group{{ $errors->first('first_name', ' has-error') }}">
		<label for="first_name">First Name</label>
		<input type="text" class="form-control" name="first_name" id="first_name" value="{{ Input::old('first_name', $row->first_name) }}" placeholder="Enter the applicant First Name.">
		<span class="help-block">{{{ $errors->first('first_name', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('last_name', ' has-error') }}">
		<label for="name">Last Name</label>
		<input type="text" class="form-control" name="last_name" id="last_name" value="{{ Input::old('last_name', $row->last_name) }}" placeholder="Enter the applicant Last Name.">
		<span class="help-block">{{{ $errors->first('last_name', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('email', ' has-error') }}">
		<label for="email">Email</label>
		<input type="text" class="form-control" name="email" id="email" value="{{ Input::old('email', $row->email) }}" placeholder="Enter the applicant email.">
		<span class="help-block">{{{ $errors->first('email', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('password', ' has-error') }}">
		<label for="password">Password</label>
		<input type="password" class="form-control" name="password" id="password" value="" placeholder="Enter the applicant password (only if you want to modify it).">
		<span class="help-block">{{{ $errors->first('password', ':message') }}}</span>
	</div>

	<button type="submit" class="btn btn-default">Submit</button>
{!! Form::close() !!}

@stop
