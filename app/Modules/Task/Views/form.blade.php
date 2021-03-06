@extends('Admin::layouts.template')

@section('body')

<div class="page-header">
	<h1>{{ $mode == 'create' ? 'Create Task' : 'Update Task' }} <small>{{ $mode === 'update' ? $row->name : null }}</small></h1>
</div>

<!--form method="post" action="" autocomplete="off"-->
{!! Form::model($row,
	[
		'route' => ($mode == 'create') ? 'admin.tasks.create' : ['admin.tasks.update', $row->id],
		'files' => true
	])
!!}

<div class="form-group{{ $errors->first('title', ' has-error') }}">
	{!! Form::label('title', 'Title'); !!}
	{!! Form::text('title',Input::old('title', $row->title),[
		'placeholder'=>'Enter the Task title.',
		'name'=>'title',
		'id'=>'title',
		'class' => 'form-control']); !!}
	<span class="help-block">{{{ $errors->first('title', ':message') }}}</span>
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

<div class="form-group{{ $errors->first('description', ' has-error') }}">
	{!! Form::label('description', 'Description'); !!}
	{!! Form::textarea('description',Input::old('description', $row->description),[
		'placeholder'=>'Enter the Task Description.',
		'name'=>'description',
		'id'=>'description',
		'class' => 'form-control ckeditor',
		'rows' => '4'
	]); !!}
	<span class="help-block">{{{ $errors->first('description', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('image', ' has-error') }}">
	{!! Form::label('image', 'Image:'); !!}
	@if ($row->image)
		{!! Form::label('image', ($row->image) ? 'Replace Image:' : 'Profile Image:', ['class' => 'control-label center-block ace-file-input']) !!}
		<img src="{{ asset('uploads/'.$row->image) }}" alt="{{ $row->image }}" class="image-alt" style="width:300px"/>
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

{!! Form::submit(ucfirst($mode).' Task', ['class' => 'btn btn-primary btn-xs']) !!}

{!! Form::close() !!}

@stop
