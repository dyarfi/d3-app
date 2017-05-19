@extends('layouts.master')

@section('content')

		<section id="page-title" class="page-title-parallax page-title-dark" style="background-image: url('{{ asset("images/about/parallax.jpg") }}'); padding: 120px 0;" data-stellar-background-ratio="0.3">
			<div class="container clearfix">
				<h1>Job Openings</h1>
				<span>{{ $menu->description }} Join our Fabulous Team of Intelligent Individuals</span>
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">Pages</a></li>
					<li class="active">{{ trans('label.career') }}</li>
				</ol>
			</div>
		</section>
		<section id="content">
			<div class="content-wrap">
				<div class="container clearfix">
					<div class="col_three_fifth nobottommargin" id="entry-listing">
						<div class="entry isotope-item">
							<?php
							$i = 1;
							$c = count($careers);
							?>
							@foreach($careers as $career)
							<div class="fancy-title title-bottom-border">
								<h3>{{ $career->name }} <span class="pull-right"><i class="icon-ok"></i> {{ $career->end_date }}</span></h3>
							</div>
							<p>{{ str_limit($career->description, 500,' [...]')}}</p>
							<div class="accordion accordion-bg clearfix">
								@if ($career->requirement)
								<div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Requirements</div>
								<div class="acc_content clearfix">
									{!! $career->requirement !!}
								</div>
								@endif
								@if ($career->responsibility)
								<div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Responsibility</div>
								<div class="acc_content clearfix">
									{!! $career->responsibility !!}
								</div>
								@endif
								@if($career->facility)
								<div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Facility</div>
								<div class="acc_content clearfix">
									{!! $career->facility !!}
								</div>
								@endif
							</div>
							<a href="#" data-scrollto="#job-apply" class="button button-3d button-black nomargin apply" data-rel="{!! $career->slug !!}">Apply Now</a>
							@if ($i != $c)
								<div class="divider divider-short"><i class="icon-star3"></i></div>
						 	@endif
							<?php $i++ ;?>
							@endforeach
						</div>
					</div>
					<div class="col_two_fifth nobottommargin col_last">
						<div id="job-apply" class="heading-block highlight-me">
							<h2>Apply Now</h2>
							<span>And we'll get back to you within 48 hours.</span>
						</div>
						<div class="contact-widget">
							<div class="contact-form-result"></div>
							{!! Form::model($applicant,
								[
									'route' => ['career.post'],
									'class' => '',
									'name' => 'template-jobform',
									'method' => 'POST',
									'role' => 'form',
									'id' => 'template-jobform'
								])
							!!}
								<div class="form-process"></div>
								<div class="col_half">
									<label for="jobform_fname">First Name </label>
									<input type="text" id="jobform_fname" name="jobform_fname" value="" class="sm-form-control required" />
								</div>
								<div class="col_half col_last">
									<label for="jobform_lname">Last Name </label>
									<input type="text" id="jobform_lname" name="jobform_lname" value="" class="sm-form-control required" />
								</div>
								<div class="clear"></div>
								<div class="col_full">
									<label for="jobform_email">Email </label>
									<input type="email" id="jobform_email" name="jobform_email" value="" class="required email sm-form-control" />
								</div>
								<div class="col_full">
									<label for="jobform_phone">Phone </label>
									<input type="email" id="jobform_phone" name="jobform_phone" value="" class="required email sm-form-control" />
								</div>
								<div class="col_half">
									<label for="jobform_age">Age </label>
									<input type="text" name="jobform_age" id="jobform_age" value="" size="22" tabindex="4" class="sm-form-control required" />
								</div>
								<div class="col_half col_last">
									<label for="jobform_city">City </label>
									<input type="text" name="jobform_city" id="jobform_city" value="" size="22" tabindex="5" class="sm-form-control required" />
								</div>
								<div class="clear"></div>
								<div class="col_full">
									<label for="jobform_service">Position </label>
									<select name="jobform_position" id="jobform_position"  tabindex="9" class="sm-form-control required">
										<option value="">-- Select Position --</option>
										@foreach($career_list as $list)
										<option value="{{ $list->slug }}">{{ $list->name }}</option>
										@endforeach
									</select>
								</div>
								<div class="col_half">
									<label for="jobform_salary">Expected Salary </label>
									<input type="text" name="jobform_salary" id="jobform_salary" value="" size="22" tabindex="6" class="sm-form-control" />
								</div>
								<div class="col_half col_last">
									<label for="jobform_time">Start Date </label>
									<input type="text" name="jobform_start" id="jobform_start" value="" size="22" tabindex="7" class="sm-form-control" />
								</div>
								<div class="clear"></div>
								<div class="col_full">
									<label for="jobform_website">Website (if any) </label>
									<input type="text" name="jobform_website" id="jobform_website" value="" size="22" tabindex="8" class="sm-form-control" />
								</div>
								<div class="col_full">
									<label for="jobform_experience">Experience (optional) </label>
									<textarea name="jobform_experience" id="jobform_experience" rows="3" tabindex="10" class="sm-form-control"></textarea>
								</div>
								<div class="col_full">
									<label for="jobform_application">Application </label>
									<textarea name="jobform_application" id="jobform_application" rows="6" tabindex="11" class="sm-form-control required"></textarea>
								</div>
								<div class="col_full hidden">
									<input type="text" id="jobform_botcheck" name="jobform_botcheck" value="" class="sm-form-control" />
								</div>
								<div class="col_full">
									<button class="button button-3d button-large btn-block nomargin" name="jobform_apply" type="submit" value="apply">Send Application</button>
								</div>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
				{!! $careers->render() !!}
			</div>
		</section>

<!--h1>{{ trans('label.career') }} List</h1>
<p class="lead">Welcome to our {{ $menu->description }}<br/>Here's a list of all our career.</p>
<hr-->
<!--div id="entry-listing" class="container-fluid">
	@if($careers->count())
		@foreach($careers as $career)
		<div class="entry isotope-item">
		    <h3>{{ $career->name }} </h3>
		    <small><span class="fa fa-check"></span> {{ $career->created_at }}</small> -
		    <small><span class="fa fa-lock"></span> {{ $career->end_date }}</small>
		    <p>{{ str_limit($career->description, 400,' [...]')}}</p>
		    <p>
		        <a href="{{ route('career.show', $career->slug) }}" class="btn btn-info btn-xs"><span class="fa fa-search"></span> View Career</a>
		        <a href="{{ route('career.apply', $career->slug) }}" class="btn btn-primary btn-xs"><span class="fa fa-upload"></span> Apply Career</a>
		    </p>
		    <hr>
		</div>
		@endforeach
	@else
		{!! '<h4>Not Available at the Moment</h4>' !!}
	@endif
</div-->
<!-- {!! $careers->render() !!} -->
@stop
