@extends('Admin::layouts.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>{{ $mode == 'create' ? 'Create Portfolio' : 'Update Portfolio' }} <small>{{ $mode === 'update' ? $row->name : null }}</small></h1>
</div>

{!! Form::open([
    'route' => ($mode == 'create') ? 'admin.portfolios.create' : ['admin.portfolios.update', $row->id],
	'files' => true,
	'id'	=> 'portfolio'
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
				<label class="ace-file-input ace-file-single">
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

	{{-- <div class="form-group{{ $errors->first('image', ' has-error') }}"> --}}
	<div class="form-group">
		<label class="control-label" for="id-input-file-3">Gallery :</label>
		<label class="ace-file-input ace-file-multiple">
			<input multiple="" id="id-input-file-3" type="file" name="gallery[]">
			<a class="remove" href="#"><i class=" ace-icon fa fa-times"></i>&nbsp;</a>			
		</label>
		<div>
			@if(sizeof($row->media) > 0)
				@foreach ($row->media as $media)
					<span class="img-thumbnail"><img src="{{ url($media->getDiskPath()) }}" class="img-responsive"/></span>
				@endforeach
			@endif
		</div>
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

@push('scripts')
<script type="text/javascript">
$(document).ready(function(){
		var $form = $('#portfolio');
		var file_input = $form.find('#id-input-file-3');
		file_input.ace_file_input({
			style:'well',
			btn_choose:'Choose Images',
			btn_change:null,
			no_icon:'ace-icon fa fa-cloud-upload',
			droppable:false,
			thumbnail:'small',//large | fit
			maxSize:{!! config("mediable.max_size") !!},//bytes
			//allowExt:["jpeg", "jpg", "png", "gif"],
			allowExt:['{!! implode("','",config("mediable.allowed_extensions")) !!}'], 
			allowMime:['{!! implode("','",config("mediable.allowed_mime_types")) !!}'],
			//,icon_remove:null//set null, to hide remove/reset button
			/**,before_change:function(files, dropped) {
				//Check an example below
				//or examples/file-upload.html
				return true;
			}*/
			/**,before_remove : function() {
				return true;
			}*/
			//,
			preview_error : function(filename, error_code) {
				//name of the file that failed
				//error_code values
				//1 = 'FILE_LOAD_FAILED',
				//2 = 'IMAGE_LOAD_FAILED',
				//3 = 'THUMBNAIL_FAILED'
				//alert(error_code);
			}
	
		}).on('change', function(){
			//console.log($(this).data('ace_input_files'));
			//console.log($(this).data('ace_input_method'));
					var files = $(this).data('ace_input_files');
					if( !files || files.length == 0 ) return false;//no files selected
										
					var deferred ;
					if( "FormData" in window ) {
						//for modern browsers that support FormData and uploading files via ajax
						//we can do >>> var formData_object = new FormData($form[0]);
						//but IE10 has a problem with that and throws an exception
						//and also browser adds and uploads all selected files, not the filtered ones.
						//and drag&dropped files won't be uploaded as well
						
						//so we change it to the following to upload only our filtered files
						//and to bypass IE10's error
						//and to include drag&dropped files as well
						formData_object = new FormData();//create empty FormData object
						
						//serialize our form (which excludes file inputs)
						$.each($form.serializeArray(), function(i, item) {
							//add them one by one to our FormData 
							formData_object.append(item.name, item.value);							
						});

						//and then add files
						file_input.each(function(){
							var field_name = $(this).attr('name');
							//for fields with "multiple" file support, field name should be something like `myfile[]`

							var files = file_input.data('ace_input_files');
							if(files && files.length > 0) {
								for(var f = 0; f < files.length; f++) {
									formData_object.append(field_name, files[f]);
								}
							}
						});
	

						//upload_in_progress = true;
						//file_input.ace_file_input('loading', true);
						
						// deferred = $.ajax({
							        // url: $form.attr('action'),
							       // type: $form.attr('method'),
							// processData: false,//important
							// contentType: false,//important
							   // dataType: 'json',
							       // data: formData_object
							/**
							,
							xhr: function() {
								var req = $.ajaxSettings.xhr();
								if (req && req.upload) {
									req.upload.addEventListener('progress', function(e) {
										if(e.lengthComputable) {	
											var done = e.loaded || e.position, total = e.total || e.totalSize;
											var percent = parseInt((done/total)*100) + '%';
											//percentage of uploaded file
										}
									}, false);
								}
								return req;
							},
							beforeSend : function() {
							},
							success : function() {
							}*/
						// });

					}

		}).on('file.error.ace', function(ev, info) {
			if(info.error_count['ext'] || info.error_count['mime']) alert('Invalid file type! Please select an image!');
			if(info.error_count['size']) alert('Invalid file size! Maximum {!! config("mediable.max_size") !!}KB');			
			//you can reset previous selection on error
			//ev.preventDefault();
			//file_input.ace_file_input('reset_input');
		});		
		
		//$('#id-input-file-3')
		//.ace_file_input('show_file_list', [
			//{type: 'image', name: 'name of image', path: 'http://path/to/image/for/preview'},
			//{type: 'file', name: 'hello.txt'}
		//]);

	//var files = file_input.data('ace_input_files');
	//console.log(files);
		
});
</script>
@endpush


@stop
