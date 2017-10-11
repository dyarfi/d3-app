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

	<div class="form-group{{ $errors->first('description', ' has-error') }}">
		{!! Form::label('description', 'Description'); !!}
		{!! Form::textarea('description',Input::old('description', $row->description),[
			'placeholder'=>'Enter the description Team.',
			'name'=>'description',
			'id'=>'description',
			'class' => 'form-control ckeditor',
			'rows' => '4'
		]); !!}
		<span class="help-block">{{{ $errors->first('description', ':message') }}}</span>
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
	
	<button type="submit" class="btn btn-default">Submit</button>

{!! Form::close() !!}

@stop
