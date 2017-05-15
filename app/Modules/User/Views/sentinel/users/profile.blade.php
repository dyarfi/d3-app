@extends('Auth::layouts.template')

@section('body')

<h1 class="green">Profile <small>{{ $row->email }}</small></h1>
<hr>
<div class="row-fluid">
	<div class="row-fluid">
		{!! Form::open([
			'method' => 'POST',
	       	'route' => ['admin.users.edit', $row->id],
	       	'files' => true,
	       	'class' =>'form-horizontal'
		]) !!}

			{!! Form::hidden('_private', base64_encode(csrf_token() .'::'. $row->email .'::'. $row->roles()->first()->id) ) !!}	

			<div class="form-group">
				<div class="col-md-12">	
					<p class="lead"><span class="fa fa-pencil-square-o"></span> Joined : {{ $row->created_at }}</p>
					@if (count($row->email) === 1)
				    	<p class="lead"><span class="fa fa-envelope-o"></span> Email : {{ $row->email }}</p>
					@else
					    You don't have an email!
					@endif 

					@if (count($row->provider) === 1)
				    	<p class="lead"><span class="fa fa-check-square-o"></span> Register with : {{ $row->provider }}</p>
					@else
					    You don't have any providers!
					@endif 
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12{{ $errors->first('username', ' has-error') }}">		
				    {!! Form::label('username', 'Username:', ['class' => 'control-label']) !!}
				    {!! Form::text('username', $row->username, ['class' => 'form-control']) !!}
				    <span class="help-block red">{{{ $errors->first('username', ':message') }}}</span>
				</div>
				<div class="col-md-6{{ $errors->first('first_name', ' has-error') }}">
				    {!! Form::label('first_name', 'First Name:', ['class' => 'control-label']) !!}
				    {!! Form::text('first_name', $row->first_name, ['class' => 'form-control']) !!}
				    <span class="help-block red">{{{ $errors->first('first_name', ':message') }}}</span>
				</div>
				<div class="col-md-6{{ $errors->first('last_name', ' has-error') }}">
					{!! Form::label('last_name', 'Last Name:', ['class' => 'control-label']) !!}
				    {!! Form::text('last_name', $row->last_name, ['class' => 'form-control']) !!}			
				    <span class="help-block red">{{{ $errors->first('last_name', ':message') }}}</span>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12{{ $errors->first('about', ' has-error') }}">
				    {!! Form::label('about', 'About:', ['class' => 'control-label']) !!}
				    {!! Form::textarea('about', $row->about, ['class' => 'form-control']) !!}
				    <span class="help-block red">{{{ $errors->first('about', ':message') }}}</span>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12{{ $errors->first('avatar', ' has-error') }}">
				    {!! Form::label('avatar', 'Avatar:', ['class' => 'control-label']) !!}
				    {!! Form::text('avatar', $row->avatar, ['class' => 'form-control']) !!}		
				    <span class="help-block red">{{{ $errors->first('avatar', ':message') }}}</span>
				</div>
			</div>

			<div class="space-6"></div>

			<div class="form-group">	
				<div class="col-md-12{{ $errors->first('image', ' has-error') }}">
					{!! Form::label('image', ($row->image) ? 'Replace Profile Image:' : 'Profile Image:',['class'=>'center-block']); !!}
					@if ($row->image)

						<img src="{{ asset('uploads/'.$row->image) }}" alt="{{ $row->image }}" class="image-alt" style="max-width:300px" id="demo3"/>
						<div class="clearfix space-6"></div>

						<!-- This is the form that our event handler fills -->
						<div id="image-crop-holder">
							<input type="hidden" id="crop_x" name="x" value="{{ $row->attributes->crop_x }}"/>
							<input type="hidden" id="crop_y" name="y" value="{{ $row->attributes->crop_y }}"/>
							<input type="hidden" id="crop_w" name="w" value="{{ $row->attributes->crop_w }}"/>
							<input type="hidden" id="crop_h" name="h" value="{{ $row->attributes->crop_h }}"/>
							<input type="hidden" id="image" name="image" value="{{ $row->image }}"/>
							<input type="hidden" id="path" name="path" value="{{ public_path() . '/uploads' }}"/>
							<input type="submit" id="demo3_form" value="Crop Image" class="btn btn-large green"/>
							<div id="preview-pane">
								<div class="preview-container">
									<img src="{{ asset('uploads/'.$row->image) }}" class="jcrop-preview" alt="Preview" width="120"/>
								</div>
							</div>
						</div>

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
			</div>

			<div class="clearfix space-6"></div>			

			@if(config('setting.attributes') && $row->attributes)
			<div class="form-group">
				<div class="col-md-12">
				<span class="clearfix">Skins:</span>
				@foreach (config('setting.attributes') as $setting => $attribute)
					@if ($setting == 'skins')
						@foreach ($attribute as $attr => $val)	
							<div class="col-md-2">
								<div class="pull-left" style="background-color:{{ $attr }}">
									{!! Form::label('attributes[skins]', $attr, ['class' => 'control-label white']) !!}									
									{!! Form::radio('attributes[skins]', $attr, ($row->attributes->skins === $attr ? true : false)) !!}		
								</div>						
							</div>
						@endforeach
					@endif
				@endforeach
				</div>
			</div>
			@endif
			
			<div class="clearfix space-6"></div>

			<div class="form-group">
				<div class="col-md-12">
				{!! Form::submit('Update Profile', ['class' => 'btn btn-primary btn-xs']) !!}
				</div>
			</div>
			
		{!! Form::close() !!}
		
	</div>
</div>

@stop