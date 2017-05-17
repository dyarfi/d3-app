@extends('layouts.master')

@section('content')

<!-- Page Title ============================================= -->
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
		</section><!-- #page-title end -->
		<!-- Content
		============================================= -->
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
								<h3>{{ $career->name }}</h3>
							</div>
							<p>{{ str_limit($career->description, 400,' [...]')}}</p>
							<div class="accordion accordion-bg clearfix">
								<div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>Requirements</div>
								<div class="acc_content clearfix">
									<ul class="iconlist iconlist-color nobottommargin">
										<li><i class="icon-ok"></i>B.Tech./ B.E / MCA degree in Computer Science, Engineering or a related stream.</li>
										<li><i class="icon-ok"></i>3+ years of software development experience.</li>
										<li><i class="icon-ok"></i>3+ years of Python / Java development projects experience.</li>
										<li><i class="icon-ok"></i>Minimum of 4 live project roll outs.</li>
										<li><i class="icon-ok"></i>Experience with third-party libraries and APIs.</li>
										<li><i class="icon-ok"></i>In depth understanding and experience  of either SDLC or PDLC.</li>
										<li><i class="icon-ok"></i>Good Communication Skills</li>
										<li><i class="icon-ok"></i>Team Player</li>
									</ul>
								</div>
								<div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>What we Expect from you?</div>
								<div class="acc_content clearfix">
									<ul class="iconlist iconlist-color nobottommargin">
										<li><i class="icon-plus-sign"></i>Design and build applications/ components using open source technology.</li>
										<li><i class="icon-plus-sign"></i>Taking complete ownership of the deliveries assigned.</li>
										<li><i class="icon-plus-sign"></i>Collaborate with cross-functional teams to define, design, and ship new features.</li>
										<li><i class="icon-plus-sign"></i>Work with outside data sources and API's.</li>
										<li><i class="icon-plus-sign"></i>Unit-test code for robustness, including edge cases, usability, and general reliability.</li>
										<li><i class="icon-plus-sign"></i>Work on bug fixing and improving application performance.</li>
									</ul>
								</div>
								<div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i>What you've got?</div>
								<div class="acc_content clearfix">You'll be familiar with agile practices and have a highly technical background, comfortable discussing detailed technical aspects of system design and implementation, whilst remaining business driven. With 5+ years of systems analysis, technical analysis or business analysis experience, you'll have an expansive toolkit of communication techniques to enable shared, deep understanding of financial and technical concepts by diverse stakeholders with varying backgrounds and needs. In addition, you will have exposure to financial systems or accounting knowledge.</div>
							</div>
							<a href="#" data-scrollto="#job-apply" class="button button-3d button-black nomargin">Apply Now</a>
							@if ($i != $c) <div class="divider divider-short"><i class="icon-star3"></i></div> @endif
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
							<form action="include/jobs.php" id="template-jobform" name="template-jobform" method="post" role="form">
								<div class="form-process"></div>
								<div class="col_half">
									<label for="template-jobform-fname">First Name <small>*</small></label>
									<input type="text" id="template-jobform-fname" name="template-jobform-fname" value="" class="sm-form-control required" />
								</div>
								<div class="col_half col_last">
									<label for="template-jobform-lname">Last Name <small>*</small></label>
									<input type="text" id="template-jobform-lname" name="template-jobform-lname" value="" class="sm-form-control required" />
								</div>
								<div class="clear"></div>
								<div class="col_full">
									<label for="template-jobform-email">Email <small>*</small></label>
									<input type="email" id="template-jobform-email" name="template-jobform-email" value="" class="required email sm-form-control" />
								</div>
								<div class="col_half">
									<label for="template-jobform-age">Age <small>*</small></label>
									<input type="text" name="template-jobform-age" id="template-jobform-age" value="" size="22" tabindex="4" class="sm-form-control required" />
								</div>
								<div class="col_half col_last">
									<label for="template-jobform-city">City <small>*</small></label>
									<input type="text" name="template-jobform-city" id="template-jobform-city" value="" size="22" tabindex="5" class="sm-form-control required" />
								</div>
								<div class="clear"></div>
								<div class="col_full">
									<label for="template-jobform-service">Position <small>*</small></label>
									<select name="template-jobform-position" id="template-jobform-position"  tabindex="9" class="sm-form-control required">
										<option value="">-- Select Position --</option>
										@foreach($career_list as $list)
										<option value="{{ $career->name }}">{{ $list->name }}</option>
										@endforeach
									</select>
								</div>
								<div class="col_half">
									<label for="template-jobform-salary">Expected Salary</label>
									<input type="text" name="template-jobform-salary" id="template-jobform-salary" value="" size="22" tabindex="6" class="sm-form-control" />
								</div>
								<div class="col_half col_last">
									<label for="template-jobform-time">Start Date</label>
									<input type="text" name="template-jobform-start" id="template-jobform-start" value="" size="22" tabindex="7" class="sm-form-control" />
								</div>
								<div class="clear"></div>
								<div class="col_full">
									<label for="template-jobform-website">Website (if any)</label>
									<input type="text" name="template-jobform-website" id="template-jobform-website" value="" size="22" tabindex="8" class="sm-form-control" />
								</div>
								<div class="col_full">
									<label for="template-jobform-experience">Experience (optional)</label>
									<textarea name="template-jobform-experience" id="template-jobform-experience" rows="3" tabindex="10" class="sm-form-control"></textarea>
								</div>
								<div class="col_full">
									<label for="template-jobform-application">Application <small>*</small></label>
									<textarea name="template-jobform-application" id="template-jobform-application" rows="6" tabindex="11" class="sm-form-control required"></textarea>
								</div>
								<div class="col_full hidden">
									<input type="text" id="template-jobform-botcheck" name="template-jobform-botcheck" value="" class="sm-form-control" />
								</div>
								<div class="col_full">
									<button class="button button-3d button-large btn-block nomargin" name="template-jobform-apply" type="submit" value="apply">Send Application</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				{!! $careers->render() !!}
			</div>
		</section><!-- #content end -->

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
