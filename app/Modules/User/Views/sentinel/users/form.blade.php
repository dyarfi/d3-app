@extends('Auth::layouts.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>{{ $mode == 'create' ? 'Create User' : 'Update User' }} <small>{{ $mode === 'update' ? $row->name : null }}</small></h1>
</div>
<!--form method="post" action="" autocomplete="off"-->
{!! Form::open([
    'route' => ($mode == 'create') ? 'admin.users.create' : ['admin.users.update', $row->id], 'files' => true
]) !!}

	<div class="form-group{{ $errors->first('first_name', ' has-error') }}">
		<label for="first_name">First Name</label>
		<input type="text" class="form-control" name="first_name" id="first_name" value="{{ Input::old('first_name', $row->first_name) }}" placeholder="Enter the user first_name.">
		<span class="help-block">{{{ $errors->first('first_name', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('last_name', ' has-error') }}">
		<label for="name">Last Name</label>
		<input type="text" class="form-control" name="last_name" id="last_name" value="{{ Input::old('last_name', $row->last_name) }}" placeholder="Enter the user last_name.">
		<span class="help-block">{{{ $errors->first('last_name', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('email', ' has-error') }}">
		<label for="email">Email</label>
		<input type="text" class="form-control" name="email" id="email" value="{{ Input::old('email', $row->email) }}" placeholder="Enter the user email.">
		<span class="help-block">{{{ $errors->first('email', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('about', ' has-error') }}">
		{!! Form::label('about', 'About'); !!}
		{!! Form::textarea('about',Input::old('about', $row->about),[
			'placeholder'=>'Enter the about User.',
			'name'=>'about',
			'id'=>'ckeditor',
			'class' => 'form-control',
			'rows' => '4'
		]); !!}
		<span class="help-block">{{{ $errors->first('about', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('password', ' has-error') }}">
		<label for="password">Password</label>
		<input type="password" class="form-control" name="password" id="password" value="" placeholder="Enter the user password (only if you want to modify it).">
		<span class="help-block">{{{ $errors->first('password', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('role_id', ' has-error') }}">
		<label for="role_id">Roles</label>
		{!! Form::select('role_id', $roles, Input::get('role_id') ? Input::get('role_id') : Input::old('role_id', @$row->roles()->first()->id),['class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('role_id', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('image', ' has-error') }}">
		{!! Form::label('image', 'Profile Image:'); !!}
		@if ($row->image)
			{!! Form::label('image', ($row->image) ? 'Replace Image ?' : 'Profile Image:', ['class' => 'control-label center-block ace-file-input']) !!}
			<img src="{{ asset('uploads/'.$row->image) }}" alt="{{ $row->image }}" class="image-alt" style="max-width:300px"/>
			<div class="clearfix space-6"></div>
		@endif
		<div class="row">
			<div class="col-xs-6">
				<label class="ace-file-input">
					{!! Form::file('image','',['class'=>'form-controls','id'=>'id-input-file-2']) !!}
					<span class="ace-file-container" data-title="Choose">
						<span class="ace-file-name" data-title="No File ...">
							<i class=" ace-icon fa fa-upload"></i>
						</span>
					</span>
				</label>
			</div>
		</div>
		<span class="help-block red">{{{ $errors->first('image', ':message') }}}</span>
	</div>

	<button type="submit" class="btn btn-default">Submit</button>
{!! Form::close() !!}

@stop
