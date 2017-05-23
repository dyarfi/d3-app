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
								<div class="col_one_third">
									<label for="template-contactform-name">Name <small>*</small></label>
									<input type="text" id="template-contactform-name" name="template-contactform-name" value="" class="sm-form-control required" />
								</div>
								<div class="col_one_third">
									<label for="template-contactform-email">Email <small>*</small></label>
									<input type="email" id="template-contactform-email" name="template-contactform-email" value="" class="required email sm-form-control" />
								</div>
								<div class="col_one_third col_last">
									<label for="template-contactform-phone">Phone</label>
									<input type="text" id="template-contactform-phone" name="template-contactform-phone" value="" class="sm-form-control" />
								</div>
								<div class="clear"></div>
								<div class="col_two_third">
									<label for="template-contactform-subject">Subject <small>*</small></label>
									<input type="text" id="template-contactform-subject" name="template-contactform-subject" value="" class="required sm-form-control" />
								</div>
								<div class="col_one_third col_last">
									<label for="template-contactform-service">Services</label>
									<select id="template-contactform-service" name="template-contactform-service" class="sm-form-control">
										<option value="">-- Select One --</option>
										<option value="Wordpress">Business</option>
										<option value="PHP / MySQL">Strategic</option>
										<option value="HTML5 / CSS3">Web Development</option>
										<option value="Graphic Design">Graphic Design</option>
									</select>
								</div>
								<div class="clear"></div>
								<div class="col_full">
									<label for="template-contactform-message">Message <small>*</small></label>
									<textarea class="required sm-form-control" id="template-contactform-message" name="template-contactform-message" rows="6" cols="30"></textarea>
								</div>
								<div class="col_full hidden">
									<input type="text" id="template-contactform-botcheck" name="template-contactform-botcheck" value="" class="sm-form-control" />
								</div>
								<div class="col_full">
									<script src="https://www.google.com/recaptcha/api.js" async defer></script>
									<div class="g-recaptcha" data-sitekey="6LfijgUTAAAAACPt-XfRbQszAKAJY0yZDjjhMUQT"></div>
								</div>
								<div class="col_full">
									<button class="button button-3d nomargin" type="submit" id="template-contactform-submit" name="template-contactform-submit" value="submit">Send Message</button>
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

<div style="margin:60px auto"></div>
{!! Form::model($contact,
	[
		'route' => ['contact.send'],
		'class' => ''
	])
!!}

<div class="form-group{{ $errors->first('name', ' has-error') }}">
	{!! Form::label('name', trans('label.name'), ['class'=>'control-label']); !!}
	{!! Form::text('name',Request::old('name', $contact->name),[
		'placeholder'=>trans('label.enter_name'),
		'name'=>'name',
		'id'=>'name',
		'class' => 'form-control']); !!}
	<span class="help-block">{{{ $errors->first('name', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('email', ' has-error') }}">
	{!! Form::label('email', trans('label.email_address'), ['class'=>'control-label']); !!}
	{!! Form::text('email',Request::old('email', $contact->email),[
		'placeholder'=>trans('label.enter_email'),
		'name'=>'email',
		'id'=>'email',
		'class'=>'form-control']); !!}
	<span class="help-block">{{{ $errors->first('email', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('subject', ' has-error') }}">
	{!! Form::label('subject', trans('label.subject'), ['class'=>'control-label']); !!}
	{!! Form::text('phone',Request::old('subject', $contact->subject),[
		'placeholder'=>trans('label.enter_subject'),
		'name'=>'subject',
		'id'=>'subject',
		'class'=>'form-control']); !!}
	<span class="help-block">{{{ $errors->first('subject', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('description', ' has-error') }}">
	{!! Form::label('description', trans('label.description'), ['class'=>'control-label']); !!}
	{!! Form::textarea('description',Request::old('description', $contact->description),[
		'placeholder'=>trans('label.enter_description'),
		'name'=>'description',
		'id'=>'description',
		'class' => 'form-control',
		'rows' => '4'
	]); !!}
	<span class="help-block">{{{ $errors->first('description', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('g-recaptcha-response', ' has-error') }}">
	{!! Form::label('captcha', 'Captcha', ['class'=>'control-label']); !!}
	{!! app('captcha')->display(); !!}
	<span class="help-block">{{{ $errors->first('g-recaptcha-response', ':message') }}}</span>
</div>

<div class="clearfix">
	{!! Form::submit(trans('label.submit'), ['class' => 'btn btn-primary btn-md']) !!}
</div>

{!! Form::close() !!}

<div style="margin:60px auto"></div>

@stop
