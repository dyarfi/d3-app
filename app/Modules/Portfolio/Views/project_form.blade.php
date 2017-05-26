@extends('Auth::layouts.template')

{{-- Project content --}}
@section('body')

<div class="page-header">
	<h1>{{ $mode == 'create' ? 'Create Project' : 'Update Project' }} <small>{{ $mode === 'update' ? $row->name : null }}</small></h1>
</div>
<!--form method="post" action="" autocomplete="off"-->
{!! Form::open([
    'route' => ($mode == 'create') ? 'admin.projects.create' : ['admin.projects.update', $row->id]
]) !!}

	<div class="form-group{{ $errors->first('name', ' has-error') }}">
		<label for="name">Name</label>
		<input type="text" class="form-control" name="name" id="name" value="{{ Input::old('name', $row->name) }}" placeholder="Enter the page name.">
		<span class="help-block">{{{ $errors->first('name', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('slug', ' has-error') }}">
	{!! Form::label('slug', 'Slug'); !!}
		{!! Form::text('slug',Input::old('slug', $row->slug),[
			'placeholder'=>'Enter the Project Slug.',
			'name'=>'slug',
			'id'=>'slug',
			'readonly'=>true,
			'class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('slug', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('client_id', ' has-error') }}">
		<label for="client_id">Clients</label>
		{!! Form::select('client_id', $clients, Input::get('client_id') ? Input::get('client_id') : Input::old('client_id', @$row->client_id),['class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('client_id', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('description', ' has-error') }}">
		<label for="description">Description</label>
		<textarea class="form-control" name="description" id="description" placeholder="Enter the project description.">{{ Input::old('description', $row->description) }}</textarea>
		<span class="help-block">{{{ $errors->first('description', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('status', ' has-error') }}">
		<label for="status">Status</label>
		<select id="status" class="form-control input-sm" name="status">
			<option value=""></option>
			@foreach (config('setting.status') as $config => $val)
				<option value="{{ $val ? $val : Input::old('status', $row->status) }}" {{ $val == $row->status ? 'selected="selected"' : '' }}>{{$config}}</option>
			@endforeach
		</select>
	</div>

	<button type="submit" class="btn btn-default">Submit</button>
{!! Form::close() !!}

@stop
