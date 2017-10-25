<?php
// This is supposed to be working with symlik in storage/app/public into public/upload
// <img src="{{ asset('upload/27257.jpg') }}"/>
?>
@extends('layouts.master')
@section('content')
@if(sizeof($banners) > 0)
<section id="slider" class="slider-parallax swiper_wrapper full-screen clearfix">
	<div class="slider-parallax-inner">
		<div class="swiper-container swiper-parent">
			<div class="swiper-wrapper">
				@foreach ($banners as $banner)
					@if($banner->image && File::exists(public_path('uploads/'.$banner->image)))
					<div class="swiper-slide" style="background-image: url('{{ asset('uploads/'.$banner->image) }} ');">
						<div class="container clearfix">
							<div class="slider-caption slider-caption-center">
								<h2 data-caption-animate="fadeInUp">{{ $banner->name }}</h2>
								<p data-caption-animate="fadeInUp" data-caption-delay="180">
									{{ str_limit(strip_tags($banner->description),200,'') }}
								</p>
							</div>
						</div>
					</div>
					@endif
				@endforeach
			</div>
			@if(sizeof($banners) > 1)
				<div id="slider-arrow-left"><i class="icon-angle-left"></i></div>
				<div id="slider-arrow-right"><i class="icon-angle-right"></i></div>
			@endif
		</div>
		<a href="#" data-scrollto="#content" data-offset="100" class="dark one-page-arrow"><i class="icon-angle-down infinite animated fadeInDown"></i></a>
	</div>
