@extends('Auth::layouts.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>{{ $mode == 'create' ? 'Create Page' : 'Update Page' }} <small>{{ $mode === 'update' ? $row->name : null }}</small></h1>
</div>
<!--form method="post" action="" autocomplete="off"-->
{!! Form::open([
    'route' => ($mode == 'create') ? 'admin.pages.create' : ['admin.pages.update', $row->id]
]) !!}

	<div class="form-group{{ $errors->first('name', ' has-error') }}">
		<label for="name">Name</label>
		<input type="text" class="form-control" name="name" id="name" value="{{ Input::old('name', $row->name) }}" placeholder="Enter the page name.">
		<span class="help-block">{{{ $errors->first('name', ':message') }}}</span>
	</div>
	
	<div class="form-group{{ $errors->first('slug', ' has-error') }}">
	{!! Form::label('slug', 'Slug'); !!}
		{!! Form::text('slug',Input::old('slug', $row->slug),[
			'placeholder'=>'Enter the Task Slug.',
			'name'=>'slug',
			'id'=>'slug',
			'readonly'=>true,
			'class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('slug', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('menu_id', ' has-error') }}">
		<label for="menu_id">Menus</label>		
		{!! Form::select('menu_id', $menus, Input::get('menu_id') ? Input::get('menu_id') : Input::old('menu_id', @$row->menu_id),['class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('menu_id', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('description', ' has-error') }}">
		<label for="description">Description</label>
		<textarea class="form-control" name="description" id="description" placeholder="Enter the page description.">{{ Input::old('description', $row->description) }}</textarea>
		<span class="help-block">{{{ $errors->first('description', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('status', ' has-error') }}">
		<label for="status">Status</label>
		<select id="status" class="form-control input-sm" name="status">
			<option value=""></option>
			@foreach (config('setting.status') as $config => $val)
				<option value="{{ Input::old('status', $row->status) }}" {{ $val == $row->status ? 'selected="selected"' : '' }}>{{$config}}</option>
			@endforeach
		</select>
	</div>	

	<button type="submit" class="btn btn-default">Submit</button>
{!! Form::close() !!}

@stop
