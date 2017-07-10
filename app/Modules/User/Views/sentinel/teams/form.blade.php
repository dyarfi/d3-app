``@extends('Auth::layouts.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>{{ $mode == 'create' ? 'Create Team' : 'Update Team' }} <small>{{ $mode === 'update' ? $row->name : null }}</small></h1>
</div>

{!! Form::open([
    'route' => ($mode == 'create') ? 'admin.teams.create' : ['admin.teams.update', $row->id]
]) !!}

	<div class="form-group{{ $errors->first('name', ' has-error') }}">
		{!! Form::label('name', 'Name'); !!}
		{!! Form::text('name',Input::old('name', $row->name),[
			'placeholder'=>'Enter the Team Name.',
			'name'=>'name',
			'id'=>'name',
			'class' => 'form-control']); !!}
		<span class="help-block">{{{ $errors->first('name', ':message') }}}</span>
	</div>

	<button type="submit" class="btn btn-default">Submit</button>

{!! Form::close() !!}

@stop
