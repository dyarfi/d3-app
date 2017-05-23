@extends('layouts.master')

@section('content')

	<section id="page-title" class="page-title-mini">
		<div class="container clearfix">
			<h1>{{ $menu->name }}</h1>
			<span>{{ $menu->description }}</span>
			<ol class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li><a href="#">Pages</a></li>
				<li class="active">About Us</li>
			</ol>
		</div>
	</section>

	<section id="content">
		<div class="content-wrap">
			<div class="container clearfix">
				<div class="col_full">
					<div class="heading-block center nobottomborder">
						<h2>Interactive Office Environment</h2>
						<span>We value Work Ethics &amp; Environment as it helps in creating a Creative Thinktank</span>
					</div>
					<div class="fslider" data-pagi="false" data-animation="fade">
						<div class="flexslider">
							<div class="slider-wrap">
								<div class="slide"><a href="#"><img src="{{ asset('images/about/4.jpg') }}" alt="About Image"></a></div>
								<div class="slide"><a href="#"><img src="{{ asset('images/about/5.jpg') }}" alt="About Image"></a></div>
								<div class="slide"><a href="#"><img src="{{ asset('images/about/6.png') }}" alt="About Image"></a></div>
								<div class="slide"><a href="#"><img src="{{ asset('images/about/7.jpg') }}" alt="About Image"></a></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col_one_fourth center" data-animate="bounceIn">
					<i class="i-plain i-xlarge divcenter nobottommargin icon-users"></i>
					<div class="counter counter-large" style="color: #3498db;"><span data-from="100" data-to="8465" data-refresh-interval="50" data-speed="2000"></span></div>
					<h5>Clients Served</h5>
				</div>
				<div class="col_one_fourth center" data-animate="bounceIn" data-delay="200">
					<i class="i-plain i-xlarge divcenter nobottommargin icon-code"></i>
					<div class="counter counter-large" style="color: #e74c3c;"><span data-from="100" data-to="56841" data-refresh-interval="50" data-speed="2500"></span></div>
					<h5>Lines of Code</h5>
				</div>
				<div class="col_one_fourth center" data-animate="bounceIn" data-delay="400">
					<i class="i-plain i-xlarge divcenter nobottommargin icon-briefcase"></i>
					<div class="counter counter-large" style="color: #16a085;"><span data-from="100" data-to="2154" data-refresh-interval="50" data-speed="3500"></span></div>
					<h5>No. of Projects</h5>
				</div>
				<div class="col_one_fourth center col_last" data-animate="bounceIn" data-delay="600">
					<i class="i-plain i-xlarge divcenter nobottommargin icon-cup"></i>
					<div class="counter counter-large" style="color: #9b59b6;"><span data-from="100" data-to="874" data-refresh-interval="30" data-speed="2700"></span></div>
					<h5>Cups of Coffee</h5>
				</div>
				<div class="clear"></div>
				<div class="promo promo-light bottommargin">
					<h3>Call us today at <span>+62.21.3095645</span> or Email us at <span>contact@dentsu.digital</span></h3>
					<span> "Brand is just a perception, and perception will match reality over time. ."</span>
					<a href="#" class="button button-xlarge button-rounded">Start Browsing</a>
				</div>
				<div class="heading-block center">
					<h2>Dentsu Digital</h2>
					<span>Our Team Members who have contributed immensely to our Growth</span>
				</div>
				<div class="row clearfix">
					<div class="col-md-6 bottommargin">
						<div class="team team-list clearfix">
							<div class="team-image">
								<img src="{{ asset('images/team/3.jpg') }}" alt="John Doe">
							</div>
							<div class="team-desc">
								<div class="team-title"><h4>John Doe</h4><span>CEO</span></div>
								<div class="team-content">
									<p>Carbon emissions reductions giving, legitimize amplify non-partisan Aga Khan. Policy dialogue assessment expert free-speech cornerstone disruptor freedom. Cesar Chavez empower.</p>
								</div>
								<a href="#" class="social-icon si-rounded si-small si-light si-facebook">
									<i class="icon-facebook"></i>
									<i class="icon-facebook"></i>
								</a>
								<a href="#" class="social-icon si-rounded si-small si-light si-twitter">
									<i class="icon-twitter"></i>
									<i class="icon-twitter"></i>
								</a>
								<a href="#" class="social-icon si-rounded si-small si-light si-gplus">
									<i class="icon-gplus"></i>
									<i class="icon-gplus"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="col-md-6 bottommargin">
						<div class="team team-list clearfix">
							<div class="team-image">
								<img src="{{ asset('images/team/2.jpg') }}" alt="Josh Clark">
							</div>
							<div class="team-desc">
								<div class="team-title"><h4>Steve Austin</h4><span>Co-Founder</span></div>
								<div class="team-content">
									<p>Carbon emissions reductions giving, legitimize amplify non-partisan Aga Khan. Policy dialogue assessment expert free-speech cornerstone disruptor freedom. Cesar Chavez empower.</p>
								</div>
								<a href="#" class="social-icon si-rounded si-small si-light si-facebook">
									<i class="icon-facebook"></i>
									<i class="icon-facebook"></i>
								</a>
								<a href="#" class="social-icon si-rounded si-small si-light si-twitter">
									<i class="icon-twitter"></i>
									<i class="icon-twitter"></i>
								</a>
								<a href="#" class="social-icon si-rounded si-small si-light si-gplus">
									<i class="icon-gplus"></i>
									<i class="icon-gplus"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="col-md-6 bottommargin">
						<div class="team team-list clearfix">
							<div class="team-image">
								<img src="{{ asset('images/team/8.jpg') }}" alt="Mary Jane">
							</div>
							<div class="team-desc">
								<div class="team-title"><h4>Mary Jane</h4><span>Sales</span></div>
								<div class="team-content">
									<p>Carbon emissions reductions giving, legitimize amplify non-partisan Aga Khan. Policy dialogue assessment expert free-speech cornerstone disruptor freedom. Cesar Chavez empower.</p>
								</div>
								<a href="#" class="social-icon si-rounded si-small si-light si-facebook">
									<i class="icon-facebook"></i>
									<i class="icon-facebook"></i>
								</a>
								<a href="#" class="social-icon si-rounded si-small si-light si-twitter">
									<i class="icon-twitter"></i>
									<i class="icon-twitter"></i>
								</a>
								<a href="#" class="social-icon si-rounded si-small si-light si-gplus">
									<i class="icon-gplus"></i>
									<i class="icon-gplus"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="col-md-6 bottommargin">
						<div class="team team-list clearfix">
							<div class="team-image">
								<img src="{{ asset('images/team/4.jpg') }}" alt="Nix Maxwell">
							</div>
							<div class="team-desc">
								<div class="team-title"><h4>Nick North</h4><span>Support</span></div>
								<div class="team-content">
									<p>Carbon emissions reductions giving, legitimize amplify non-partisan Aga Khan. Policy dialogue assessment expert free-speech cornerstone disruptor freedom. Cesar Chavez empower.</p>
								</div>
								<a href="#" class="social-icon si-rounded si-small si-light si-facebook">
									<i class="icon-facebook"></i>
									<i class="icon-facebook"></i>
								</a>
								<a href="#" class="social-icon si-rounded si-small si-light si-twitter">
									<i class="icon-twitter"></i>
									<i class="icon-twitter"></i>
								</a>
								<a href="#" class="social-icon si-rounded si-small si-light si-gplus">
									<i class="icon-gplus"></i>
									<i class="icon-gplus"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="section topmargin-sm footer-stick">
				<h4 class="uppercase center">What <span>Clients</span> Say?</h4>
				<div class="fslider testimonial testimonial-full" data-animation="fade" data-arrows="false">
					<div class="flexslider">
						<div class="slider-wrap">
							<div class="slide">
								<div class="testi-image">
									<a href="#"><img src="{{ asset('images/testimonials/3.png') }}" alt="Customer Testimonails"></a>
								</div>
								<div class="testi-content">
									<p>Similique fugit repellendus expedita excepturi iure perferendis provident quia eaque. Repellendus, vero numquam?</p>
									<div class="testi-meta">
										Steve Jobs
										<span>Apple Inc.</span>
									</div>
								</div>
							</div>
							<div class="slide">
								<div class="testi-image">
									<a href="#"><img src="{{ asset('images/testimonials/2.png') }}" alt="Customer Testimonails"></a>
								</div>
								<div class="testi-content">
									<p>Natus voluptatum enim quod necessitatibus quis expedita harum provident eos obcaecati id culpa corporis molestias.</p>
									<div class="testi-meta">
										Steve North
										<span>Vivid Interactive  Inc.</span>
									</div>
								</div>
							</div>
							<div class="slide">
								<div class="testi-image">
									<a href="#"><img src="{{ asset('images/testimonials/1.png') }}" alt="Customer Testimonails"></a>
								</div>
								<div class="testi-content">
									<p>Incidunt deleniti blanditiis quas aperiam recusandae consequatur ullam quibusdam cum libero illo rerum!</p>
									<div class="testi-meta">
										Steve Martin
										<span>Coldplay Inc.</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section><!-- #content end -->
@stop
