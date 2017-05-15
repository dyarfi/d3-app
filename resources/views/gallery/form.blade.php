@extends('layouts.master')

@section('content')
<div class="page-header">
	<div class="pull-left"><a href="{{ route('gallery') }}"><span class="fa fa-chevron-left"></span> Back</a></div>
	<h1>Upload</h1>
	<p class="lead">Welcome to our {{ @$menu->description }}<br/></p>
</div>
<div class="container">
	<p>Lorem Ipsum</p>
	<hr/>
</div>
@if(!Auth::user())
<div class="container-fluid">
	<h4>Sign In to upload</h4>
	<div class="form-horizontal">
		{!! Form::open(['route' => 'login.post','method'=>'POST']) !!}
			<div class="form-group{{ $errors->first('email', ' has-error') }}">
				{!! Form::label('email', 'Email',['class'=>'col-md-4 control-label']) !!}
				<div class="col-md-6">
				 	{!! Form::text('email',Input::old('email', ''),[
						'placeholder'=>'Email',
						'name'=>'email',
						'id'=>'email',
						'class' => 'email form-control']) !!}
				</div>
			</div>
			<div class="form-group">				
				{!! Form::label('password', 'Password',['class'=>'col-md-4 control-label']) !!}
				<div class="col-md-6">
					{!! Form::password('password',[
						'placeholder'=>'Password',
						'name'=>'password',
						'id'=>'password',
						'class' => 'password form-control']); !!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6 col-md-offset-4">
					<div class="checkbox">
						<label for="remember">
							{!! Form::checkbox('remember', ''); !!} Remember Me
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6 col-md-offset-4">
					{!! Form::button('Submit',['type'=>'submit', 'class'=>'btn btn-primary']); !!}
					<a class="btn btn-link" href="{{ url('/auth/password/email') }}">Forgot Your Password?</a>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
	<hr class="clear"/>
	<h4>Social Sign In</h4>	
	<div class="form-group">
		<div class="col-lg-12 col-md-12 col-xs-12">
			<a href="{{ url('auth/social/twitter') }}" title="Login with Twitter" class="btn btn-info btn-md"><span class="fa fa-twitter"></span>&nbsp; Login with Twitter</a>
			<a href="{{ url('auth/social/facebook') }}" title="Login with Facebook" class="btn btn-primary btn-md"><span class="fa fa-facebook"></span>&nbsp; Login with Facebook</a>
			<a href="{{ url('auth/social/linkedin') }}" title="Login with Linkedin" class="btn btn-success btn-md"><span class="fa fa-linkedin"></span>&nbsp; Login with LinkedIn</a>
			<a href="{{ url('auth/social/google') }}" title="Login with Google" class="btn btn-warning btn-md"><span class="fa fa-google-plus"></span>&nbsp; Login with Google</a>
		</div>
	</div>
</div>
@else
<div style="margin:30px auto"></div>
	<div class="center-block clearfix main-handler">      
	      <div class="row menu item-handler" style="display:none">     



					<div align="center" style="min-height: 32px;">
		    			<div class="clearfix">
							<div class="btn-group inline pull-left" id="texteditor" style="display:block">						  
								<button id="font-family" class="btn dropdown-toggle" data-toggle="dropdown" title="Font Style"><i class="fa fa-font" style="width:19px;height:19px;"></i></button>		                      
							    <ul class="dropdown-menu" role="menu" aria-labelledby="font-family-X">
								    <li><a tabindex="-1" href="#" onclick="setFont('Arial');" class="Arial">Arial</a></li>
								    <li><a tabindex="-1" href="#" onclick="setFont('Helvetica');" class="Helvetica">Helvetica</a></li>
								    <li><a tabindex="-1" href="#" onclick="setFont('Myriad Pro');" class="MyriadPro">Myriad Pro</a></li>
								    <li><a tabindex="-1" href="#" onclick="setFont('Delicious');" class="Delicious">Delicious</a></li>
								    <li><a tabindex="-1" href="#" onclick="setFont('Verdana');" class="Verdana">Verdana</a></li>
								    <li><a tabindex="-1" href="#" onclick="setFont('Georgia');" class="Georgia">Georgia</a></li>
								    <li><a tabindex="-1" href="#" onclick="setFont('Courier');" class="Courier">Courier</a></li>
								    <li><a tabindex="-1" href="#" onclick="setFont('Comic Sans MS');" class="ComicSansMS">Comic Sans MS</a></li>
								    <li><a tabindex="-1" href="#" onclick="setFont('Impact');" class="Impact">Impact</a></li>
								    <li><a tabindex="-1" href="#" onclick="setFont('Monaco');" class="Monaco">Monaco</a></li>
								    <li><a tabindex="-1" href="#" onclick="setFont('Optima');" class="Optima">Optima</a></li>
								    <li><a tabindex="-1" href="#" onclick="setFont('Hoefler Text');" class="Hoefler Text">Hoefler Text</a></li>
								    <li><a tabindex="-1" href="#" onclick="setFont('Plaster');" class="Plaster">Plaster</a></li>
								    <li><a tabindex="-1" href="#" onclick="setFont('Engagement');" class="Engagement">Engagement</a></li>
				                </ul>
							    <button id="text-bold" class="btn" data-original-title="Bold"><img src="{{ asset('css/img/font_bold.png') }}" height="" width=""></button>
							    <button id="text-italic" class="btn" data-original-title="Italic"><img src="{{ asset('css/img/font_italic.png') }}" height="" width=""></button>
							    <button id="text-strike" class="btn" title="Strike" style=""><img src="{{ asset('css/img/font_strikethrough.png') }}" height="" width=""></button>
							 	<button id="text-underline" class="btn" title="Underline" style=""><img src="{{ asset('css/img/font_underline.png') }}"></button>
							 	<a class="btn" href="#" rel="tooltip" data-placement="top" data-original-title="Font Color"><input type="hidden" id="text-fontcolor" class="color-picker" size="7" value="#000000"></a>
						 		<a class="btn" href="#" rel="tooltip" data-placement="top" data-original-title="Font Border Color"><input type="hidden" id="text-strokecolor" class="color-picker" size="7" value="#000000"></a>
								  <!-- Background <input type="hidden" id="text-bgcolor" class="color-picker" size="7" value="#ffffff"> -->
							</div>							  
							<div class="pull-right" align="" id="imageeditor" style="display:none">
							  <div class="btn-group">										      
							      <button class="btn" id="bring-to-front" title="Bring to Front"><i class="icon-fast-backward rotate" style="height:19px;"></i></button>
							      <button class="btn" id="send-to-back" title="Send to Back"><i class="icon-fast-forward rotate" style="height:19px;"></i></button>
							      <button id="flip" type="button" class="btn" title="Show Back View"><i class="icon-retweet" style="height:19px;"></i></button>
							      <button id="remove-selected" class="btn" title="Delete selected item"><i class="icon-trash" style="height:19px;"></i></button>
							  </div>
							</div>			  
						</div>												
					</div>	




	        <!-- Nav tabs -->
	        <ul class="nav nav-tabs" role="tablist">
	          <li role="presentation" class="active"><a href="#moustaches" aria-controls="moustaches" role="tab" data-toggle="tab"><strong>Moustaches</strong></a></li>
	          <li role="presentation"><a href="#glasses" aria-controls="glasses" role="tab" data-toggle="tab"><strong>Glasses</strong></a></li>
	          <li role="presentation"><a href="#hairs" aria-controls="hairs" role="tab" data-toggle="tab"><strong>Hairs</strong></a></li>
	          <!-- <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li> -->
	        </ul>
	        <!-- Tab panes -->
	        <div class="tab-content">
	          <div role="tabpanel" class="tab-pane active" id="moustaches">
	            <div class="well">                              
	              <img class="thumb" src="<?php echo asset('img/fabric_assets/moustaches/moustaches-1.png');?>" title="moustaches-1">
	              <img class="thumb" src="<?php echo asset('img/fabric_assets/moustaches/moustaches-2.png');?>" title="moustaches-2">
	              <img class="thumb" src="<?php echo asset('img/fabric_assets/moustaches/moustaches-3.png');?>" title="moustaches-3">
	              <img class="thumb" src="<?php echo asset('img/fabric_assets/moustaches/moustaches-4.png');?>" title="moustaches-4">
	              <img class="thumb" src="<?php echo asset('img/fabric_assets/moustaches/moustaches-5.png');?>" title="moustaches-5">
	              <img class="thumb" src="<?php echo asset('img/fabric_assets/moustaches/moustaches-6.png');?>" title="moustaches-6">
	            </div>  
	          </div>
	          <div role="tabpanel" class="tab-pane" id="glasses">
	            <div class="well">
	              <img class="thumb" src="<?php echo asset('img/fabric_assets/glasses/glasses-1.png');?>" title="glasses-1">
	              <img class="thumb" src="<?php echo asset('img/fabric_assets/glasses/glasses-2.png');?>" title="glasses-2">
	              <img class="thumb" src="<?php echo asset('img/fabric_assets/glasses/glasses-3.png');?>" title="glasses-3">
	              <img class="thumb" src="<?php echo asset('img/fabric_assets/glasses/glasses-4.png');?>" title="glasses-4">
	              <img class="thumb" src="<?php echo asset('img/fabric_assets/glasses/glasses-5.png');?>" title="glasses-5">
	              <img class="thumb" src="<?php echo asset('img/fabric_assets/glasses/glasses-6.png');?>" title="glasses-6">
	            </div>  
	          </div>
	          <div role="tabpanel" class="tab-pane" id="hairs">
	            <div class="well">
	              <img class="thumb" src="<?php echo asset('img/fabric_assets/hairs/hair-1.png');?>" title="hairs-1">
	              <img class="thumb" src="<?php echo asset('img/fabric_assets/hairs/hair-2.png');?>" title="hairs-2">
	              <img class="thumb" src="<?php echo asset('img/fabric_assets/hairs/hair-3.png');?>" title="hairs-3">
	              <img class="thumb" src="<?php echo asset('img/fabric_assets/hairs/hair-4.png');?>" title="hairs-4">
	              <img class="thumb" src="<?php echo asset('img/fabric_assets/hairs/hair-5.png');?>" title="hairs-5">
	              <img class="thumb" src="<?php echo asset('img/fabric_assets/hairs/hair-6.png');?>" title="hairs-6">
	            </div>
	          </div>
	          <!-- <div role="tabpanel" class="tab-pane" id="settings">...</div> -->
	        </div>                      
	        <div class="col-lg-12">
	          <textarea id="canvaText" rows="3" class="form-control"></textarea>                              
	          <button id="addText" class="btn btn-warning btn-small">Add text</button>
	          <button id="saveToPng" class="btn btn-primary">Save to Jpeg</button>
	          <button id="delete" class="btn btn-danger">Delete selected object</button>
	        </div> 
	      </div> <!-- /row -->
	      <div class="row-fluid" id="canva-row">
	        <canvas id="canvas"></canvas>
	      </div> <!-- /row -->
	</div>   
{{-- Form::open(['action' => 'gallery/response']) --}}
<div class="text-center">   
	<div class="container-fluid">
	    <!-- The global progress bar -->
	    <div id="progress" class="progress" style="display:none;">
	      <div class="progress-bar progress-bar-danger"></div>
	    </div>
	</div>
</div>
<div class="center-block">
  <div class="form-group{{ $errors->first('fileupload', ' has-error') }} fileUpload">
  	 {!! Form::label('fileupload', 'Browse File'); !!}
     {!! Form::file('fileupload','',['class'=>'upload', 'id'=>'fileupload']) !!}  
	<span class="help-block">{{{ $errors->first('fileupload', ':message') }}}</span>
   </div>
</div>
<input type="hidden" name="image_temp" value="" id="image_temp">
<div class="text-center button-submit" style="display: none; text-align:center; margin: 12px -33px 0px 0px;">
  {!! Form::submit('Submit',['type'=>'submit','value'=>'KIRIM','id'=>'send_image','class'=>"btn btn-danger submit-color"]) !!}
  <div class="msg"></div>
</div>
{{-- Form::close() --}}

<div style="margin:30px auto"></div>
@endif

@stop