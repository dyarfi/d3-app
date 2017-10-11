@extends('Auth::layouts.template')

@section('body')

<div class="page-header">
	<h1>{{ $mode == 'create' ? 'Create Career' : 'Update Career' }} <small>{{ $mode === 'update' ? $row->name : null }}</small></h1>
</div>

{!! Form::model($row,
	[
		'route' => ($mode == 'create') ? 'admin.careers.create' : ['admin.careers.update', $row->id],
		'files' => true,
		'autocomplete' => 'off'
	])
!!}

<div class="form-group{{ $errors->first('name', ' has-error') }}">
	{!! Form::label('name', 'Name'); !!}
	{!! Form::text('title',Input::old('name', $row->name),[
		'placeholder'=>'Enter the Career name.',
		'name'=>'name',
		'id'=>'name',
		'class' => 'form-control']); !!}
	<span class="help-block">{{{ $errors->first('name', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('slug', ' has-error') }}">
	{!! Form::label('slug', 'Slug'); !!}
	{!! Form::text('slug',Input::old('slug', $row->slug),[
		'placeholder'=>'Enter the Career Slug.',
		'name'=>'slug',
		'id'=>'slug',
		'readonly'=>true,
		'class'=>'form-control']); !!}
	<span class="help-block">{{{ $errors->first('slug', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('division_id', 'has-error') }}">
	{!! Form::label('division_id', 'Division',['class' => 'control-label center-block']) !!}
	{!! Form::select('division_id', $divisions, Input::get('division_id') ? Input::get('division_id') : Input::old('division_id', $row->division_id)) !!}
	<span class="help-block">{{{ $errors->first('division_id', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('description', ' has-error') }}">
	{!! Form::label('description', 'Description'); !!}
	{!! Form::textarea('description',Input::old('description', $row->description),[
		'placeholder'=>'Enter the Career Description.',
		'name'=>'description',
		'id'=>'description',
		'class' => 'form-control ckeditor',
		'rows' => '4'
	]); !!}
	<span class="help-block">{{{ $errors->first('description', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('requirement', ' has-error') }}">
	{!! Form::label('requirement', 'Requirement'); !!}
	{!! Form::textarea('requirement',Input::old('requirement', $row->requirement),[
		'placeholder'=>'Enter the Career Requirement.',
		'name'=>'requirement',
		'id'=>'ckeditor',
		'class' => 'form-control',
		'rows' => '4'
	]); !!}
	<span class="help-block">{{{ $errors->first('requirement', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('responsibility', ' has-error') }}">
	{!! Form::label('responsibility', 'Responsibility'); !!}
	{!! Form::textarea('responsibility',Input::old('responsibility', $row->responsibility),[
		'placeholder'=>'Enter the Career Responsibility.',
		'name'=>'responsibility',
		'id'=>'ckeditor',
		'class' => 'form-control',
		'rows' => '4'
	]); !!}
	<span class="help-block">{{{ $errors->first('responsibility', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('facility', ' has-error') }}">
	{!! Form::label('facility', 'Facility'); !!}
	{!! Form::textarea('facility',Input::old('facility', $row->facility),[
		'placeholder'=>'Enter the Career Facility.',
		'name'=>'facility',
		'id'=>'ckeditor',
		'class' => 'form-control',
		'rows' => '4'
	]); !!}
	<span class="help-block">{{{ $errors->first('facility', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('end_date', ' has-error') }}">
	<div class="row">
		<div class="col-xs-6">
			{!! Form::label('end_date', 'End Date'); !!}
			<div class="input-group input-group-sm">
				{!! Form::text('slug',Input::old('end_date', $row->end_date),[
					'placeholder'=>'Enter the Career End Date.',
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

<div class="form-group">
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
		</div>
	</div>
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

{!! Form::submit(ucfirst($mode).' New Career', ['class' => 'btn btn-primary btn-xs']) !!}

{!! Form::close() !!}

@stop
