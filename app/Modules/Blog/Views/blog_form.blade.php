@extends('Auth::layouts.template')

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

	<div class="form-group{{ $errors->first('category_id', ' has-error') }}">
		<label for="category_id">Category</label>
		{!! Form::select('category_id', $categories, Input::get('category_id') ? Input::get('category_id') : Input::old('category_id', @$row->category_id),['class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('category_id', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('description', ' has-error') }}">
		{!! Form::label('description', 'Description'); !!}
		{!! Form::textarea('description',Input::old('description', $row->description),[
			'placeholder'=>'Enter the Portfolio Description.',
			'name'=>'description',
			'id'=>'description',
			'class'=>'form-control']); !!}
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
				<option value="{{ $val ? $val : Input::old('status', $row->status) }}" {{ $val == $row->status ? 'selected' : '' }}>{{$config}}</option>
			@endforeach
		</select>
	</div>

	<button type="submit" class="btn btn-default">Submit</button>
{!! Form::close() !!}

@stop
