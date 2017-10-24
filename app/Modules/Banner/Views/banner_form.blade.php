@extends('Admin::layouts.template')

@section('body')

<div class="page-header">
	<h1>{{ $mode == 'create' ? 'Create Banner' : 'Update Banner' }} <small>{{ $mode === 'update' ? $row->name : null }}</small></h1>
</div>

{!! Form::model($row,
	[
		'route' => ($mode == 'create') ? 'admin.banners.create' : ['admin.banners.update', $row->id],
		'files' => true,
		'autocomplete' => 'off'
	])
!!}

<div class="form-group{{ $errors->first('name', ' has-error') }}">
	{!! Form::label('name', 'Name'); !!}
	{!! Form::text('title',Input::old('name', $row->name),[
		'placeholder'=>'Enter the Banner name.',
		'name'=>'name',
		'id'=>'name',
		'class' => 'form-control']); !!}
	<span class="help-block">{{{ $errors->first('name', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('slug', ' has-error') }}">
	{!! Form::label('slug', 'Slug'); !!}
	{!! Form::text('slug',Input::old('slug', $row->slug),[
		'placeholder'=>'Enter the Banner Slug.',
		'name'=>'slug',
		'id'=>'slug',
		'readonly'=>true,
		'class'=>'form-control']); !!}
	<span class="help-block">{{{ $errors->first('slug', ':message') }}}</span>
</div>
<?php
/*
<div class="form-group{{ $errors->first('division_id', 'has-error') }}">
	{!! Form::label('division_id', 'Division',['class' => 'control-label center-block']) !!}
	{!! Form::select('division_id', $divisions, Input::get('division_id') ? Input::get('division_id') : Input::old('division_id', $row->division_id)) !!}
	<span class="help-block">{{{ $errors->first('division_id', ':message') }}}</span>
</div>
*/
?>
<div class="form-group{{ $errors->first('description', ' has-error') }}">
	{!! Form::label('description', 'Description'); !!}
	{!! Form::textarea('description',Input::old('description', $row->description),[
		'placeholder'=>'Enter the Banner Description.',
		'name'=>'description',
		'id'=>'ckeditor',
		'class' => 'form-control',
		'rows' => '4'
	]); !!}
	<span class="help-block">{{{ $errors->first('description', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('end_date', ' has-error') }}">
	<div class="row">
		<div class="col-xs-6">
			{!! Form::label('end_date', 'End Date'); !!}
			<div class="input-group input-group-sm">
				{!! Form::text('slug',Input::old('end_date', $row->end_date),[
					'placeholder'=>'Enter the Banner End Date.',
					'name'=>'end_date',
					'id'=>'datepicker',
					'data-date-format'=>'yyyy-mm-dd',
					'placeholder'=>'yyyy-mm-dd',
					'class'=>'form-control date-picker']); !!}
				<span class="input-group-addon">
					<i class="ace-icon fa fa-calendar"></i>
				</span>
			</div>
		</div>
	</div>
	<span class="help-block">{{{ $errors->first('end_date', ':message') }}}</span>
</div>

{{-- @if ($errors->has('image')) --}}
{{-- {{ dd($errors) }} --}}
	{{-- @foreach ($errors->get('image') as $_errors => $_message) --}}
	    {{-- {{ dd($_message) }} --}}
	{{-- @endforeach --}}
{{-- @endif --}}

<div class="form-group{{ $errors->first('image', ' has-error') }}">
	@if ($row->image)
		<img src="{{ asset('uploads/'.$row->image) }}" alt="{{ $row->image }}" class="image-alt img-thumbnail" style="width:300px"/>
	@endif
	<div class="row">
		<div class="col-xs-6">
			{!! Form::label('image', ($row->image) ? 'Replace Image:' : 'Image:', ['class' => '']) !!}
			<label class="ace-file-input">
				{!! Form::file('image','',['class'=>'form-controls','id'=>'id-input-file-2']) !!}
				<span class="ace-file-container" data-title="Choose">
					<span class="ace-file-name" data-title="No File ...">
						<i class=" ace-icon fa fa-upload"></i>
					</span>
				</span>
			</label>
			<span class="help-block">{{{ $errors->first('image', ':message') }}}</span>
		</div>
	</div>
</div>

<div class="form-group{{ $errors->first('index', ' has-error') }}">
	{!! Form::label('index', 'Index'); !!}
	{!! Form::text('index',($row->index ? Input::old('index', $row->index) : $model->max('index') + 1),[
		'placeholder'=>'Enter the Portfolio Index.',
		'name'=>'index',
		'id'=>'index',
		'class'=>'form-control']); !!}
	<span class="help-block">{{{ $errors->first('index', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('status', ' has-error') }}">
	<label for="status">Status</label>
	<select id="status" name="status" class="form-control input-sm">
		<option value="">&nbsp;</option>
		@foreach (config('setting.status') as $config => $val)
			<option value="{{ $config ? $config : Input::old('status', $row->status) }}" {{ ($config == 1 || $config == $row->status) ? 'selected' : '' }}>{{$val}}</option>
		@endforeach
	</select>
</div>

{!! Form::submit(ucfirst($mode).' Banner', ['class' => 'btn btn-primary btn-xs']) !!}

{!! Form::close() !!}

@stop
