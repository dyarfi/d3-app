@extends('Auth::layouts.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>{{ $mode == 'create' ? 'Create Setting' : 'Update Setting' }} <small>{{ $mode === 'update' ? $setting->name : null }}</small></h1>
</div>

<!--form method="post" action="" autocomplete="off"-->
{!! Form::model($setting,
	[
		'route' => ($mode == 'create') ? 'admin.settings.create' : ['admin.settings.update', $setting->id]
	])
!!}


	<div class="form-group{{ $errors->first('category_id', ' has-error') }}">
		<label for="category_id">Category</label>
		{!! Form::select('group', $groups, Input::get('group') ? Input::get('group') : Input::old('group', @$row->group),['class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('group', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('name', ' has-error') }}">
		{!! Form::label('name', 'Name'); !!}
		{!! Form::text('name',Input::old('name', $setting->name),[
			'placeholder'=>'Enter the Setting Name.',
			'name'=>'name',
			'id'=>'name',
			'class' => 'form-control']); !!}
		<span class="help-block">{{{ $errors->first('name', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('slug', ' has-error') }}">
		{!! Form::label('slug', 'Slug'); !!}
		{!! Form::text('slug',Input::old('slug', $setting->slug),[
			'placeholder'=>'Enter the Setting Slug.',
			'name'=>'slug',
			'id'=>'slug',
			'readonly'=>true,
			'class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('slug', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('input_type', ' has-error') }}">
		{!! Form::label('input_type', 'Input Type'); !!}
		{!! Form::select('input_type', ['text' => 'Text','textarea' => 'Textarea', 'boolean' => 'Boolean'], 1, ['name'=>'input_type',
			'id'=>'input_type','class' => 'form-control']) !!}
		<span class="help-block">{{{ $errors->first('input_type', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('value', ' has-error') }}">
		{!! Form::label('value', 'Value'); !!}
		{!! Form::text('value',Input::old('value', $setting->value),[
			'placeholder'=>'Enter the Setting Value.',
			'name'=>'value',
			'id'=>'value',
			'class' => 'form-control']); !!}
		<span class="help-block">{{{ $errors->first('value', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('description', ' has-error') }}">
		{!! Form::label('description', 'Description'); !!}
		{!! Form::textarea('description',Input::old('description', $setting->description),[
			'placeholder'=>'Enter the Setting Description.',
			'name'=>'description',
			'id'=>'description',
			'class' => 'form-control',
			'rows' => '4'
		]); !!}
		<span class="help-block">{{{ $errors->first('description', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('help_text', ' has-error') }}">
		{!! Form::label('help_text', 'Help Text'); !!}
		{!! Form::textarea('help_text',Input::old('help_text', $setting->help_text),[
			'placeholder'=>'Enter the Setting Help Text.',
			'name'=>'help_text',
			'id'=>'help_text',
			'class' => 'form-control',
			'rows' => '1'
		]); !!}
		<span class="help-block">{{{ $errors->first('help_text', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('editable', ' has-error') }}">
		{!! Form::label('editable', 'Editable'); !!}
		{!! Form::select('editable', [1 => 'Yes', 0 => 'No'], 1, ['name'=>'editable',
			'id'=>'editable','class' => 'form-control']) !!}
		<span class="help-block">{{{ $errors->first('editable', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('status', ' has-error') }}">
		{!! Form::label('status', 'Status'); !!}
		{!! Form::select('status', [1 => 'Enable', 0 => 'Disabled'], 1, ['name'=>'status',
			'id'=>'status','class' => 'form-control']) !!}
		<span class="help-block">{{{ $errors->first('status', ':message') }}}</span>
	</div>

	<button type="submit" class="btn btn-default">Submit</button>
{!! Form::close() !!}

@stop
