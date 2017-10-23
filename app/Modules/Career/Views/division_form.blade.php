@extends('Admin::layouts.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>{{ $mode == 'create' ? 'Create Division' : 'Update Division' }} <small>{{ $mode === 'update' ? $row->name : null }}</small></h1>
</div>

{!! Form::open([
    'route' => ($mode == 'create') ? 'admin.divisions.create' : ['admin.divisions.update', $row->id]
]) !!}

	<div class="form-group{{ $errors->first('name', 'has-error') }}">
		{!! Form::label('name', 'Name') !!}
		{!! Form::text('name',Input::old('name', $row->name),[
			'placeholder'=>'Enter your Name.',
			'name'=>'name',
			'id'=>'name',
			'class' => 'form-control']) !!}
		<span class="help-block">{{{ $errors->first('name', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('slug', ' has-error') }}">
		{!! Form::label('slug', 'Slug') !!}
		{!! Form::text('slug',Input::old('slug', $row->slug),[
			'placeholder'=>'Enter the Career Slug.',
			'name'=>'slug',
			'id'=>'slug',
			'readonly'=>true,
			'class'=>'form-control']) !!}
		<span class="help-block">{{{ $errors->first('slug', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('description', ' has-error') }}">
		{!! Form::label('description', 'Description') !!}
		{!! Form::textarea('description',Input::old('description', $row->description),[
			'placeholder'=>'Enter the Description.',
			'name'=>'description',
			'id'=>'description',
			'class' => 'form-control ckeditor',
			'rows' => '4'
		]); !!}
		<span class="help-block">{{{ $errors->first('description', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('is_system', 'has-error') }}">
		{!! Form::label('is_system', 'Is System') !!}
		{!! Form::select('is_system', [1=>'Yes',0=>'No'], Input::get('is_system') ? Input::get('is_system') : Input::old('is_system', $row->is_system)) !!}
		<span class="help-block">{{{ $errors->first('is_system', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('status', ' has-error') }}">
		<label for="status">Status</label>
		<select id="status" name="status" class="form-control input-sm">
			<option value="">&nbsp;</option>
			@foreach (config('setting.status') as $config => $val)
				<option value="{{ $config ? $config : Input::old('status', $row->status) }}" {{ $config == $row->status ? 'selected' : '' }}>{{$val}}</option>
			@endforeach
		</select>
		<span class="help-block">{{{ $errors->first('status', ':message') }}}</span>
	</div>
	
	{!! Form::submit(ucfirst($mode).' New Division', ['class' => 'btn btn-primary btn-xs']) !!}

{!! Form::close() !!}

@stop
