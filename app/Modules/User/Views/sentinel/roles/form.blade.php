@extends('Admin::layouts.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>{{ $mode == 'create' ? 'Create Role' : 'Update Role' }} <small>{{ $mode === 'update' ? $row->name : null }}</small></h1>
</div>

{!! Form::open([
    'route' => ($mode == 'create') ? 'admin.roles.create' : ['admin.roles.update', $row->id]
]) !!}

	<div class="form-group{{ $errors->first('name', ' has-error') }}">
		{!! Form::label('name', 'Name'); !!}
		{!! Form::text('name',Input::old('name', $row->name),[
			'placeholder'=>'Enter the Role Name.',
			'name'=>'name',
			'id'=>'name',
			'class' => 'form-control']); !!}
		<span class="help-block">{{{ $errors->first('name', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('slug', ' has-error') }}">
		{!! Form::label('slug', 'Slug'); !!}
		{!! Form::text('slug',Input::old('slug', $row->slug),[
		'placeholder'=>'Enter the Role Slug.',
		'name'=>'slug',
		'id'=>'slug',
		'readonly'=>true,
		'class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('slug', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('permissions', ' has-error') }}">
		{!! Form::label('', 'Permissions'); !!}
		<div class="form-group">
			<div class="clearfix">
				<span class="col-md-2">
					{!! Form::radio('permissions', 'true', ($mode == 'create') ? 'false' : (isset($row->permissions['admin']) && $row->permissions['admin'] === true ? true : false)); !!}
					{!! Form::label('', 'Admin Access',['class'=>'text-success']); !!}
				</span>
				<span class="col-md-2">
					{!! Form::radio('permissions', 'false', ($mode == 'create') ? true : (isset($row->permissions['admin']) && $row->permissions['admin'] === false ? true : false)); !!}
					{!! Form::label('', 'No Admin Access',['class'=>'text-danger']); !!}
				</span>
			</div>
		</div>	
		<div class="form-group">
			@if($row->permissions)
			<div class="col-md-8">
			@foreach ($row->permissions as $permission => $val)
				@if(Sentinel::hasAccess('admin') && $permission == 'admin')
					{!! Form::checkbox('permission[]', $val, $val ? true : false, ['disabled']) !!}
				@else			
					{!! Form::checkbox('permission[]', $val, $val ? true : false) !!}	
				@endif
				{!! Form::label('permission[]', ucfirst($permission)) !!}
			@endforeach
			</div>
			@endif
			<span class="label label-info"><span class="fa fa-key"></span> {!! link_to_route('admin.permissions.edit', 'Access Permission', ['id'=>$row->id,'access=role'], ['class'=>'white']) !!}</span>
			<span class="help-block">{{{ $errors->first('permissions', ':message') }}}</span>
		</div>
	</div>
	
	<button type="submit" class="btn btn-default">Submit</button>

{!! Form::close() !!}

@stop