</section>
@endif
<section id="content">
	<div class="content-wrap">
		<div class="container clearfix">
			<div class="row clearfix">
				{{-- {!! $welcome->description !!} --}}
				<div class="col-lg-5">
					<div class="heading-block topmargin">
						<h1>Welcome to Dentsu Digital.<br>Award Winning Agency.</h1>
					</div>
					<p class="lead">
						Dentsu Digital is driven to innovate how brand creates the whole experience. We fascinated by the complexities of people’s behavior, that’s why we learned and mastered it. <br/><br/> We also understand that brands has their own unique complexities, and we believe the way brand build itself needs to innovate by creating something relatable between people and the brand itself.
					</p>
				</div>
				<div class="col-lg-7">
					<div style="position: relative; margin-bottom: -60px;" class="ohidden" data-height-lg="426" data-height-md="567" data-height-sm="470" data-height-xs="287" data-height-xxs="183">
						<img src="{{ asset('images/services/main-fbrowser_.png') }}" style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" data-delay="100" alt="Chrome">
						<img src="{{ asset('images/services/main-fmobile_.png') }}" style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" data-delay="400" alt="iPad">
					</div>
				</div>
			</div>
		</div>
		<!--
		parallax dark" style="background-image: url('{{ asset("images/services/slider-testi.jpg") }}'); padding: 100px 0;" data-stellar-background-ratio="0.4"
		-->
		<div class="section nomargin">
			<div class="container clear-bottommargin clearfix">
				<div class="row clearfix">
					<div class="heading-block center">
						<h2>What you get from us</h2>
						<span class="divcenter">Our team will turn your ideas into reality.</span>
					</div>
					@foreach ($teams as $team)
					<div class="col-md-4 bottommargin">
						<?php echo $team->description;?>
					</div>
					@endforeach					
				</div>
			</div>
		</div>
		<div class="section nomargin">
			<div class="container clearfix">
				<div class="heading-block center nomargin">
					<h3>Our Latest Works</h3>
					<span class="divcenter">We crafted our ideas with love and passion.</span>
				</div>
			</div>
		</div>
		<div id="portfolio" class="portfolio portfolio-nomargin grid-container portfolio-notitle portfolio-full grid-container clearfix">
			<article class="portfolio-item pf-media pf-icons">
				<div class="portfolio-image">
					<a href="#portfolio-single.html">
						<img src="{{ asset('images/portfolio/4/1.jpg') }}" alt="Open Imagination">
					</a>
					<div class="portfolio-overlay">
						<a href="{{ asset('images/portfolio/full/1.jpg') }}" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
						<a href="#portfolio-single.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
					</div>
				</div>
				<div class="portfolio-desc">
					<h3><a href="#portfolio-single.html">Open Imagination</a></h3>
					<span><a href="#">Media</a>, <a href="#">Icons</a></span>
				</div>
			</article>
			<article class="portfolio-item pf-illustrations">
				<div class="portfolio-image">
					<a href="portfolio-single.html">
						<img src="{{ asset('images/portfolio/4/2.jpg') }}" alt="Locked Steel Gate">
					</a>
					<div class="portfolio-overlay">
						<a href="{{ asset('images/portfolio/full/2.jpg') }}" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
						<a href="#portfolio-single.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
					</div>
				</div>
				<div class="portfolio-desc">
					<h3><a href="#portfolio-single.html">Locked Steel Gate</a></h3>
					<span><a href="#">Illustrations</a></span>
				</div>
			</article>
			<article class="portfolio-item pf-graphics pf-uielements">
				<div class="portfolio-image">
					<a href="#">
						<img src="{{ asset('images/portfolio/4/3.jpg') }}" alt="Mac Sunglasses">
					</a>
					<div class="portfolio-overlay">
						<a href="http://vimeo.com/89396394" class="left-icon" data-lightbox="iframe"><i class="icon-line-play"></i></a>
						<a href="#portfolio-single-video.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
					</div>
				</div>
				<div class="portfolio-desc">
					<h3><a href="#portfolio-single-video.html">Mac Sunglasses</a></h3>
					<span><a href="#">Graphics</a>, <a href="#">UI Elements</a></span>
				</div>
			</article>
			<article class="portfolio-item pf-icons pf-illustrations">
				<div class="portfolio-image">
					<a href="#portfolio-single.html">
						<img src="{{ asset('images/portfolio/4/4.jpg') }}" alt="Open Imagination">
					</a>
					<div class="portfolio-overlay" data-lightbox="gallery">
						<a href="{{ asset('images/portfolio/full/4.jpg') }}" class="left-icon" data-lightbox="gallery-item"><i class="icon-line-stack-2"></i></a>
						<a href="{{ asset('images/portfolio/full/4-1.jpg') }}" class="hidden" data-lightbox="gallery-item"></a>
						<a href="#portfolio-single-gallery.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
					</div>
				</div>
				<div class="portfolio-desc">
					<h3><a href="#portfolio-single-gallery.html">Morning Dew</a></h3>
					<span><a href="#"><a href="#">Icons</a>, <a href="#">Illustrations</a></span>
				</div>
			</article>
			<article class="portfolio-item pf-uielements pf-media">
				<div class="portfolio-image">
					<a href="#portfolio-single.html">
						<img src="{{ asset('images/portfolio/4/5.jpg') }}" alt="Console Activity">
					</a>
					<div class="portfolio-overlay">
						<a href="{{ asset('images/portfolio/full/5.jpg') }}" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
						<a href="#portfolio-single.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
					</div>
				</div>
				<div class="portfolio-desc">
					<h3><a href="#portfolio-single.html">Console Activity</a></h3>
					<span><a href="#">UI Elements</a>, <a href="#">Media</a></span>
				</div>
			</article>
			<article class="portfolio-item pf-graphics pf-illustrations">
				<div class="portfolio-image">
					<a href="#portfolio-single.html">
						<img src="{{ asset('images/portfolio/4/6.jpg') }}" alt="Open Imagination">
					</a>
					<div class="portfolio-overlay" data-lightbox="gallery">
						<a href="{{ asset('images/portfolio/full/6.jpg') }}" class="left-icon" data-lightbox="gallery-item"><i class="icon-line-stack-2"></i></a>
						<a href="{{ asset('images/portfolio/full/6-1.jpg') }}" class="hidden" data-lightbox="gallery-item"></a>
						<a href="{{ asset('images/portfolio/full/6-2.jpg') }}" class="hidden" data-lightbox="gallery-item"></a>
						<a href="{{ asset('images/portfolio/full/6-3.jpg') }}" class="hidden" data-lightbox="gallery-item"></a>
						<a href="#portfolio-single-gallery.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
					</div>
				</div>
				<div class="portfolio-desc">
					<h3><a href="#portfolio-single-gallery.html">Shake It!</a></h3>
					<span><a href="#">Illustrations</a>, <a href="#">Graphics</a></span>
				</div>
			</article>
			<article class="portfolio-item pf-uielements pf-icons">
				<div class="portfolio-image">
					<a href="portfolio-single-video.html">
						<img src="{{ asset('images/portfolio/4/7.jpg') }}" alt="Backpack Contents">
					</a>
					<div class="portfolio-overlay">
						<a href="https://www.youtube.com/watch?v=kuceVNBTJio" class="left-icon" data-lightbox="iframe"><i class="icon-line-play"></i></a>
						<a href="#portfolio-single-video.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
					</div>
				</div>
				<div class="portfolio-desc">
					<h3><a href="#portfolio-single-video.html">Backpack Contents</a></h3>
					<span><a href="#">UI Elements</a>, <a href="#">Icons</a></span>
				</div>
			</article>
			<article class="portfolio-item pf-graphics">
				<div class="portfolio-image">
					<a href="#portfolio-single.html">
						<img src="{{ asset('images/portfolio/4/8.jpg') }}" alt="Sunset Bulb Glow">
					</a>
					<div class="portfolio-overlay">
						<a href="{{ asset('images/portfolio/full/8.jpg') }}" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
						<a href="#portfolio-single.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
					</div>
				</div>
				<div class="portfolio-desc">
					<h3><a href="#portfolio-single.html">Sunset Bulb Glow</a></h3>
					<span><a href="#">Graphics</a></span>
				</div>
			</article>
		</div>
		<div class="clear"></div>
		<a href="#portfolio-parallax.html" class="button button-full button-dark center tright bottommargin-lg">
			<div class="container clearfix">
				Full list of our works. <strong>See More</strong> <i class="icon-caret-right" style="top:4px;"></i>
			</div>
		</a>
		<div class="container clearfix">
			<div class="row topmargin-xs bottommargin-sm">
				<div class="heading-block center">
					<h2>We love building ideas into reality</h2>
					<span class="divcenter">Talk to us what you want for your needs.</span>
				</div>
				<div class="col-md-4 col-sm-6 bottommargin">
					<div class="feature-box fbox-right topmargin" data-animate="fadeIn">
						<div class="fbox-icon">
							<a href="#"><i class="icon-line-heart"></i></a>
						</div>
						<h3>Social Media Campaign</h3>
						<p>Stretch your users reach to the max and surprise your users.</p>
					</div>
					<div class="feature-box fbox-right topmargin" data-animate="fadeIn" data-delay="200">
						<div class="fbox-icon">
							<a href="#"><i class="icon-line-paper"></i></a>
						</div>
						<h3>Creative Media</h3>
						<p>Developing ideas and we will get your Creative Media.</p>
					</div>
					<div class="feature-box fbox-right topmargin" data-animate="fadeIn" data-delay="400">
						<div class="fbox-icon">
							<a href="#"><i class="icon-line-layers"></i></a>
						</div>
						<h3>Website &amp; Microsite</h3>
						<p>
							Service oriented site that scales &amp; allows the world to get know you better
						</p>
					</div>
				</div>
				<div class="col-md-4 hidden-sm bottommargin center">
					<img src="{{ asset('images/services/responsive.png') }}" alt="responsive">
				</div>
				<div class="col-md-4 col-sm-6 bottommargin">
					<div class="feature-box topmargin" data-animate="fadeIn">
						<div class="fbox-icon">
							<a href="#"><i class="icon-line-power"></i></a>
						</div>
						<h3>Offline &amp; Online</h3>
						<p>We provides support for your campaign offline and online.</p>
					</div>
					<div class="feature-box topmargin" data-animate="fadeIn" data-delay="200">
						<div class="fbox-icon">
							<a href="#"><i class="icon-line-check"></i></a>
						</div>
						<h3>Digital Marketing</h3>
						<p>Get your brand campaign on digitalized world.</p>
					</div>
					<div class="feature-box topmargin" data-animate="fadeIn" data-delay="400">
						<div class="fbox-icon">
							<a href="#"><i class="icon-bulb"></i></a>
						</div>
						<h3>Collaborate ideas</h3>
						<p>You have the ideas and we can accelerate and optimized it.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row clearfix common-height hide">
			<div class="col-md-6 center col-padding" style="background: url('{{ asset("images/services/main-bg_.jpg") }}') center center no-repeat; background-size: cover;">
				<div>&nbsp;</div>
			</div>
			<div class="col-md-6 center col-padding" style="background-color: #F5F5F5;">
				<div>
					<div class="heading-block nobottomborder">
						<span class="before-heading color">Easily Understandable &amp; Customizable.</span>
						<h3>Walkthrough Videos &amp; Demos</h3>
					</div>
					<div class="center bottommargin">
						<a href="http://vimeo.com/101373765" data-lightbox="iframe" style="position: relative;">
							<img src="images/services/video.jpg" alt="Video">
							<span class="i-overlay nobg"><img src="{{ asset('images/icons/video-play.png') }}" alt="Play"></span>
						</a>
					</div>
					<p class="lead nobottommargin">There’s a lot of work we can do to improve customization in WordPress leading up to the convergence with editing.
