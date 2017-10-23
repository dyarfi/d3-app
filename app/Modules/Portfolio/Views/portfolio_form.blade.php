@extends('Admin::layouts.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>{{ $mode == 'create' ? 'Create Portfolio' : 'Update Portfolio' }} <small>{{ $mode === 'update' ? $row->name : null }}</small></h1>
</div>

{!! Form::open([
    'route' => ($mode == 'create') ? 'admin.portfolios.create' : ['admin.portfolios.update', $row->id],
	'files' => true
]) !!}

	<div class="form-group{{ $errors->first('name', ' has-error') }}">
		{!! Form::label('name', 'Name'); !!}
		{!! Form::text('name',Input::old('name', $row->name),[
			'placeholder'=>'Enter the Portfolio Name.',
			'name'=>'name',
			'id'=>'name',
			'class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('name', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('client_id', ' has-error') }}">
		<label for="client_id">Clients</label>
		{!! Form::select('client_id', $clients, Input::get('client_id') ? Input::get('client_id') : Input::old('client_id', @$row->client_id),['class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('client_id', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('project_id', ' has-error') }}">
		<label for="project_id">Projects</label>
		{!! Form::select('project_id', $projects, Input::get('project_id') ? Input::get('project_id') : Input::old('project_id', @$row->project_id),['class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('project_id', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('description', ' has-error') }}">
		{!! Form::label('description', 'Description'); !!}
		{!! Form::textarea('description',Input::old('description', $row->description),[
			'placeholder'=>'Enter the Portfolio Description.',
			'name'=>'description',
			'id'=>'description',
			'class'=>'form-control ckeditor']); !!}
		<span class="help-block">{{{ $errors->first('description', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('image', ' has-error') }}">
		{!! Form::label('image', 'Portfolio Image:'); !!}
		@if ($row->image)
			{!! Form::label('image', ($row->image) ? 'Replace Image ?' : 'Portfolio Image:', ['class' => 'control-label center-block ace-file-input']) !!}
			<img src="{{ asset('uploads/'.$row->image) }}" alt="{{ $row->image }}" class="image-alt" style="max-width:300px"/>
			<div class="clearfix space-6"></div>
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

	<div class="form-group">
		<label class="control-label" for="form-field-tags">Tag</label>
		<div class="inline">
			<?php
			$tagged = '';
			foreach ($tags as $tag) {
				$tagged[] = $tag->name;
			}
			?>
			<input type="text" name="tags" data-rel="{{ route('admin.portfolios.tags') }}" id="form-field-tags" value="{{ ($tagged) ? implode(', ', $tagged) : '' }}" placeholder="Enter tags ..." />
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
				<option value="{{ $config ? $config : Input::old('status', $row->status) }}" {{ $config == $row->status ? 'selected' : '' }}>{{$val}}</option>
			@endforeach
		</select>
		<span class="help-block">{{{ $errors->first('status', ':message') }}}</span>
	</div>

	<button type="submit" class="btn btn-default">Submit</button>
{!! Form::close() !!}

@stop
