@extends('layouts.master')

@section('content')

		<section id="page-title">
			<div class="container clearfix">
				<h1>{{ $menu->name }}</h1>
				<span>{{ $menu->description }}</span>
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li class="active">Contact</li>
				</ol>
			</div>
		</section>

		<section id="google-map" class="gmap slider-parallax"></section>

		<section id="content">
			<div class="content-wrap">
				<div class="container clearfix">
					<div class="postcontent nobottommargin">
						<h3>Send us an Email</h3>
						<div class="contact-widget">
							<div class="contact-form-result"></div>
								{!! Form::model($contact,
									[
										'route' => ['contact.send'],
										'class' => 'nobottommargin',
										'id' => 'template-contactform',
										'name' => 'template-contactform',
										'method' => 'POST'
									])
								!!}
								<div class="form-process"></div>
								<div class="col_one_third form-group{{ $errors->first('contactform_name', ' has-error') }}">
									{!! Form::label('contactform_name', trans('label.name'), ['class'=>'control-label']); !!}
									{!! Form::text('contactform_name',Request::old('contactform_name', $contact->contactform_name),[
										'placeholder' => trans('label.enter_name'),
										'name' => 'contactform_name',
										'id' => 'contactform_name',
										'class' => 'sm-form-control required']); !!}
									<span class="help-block">{{{ $errors->first('contactform_name', ':message') }}}</span>
								</div>
								<div class="col_one_third form-group{{ $errors->first('contactform_email', ' has-error') }}">
									{!! Form::label('contactform_email', trans('label.email'), ['class'=>'control-label']); !!}
									{!! Form::text('contactform_email',Request::old('contactform_email', $contact->contactform_email),[
										'placeholder' => trans('label.enter_email'),
										'name' => 'contactform_email',
										'id' => 'contactform_email',
										'type' => 'email',
										'class' => 'sm-form-control required email']); !!}
									<span class="help-block">{{{ $errors->first('contactform_email', ':message') }}}</span>
								</div>
								<div class="col_one_third col_last form-group{{ $errors->first('contactform_phone', ' has-error') }}">
									{!! Form::label('contactform_phone', trans('label.phone'), ['class'=>'control-label']); !!}
									{!! Form::text('contactform_phone',Request::old('contactform_phone', $contact->contactform_phone),[
										'placeholder' => trans('label.enter_phone'),
										'name' => 'contactform_phone',
										'id' => 'contactform_phone',
										'class' => 'sm-form-control']); !!}
									<span class="help-block">{{{ $errors->first('contactform_phone', ':message') }}}</span>
								</div>
								<div class="clear"></div>
								<div class="col_two_third form-group{{ $errors->first('contactform_subject', ' has-error') }}">
									{!! Form::label('contactform_subject', trans('label.subject'), ['class'=>'control-label']); !!}
									{!! Form::text('contactform_subject',Request::old('contactform_subject', $contact->contactform_subject),[
										'placeholder' => trans('label.enter_subject'),
										'name' => 'contactform_subject',
										'id' => 'contactform_subject',
										'class' => 'sm-form-control required']); !!}
									<span class="help-block">{{{ $errors->first('contactform_subject', ':message') }}}</span>
								</div>
								<div class="col_one_third col_last">
									<label for="contactform-service">Services</label>
									<select id="contactform-service" name="contactform-service" class="sm-form-control">
										<option value="">-- Select One --</option>
										<option value="Wordpress">Business</option>
										<option value="PHP / MySQL">Strategic</option>
										<option value="HTML5 / CSS3">Web Development</option>
										<option value="Graphic Design">Graphic Design</option>
									</select>
								</div>
								<div class="clear"></div>
								<div class="col_full form-group{{ $errors->first('contactform_message', ' has-error') }}">
									{!! Form::label('contactform_message', trans('label.message'), ['class'=>'control-label']); !!}
									{!! Form::textarea('contactform_message',Request::old('contactform_message', $contact->contactform_message),[
										'placeholder'=>trans('label.enter_message'),
										'name'=>'contactform_message',
										'id'=>'contactform_message',
										'class' => 'sm-form-control',
										'rows' => '6',
										'cols'=>'30'
									]); !!}
									<span class="help-block">{{{ $errors->first('contactform_message', ':message') }}}</span>
								</div>
								<div class="col_full hidden">
									<input type="text" id="contactform-botcheck" name="contactform-botcheck" value="" class="sm-form-control" />
								</div>
								<div class="col_full form-group{{ $errors->first('g-recaptcha-response', ' has-error') }}">
									{!! Form::label('captcha', 'Captcha', ['class'=>'control-label']); !!}
									{!! app('captcha')->display(); !!}
									<span class="help-block">{{{ $errors->first('g-recaptcha-response', ':message') }}}</span>
								</div>
								<div class="col_full">
									{!! Form::submit(trans('label.send_message'), ['class' => 'button button-3d nomargin','id'=>'contactform_submit','name'=>'contactform_submit','value'=>'submit']) !!}
								</div>
								{!! Form::close() !!}
						</div>
					</div>

					<div class="sidebar col_last nobottommargin">
						<address>
							<strong>Headquarters:</strong><br>
							Menara Sentraya, Floor 36<br>
							Jl. Iskandarsyah Raya No.1A, Jakarta 12130<br>
						</address>
						<abbr title="Phone Number"><strong>Phone:</strong></abbr> (62) 21 304 5632<br>
						<abbr title="Fax"><strong>Fax:</strong></abbr> (62) 21 4752 1433<br>
						<abbr title="Email Address"><strong>Email:</strong></abbr> info@dentsu.digital
						<div class="widget noborder notoppadding">
							<a href="#" class="social-icon si-small si-dark si-facebook">
								<i class="icon-facebook"></i>
								<i class="icon-facebook"></i>
							</a>
							<a href="#" class="social-icon si-small si-dark si-twitter">
								<i class="icon-twitter"></i>
								<i class="icon-twitter"></i>
							</a>
							<a href="#" class="social-icon si-small si-dark si-dribbble">
								<i class="icon-dribbble"></i>
								<i class="icon-dribbble"></i>
							</a>
							<a href="#" class="social-icon si-small si-dark si-forrst">
								<i class="icon-forrst"></i>
								<i class="icon-forrst"></i>
							</a>
							<a href="#" class="social-icon si-small si-dark si-pinterest">
								<i class="icon-pinterest"></i>
								<i class="icon-pinterest"></i>
							</a>
							<a href="#" class="social-icon si-small si-dark si-gplus">
								<i class="icon-gplus"></i>
								<i class="icon-gplus"></i>
							</a>
						</div>
					</div><!-- .sidebar end -->
				</div>
			</div>
		</section><!-- #content end -->

@stop