What do you think makes a great site building and customization experience? Outside of WordPress, what are your favorite tools and services for making sites? What makes them great?</p>
				</div>
			</div>
		</div>
		<div class="row clearfix bottommargin-lg common-height hide">
			<div class="col-md-3 col-sm-6 dark center col-padding" style="background-color: #515875;">
				<div>
					<i class="i-plain i-xlarge divcenter icon-line2-directions"></i>
					<div class="counter counter-lined"><span data-from="100" data-to="846" data-refresh-interval="50" data-speed="2000"></span>K</div>
					<h5>Lines of Codes</h5>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 dark center col-padding" style="background-color: #576F9E;">
				<div>
					<i class="i-plain i-xlarge divcenter icon-line2-graph"></i>
					<div class="counter counter-lined"><span data-from="3000" data-to="21500" data-refresh-interval="100" data-speed="2500"></span></div>
					<h5>KBs of HTML Files</h5>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 dark center col-padding" style="background-color: #6697B9;">
				<div>
					<i class="i-plain i-xlarge divcenter icon-line2-layers"></i>
					<div class="counter counter-lined"><span data-from="10" data-to="408" data-refresh-interval="25" data-speed="3500"></span></div>
					<h5>No. of Meetings</h5>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 dark center col-padding" style="background-color: #88C3D8;">
				<div>
					<i class="i-plain i-xlarge divcenter icon-line2-clock"></i>
					<div class="counter counter-lined"><span data-from="60" data-to="1400" data-refresh-interval="30" data-speed="2700"></span></div>
					<h5>Hours of Coding</h5>
				</div>
			</div>
		</div>
		<div class="container clearfix hide">
			<div class="col_one_third">
				<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn">
					<div class="fbox-icon">
						<a href="#"><i class="icon-line-monitor"></i></a>
					</div>
					<h3>Responsive Layout</h3>
					<p>Powerful Layout with Responsive functionality that can be adapted to any screen size.</p>
				</div>
			</div>
			<div class="col_one_third">
				<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="200">
					<div class="fbox-icon">
						<a href="#"><i class="icon-line-eye"></i></a>
					</div>
					<h3>Retina Ready Graphics</h3>
					<p>Looks beautiful &amp; ultra-sharp on Retina Displays with Retina Icons, Fonts &amp; Images.</p>
				</div>
			</div>
			<div class="col_one_third col_last">
				<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="400">
					<div class="fbox-icon">
						<a href="#"><i class="icon-line-star"></i></a>
					</div>
					<h3>Powerful Performance</h3>
					<p>Optimized code that are completely customizable and deliver unmatched fast performance.</p>
				</div>
			</div>
			<div class="clear"></div>
			<div class="col_one_third">
				<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="600">
					<div class="fbox-icon">
						<a href="#"><i class="icon-line-play"></i></a>
					</div>
					<h3>HTML5 Video</h3>
					<p>Canvas provides support for Native HTML5 Videos that can be added to a Full Width Background.</p>
				</div>
			</div>
			<div class="col_one_third">
				<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="800">
					<div class="fbox-icon">
						<a href="#"><i class="icon-params"></i></a>
					</div>
					<h3>Parallax Support</h3>
					<p>Display your Content attractively using Parallax Sections that have unlimited customizable areas.</p>
				</div>
			</div>
			<div class="col_one_third col_last">
				<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="1000">
					<div class="fbox-icon">
						<a href="#"><i class="icon-line-circle-check"></i></a>
					</div>
					<h3>Endless Possibilities</h3>
					<p>Complete control on each &amp; every element that provides endless customization possibilities.</p>
				</div>
			</div>
			<div class="clear"></div>
			<div class="col_one_third bottommargin-sm">
				<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="600">
					<div class="fbox-icon">
						<a href="#"><i class="icon-bulb"></i></a>
					</div>
					<h3>Light &amp; Dark Color Schemes</h3>
					<p>Change your Website's Primary Scheme instantly by simply adding the dark class to the body.</p>
				</div>
			</div>
			<div class="col_one_third bottommargin-sm">
				<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="800">
					<div class="fbox-icon">
						<a href="#"><i class="icon-heart2"></i></a>
					</div>
					<h3>Boxed &amp; Wide Layouts</h3>
					<p>Stretch your Website to the Full Width or make it boxed to surprise your visitors.</p>
				</div>
			</div>
			<div class="col_one_third bottommargin-sm col_last">
				<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="1000">
					<div class="fbox-icon">
						<a href="#"><i class="icon-note"></i></a>
					</div>
					<h3>Extensive Documentation</h3>
					<p>We have covered each &amp; everything in our Documentation including Videos &amp; Screenshots.</p>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="container clearfix">
			<div class="col_one_third bottommargin-sm center">
				<img data-animate="fadeInLeft" src="{{ asset('images/services/responsive2.png') }}" alt="responsive2">
			</div>
			<div class="col_two_third bottommargin-sm col_last">
				<div class="heading-block topmargin-sm">
					<h3>Optimized for Mobile &amp; Touch Enabled Devices.</h3>
				</div>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero quod consequuntur quibusdam, enim expedita sed quia nesciunt incidunt accusamus necessitatibus modi adipisci officia libero accusantium esse hic, obcaecati, ullam, laboriosam!</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti vero, animi suscipit id facere officia. Aspernatur, quo, quos nisi dolorum aperiam fugiat deserunt velit rerum laudantium cum magnam.</p>
				<a href="#" class="button button-border button-dark button-rounded button-large noleftmargin topmargin-sm">Learn more</a>
			</div>
		</div>
		<div class="section parallax dark nobottommargin hide" style="background-image: url('{{ asset("images/services/slider-testi.jpg") }}'); padding: 100px 0;" data-stellar-background-ratio="0.4">			
			<div class="heading-block center">
				<h3>What Clients Say About Us?</h3>
			</div>
			<div class="fslider testimonial testimonial-full" data-animation="fade" data-arrows="false">
				<div class="flexslider">
					<div class="slider-wrap">
						<div class="slide">
							<div class="testi-image">
								<a href="#"><img src="{{ asset('images/testimonials/3.png') }}" alt="Customer Testimonials"></a>
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
									Steve Martin
									<span>Coldplay Inc.</span>
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
									Steve North
									<span>Vivid Inc.</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="section notopmargin notopborder">
			<div class="container clearfix">
				<div class="heading-block center nomargin">
					<h3>Latest from the Blog</h3>
				</div>
			</div>
		</div>
		<div class="container clear-bottommargin clearfix">
			<div class="row">
				@foreach($blogs as $blog)
				<div class="col-md-3 col-sm-6 bottommargin">
					<div class="ipost clearfix">
						@if($blog->image && File::exists(public_path('uploads/'.$blog->image)))
						<div class="entry-image">
							<a href="{{ route('blog.show',$blog->slug) }}"><img class="image_fade" src="{{ asset('uploads/'.$blog->image) }}" alt="Image"></a>
						</div>
						@else
						<div class="entry-image">
							<a href="#"><img class="image_fade" src="{{ asset('images/magazine/thumb/1.jpg') }}" alt="Image"></a>
						</div>
						@endif
						<div class="entry-title">
							<h3><a href="{{route('blog.show',$blog->slug)}}">{{ $blog->name }}</a></h3>
						</div>
						<ul class="entry-meta clearfix">
							<li><i class="icon-calendar3"></i> {{ Carbon::parse($blog->publish_date)->format('jS M Y') }}</li>
							<li><a href="{{ route('blog.category',$blog->category->slug) }}"><i class="icon-folder-open"></i> {{ $blog->category->name }}</a></li>
						</ul>
						<div class="entry-content">
							<p>{{str_limit(strip_tags($blog->description),140)}}</p>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		<div class="section">
			<div class="container clearfix">
				<div class="row topmargin-sm">
					<div class="heading-block center">
						<h3>Meet Our Team</h3>
					</div>
					<div class="col-md-3 col-sm-6 bottommargin">
						<div class="team">
							<div class="team-image">
								<img src="{{ asset('images/team/3.jpg') }}" alt="John Doe">
							</div>
							<div class="team-desc team-desc-bg">
								<div class="team-title"><h4>Assasins Syndicate</h4><span>CEO</span></div>
								<a href="#" class="social-icon inline-block si-small si-light si-rounded si-facebook">
									<i class="icon-facebook"></i>
									<i class="icon-facebook"></i>
								</a>
								<a href="#" class="social-icon inline-block si-small si-light si-rounded si-twitter">
									<i class="icon-twitter"></i>
									<i class="icon-twitter"></i>
								</a>
								<a href="#" class="social-icon inline-block si-small si-light si-rounded si-gplus">
									<i class="icon-gplus"></i>
									<i class="icon-gplus"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 bottommargin">
						<div class="team">
							<div class="team-image">
								<img src="{{ asset('images/team/2.jpg') }}" alt="Josh Clark">
							</div>
							<div class="team-desc team-desc-bg">
								<div class="team-title"><h4>Assasins Brotherhood</h4><span>Co-Founder</span></div>
								<a href="#" class="social-icon inline-block si-small si-light si-rounded si-facebook">
									<i class="icon-facebook"></i>
									<i class="icon-facebook"></i>
								</a>
								<a href="#" class="social-icon inline-block si-small si-light si-rounded si-twitter">
									<i class="icon-twitter"></i>
									<i class="icon-twitter"></i>
								</a>
								<a href="#" class="social-icon inline-block si-small si-light si-rounded si-gplus">
									<i class="icon-gplus"></i>
									<i class="icon-gplus"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 bottommargin">
						<div class="team">
							<div class="team-image">
								<img src="{{ asset('images/team/8.jpg') }}" alt="Mary Jane">
							</div>
							<div class="team-desc team-desc-bg">
								<div class="team-title"><h4>Assasins Rogue</h4><span>Sales</span></div>
								<a href="#" class="social-icon inline-block si-small si-light si-rounded si-facebook">
									<i class="icon-facebook"></i>
									<i class="icon-facebook"></i>
								</a>
								<a href="#" class="social-icon inline-block si-small si-light si-rounded si-twitter">
									<i class="icon-twitter"></i>
									<i class="icon-twitter"></i>
								</a>
								<a href="#" class="social-icon inline-block si-small si-light si-rounded si-gplus">
									<i class="icon-gplus"></i>
									<i class="icon-gplus"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 bottommargin">
						<div class="team">
							<div class="team-image">
								<img src="{{ asset('images/team/4.jpg') }}" alt="Nix Maxwell">
							</div>
							<div class="team-desc team-desc-bg">
								<div class="team-title"><h4>Nix Maxwell</h4><span>Support</span></div>
								<a href="#" class="social-icon inline-block si-small si-light si-rounded si-facebook">
									<i class="icon-facebook"></i>
									<i class="icon-facebook"></i>
								</a>
								<a href="#" class="social-icon inline-block si-small si-light si-rounded si-twitter">
									<i class="icon-twitter"></i>
									<i class="icon-twitter"></i>
								</a>
								<a href="#" class="social-icon inline-block si-small si-light si-rounded si-gplus">
									<i class="icon-gplus"></i>
									<i class="icon-gplus"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container clearfix">
			<div id="oc-clients" class="owl-carousel image-carousel carousel-widget" data-margin="60" data-loop="true" data-nav="false" data-autoplay="5000" data-pagi="false" data-items-xxs="2" data-items-xs="3" data-items-sm="4" data-items-md="5" data-items-lg="6">
				@foreach ($clients as $client)
					@if($client->image && File::exists(public_path('uploads/'.$client->image)))
						<div class="oc-item"><a href="#" title="{{$client->name}}"><img src="{{ asset('uploads/'.$client->image) }}" alt="Clients"></a></div>
					@endif
				@endforeach			
			</div>
		</div>
	</div>
</section>
@stop
