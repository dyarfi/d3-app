@extends('layouts.master')

@section('content')

<section id="slider" class="slider-parallax swiper_wrapper full-screen clearfix">
	<div class="slider-parallax-inner">
		<div class="swiper-container swiper-parent">
			<div class="swiper-wrapper">
				<div class="swiper-slide" style="background-image: url('{{ asset("images/slider/swiper/1.jpg") }} ');">
					<div class="container clearfix">
						<div class="slider-caption slider-caption-center">
							<h2 data-caption-animate="fadeInUp">Welcome to Dentsu Digital</h2>
							<p data-caption-animate="fadeInUp" data-caption-delay="250">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. &amp; Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
						</div>
					</div>
				</div>
				<div class="swiper-slide dark">
					<div class="container clearfix">
						<div class="slider-caption slider-caption-center">
							<h2 data-caption-animate="fadeInUp">Beautifully Flexible</h2>
							<p data-caption-animate="fadeInUp" data-caption-delay="200">Looks beautiful &amp; ultra-sharp on Retina Screen Displays. Powerful Layout with Responsive functionality that can be adapted to any screen size.</p>
						</div>
					</div>
					<div class="video-wrap">
						<video id="slide-video" poster="{{ asset('images/videos/explore.jpg') }}" preload="auto" loop autoplay muted>
							<!--source src='images/videos/explore.webm' type='video/webm' /-->
							<source src="{{ asset('images/videos/explore.mp4') }}" type='video/mp4' />
						</video>
						<div class="video-overlay" style="background-color: rgba(0,0,0,0.55);"></div>
					</div>
				</div>
				<div class="swiper-slide" style="background-image: url('{{ asset("images/slider/swiper/3.jpg") }}'); background-position: center top;">
					<div class="container clearfix">
						<div class="slider-caption">
							<h2 data-caption-animate="fadeInUp">Great Performance</h2>
							<p data-caption-animate="fadeInUp" data-caption-delay="200">You'll be surprised to see the Final Results of your Creation &amp; would crave for more.</p>
						</div>
					</div>
				</div>
			</div>
			<div id="slider-arrow-left"><i class="icon-angle-left"></i></div>
			<div id="slider-arrow-right"><i class="icon-angle-right"></i></div>
		</div>
		<a href="#" data-scrollto="#content" data-offset="100" class="dark one-page-arrow"><i class="icon-angle-down infinite animated fadeInDown"></i></a>
	</div>
</section>

<section id="content">
	<div class="content-wrap">
		<div class="container clearfix">
			<div class="row clearfix">
				<div class="col-lg-5">
					<div class="heading-block topmargin">
						<h1>Welcome to Dentsu Digital.<br>Award Winning Agency.</h1>
					</div>
					<p class="lead">We scan the horizon of the future to identify emerging social trends and deliver solutions that are a step ahead of the times. Continually reaching ahead, we work as true partners, thinking creatively, to help our clients achieve success.<br><br>We create magic every day... &amp; much more.</p>
				</div>
				<div class="col-lg-7">
					<div style="position: relative; margin-bottom: -60px;" class="ohidden" data-height-lg="426" data-height-md="567" data-height-sm="470" data-height-xs="287" data-height-xxs="183">
						<img src="{{ asset('images/services/main-fbrowser_.png') }}" style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" data-delay="100" alt="Chrome">
						<img src="{{ asset('images/services/main-fmobile_.png') }}" style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" data-delay="400" alt="iPad">
					</div>
				</div>
			</div>
		</div>
		<div class="section nobottommargin">
			<div class="container clear-bottommargin clearfix">
				<div class="row topmargin-sm clearfix">
					<div class="col-md-4 bottommargin">
						<i class="i-plain color i-large icon-line2-screen-desktop inline-block" style="margin-bottom: 15px;"></i>
						<div class="heading-block nobottomborder" style="margin-bottom: 15px;">
							<span class="before-heading">Reach &amp; Target Your Audiences</span>
							<h4>Social Media Marketing</h4>
						</div>
						<p>It's vital that you understand social media marketing fundamentals. From maximizing quality to increasing your online entry points, abiding by these 10 laws will help build a foundation that will serve your customers, your brand and -- perhaps most importantly -- your bottom line.</p>
					</div>
					<div class="col-md-4 bottommargin">
						<i class="i-plain color i-large icon-line2-energy inline-block" style="margin-bottom: 15px;"></i>
						<div class="heading-block nobottomborder" style="margin-bottom: 15px;">
							<span class="before-heading">Digital Analytics</span>
							<h4>Digital Analytics Analysis</h4>
						</div>
						<p>An important component of digital intelligence, digital analytics enables brands and website owners to understand how their sites and apps are being found and used. Using digital analytics data, companies can optimise the customer experience on their websites, mobile sites, and mobile apps, and also optimise their marketing ROI, content offerings, and overall business performance.</p>
					</div>
					<div class="col-md-4 bottommargin">
						<i class="i-plain color i-large icon-line2-equalizer inline-block" style="margin-bottom: 15px;"></i>
						<div class="heading-block nobottomborder" style="margin-bottom: 15px;">
							<span class="before-heading">Digital-first Business Era</span>
							<h4>Digital Business Strategy</h4>
						</div>
						<p>Going mobile, adding analytics, or extending the online experience begs the question what’s next? These investments often changed the form of interaction, with limited change to the function. Transforming the business with digital, particularly in the marketing area, makes sense in the face of changing consumer expectations, options and information.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="container clearfix">
			<div class="row topmargin-lg bottommargin-sm">
				<div class="heading-block center">
					<h2>We love building awesome apps too</h2>
					<span class="divcenter">Transforming your ideas to reality.</span>
				</div>
				<div class="col-md-4 col-sm-6 bottommargin">
					<div class="feature-box fbox-right topmargin" data-animate="fadeIn">
						<div class="fbox-icon">
							<a href="#"><i class="icon-line-heart"></i></a>
						</div>
						<h3>Boxed &amp; Wide Layouts</h3>
						<p>Stretch your Website to the Full Width or make it boxed to surprise your visitors.</p>
					</div>
					<div class="feature-box fbox-right topmargin" data-animate="fadeIn" data-delay="200">
						<div class="fbox-icon">
							<a href="#"><i class="icon-line-paper"></i></a>
						</div>
						<h3>Extensive Documentation</h3>
						<p>We have covered each &amp; everything in our Docs including Videos &amp; Screenshots.</p>
					</div>
					<div class="feature-box fbox-right topmargin" data-animate="fadeIn" data-delay="400">
						<div class="fbox-icon">
							<a href="#"><i class="icon-line-layers"></i></a>
						</div>
						<h3>Parallax Support</h3>
						<p>Display your Content attractively using Parallax Sections with HTML5 Videos.</p>
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
						<h3>HTML5 Video</h3>
						<p>Canvas provides support for Native HTML5 Videos that can be added to a Background.</p>
					</div>
					<div class="feature-box topmargin" data-animate="fadeIn" data-delay="200">
						<div class="fbox-icon">
							<a href="#"><i class="icon-line-check"></i></a>
						</div>
						<h3>Endless Possibilities</h3>
						<p>Complete control on each &amp; every element that provides endless customization.</p>
					</div>
					<div class="feature-box topmargin" data-animate="fadeIn" data-delay="400">
						<div class="fbox-icon">
							<a href="#"><i class="icon-bulb"></i></a>
						</div>
						<h3>Light &amp; Dark Color Schemes</h3>
						<p>Change your Website's Primary Scheme instantly by simply adding the dark class.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row clearfix common-height">
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
		<div class="row clearfix bottommargin-lg common-height">
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
		<div class="container clearfix">
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
		<div class="section topmargin nobottommargin nobottomborder">
			<div class="container clearfix">
				<div class="heading-block center nomargin">
					<h3>Our Latest Works</h3>
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
		<div class="section parallax dark nobottommargin" style="background-image: url('{{ asset("images/services/slider-testi.jpg") }}'); padding: 100px 0;" data-stellar-background-ratio="0.4">
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
				<div class="col-md-3 col-sm-6 bottommargin">
					<div class="ipost clearfix">
						<div class="entry-image">
							<a href="#"><img class="image_fade" src="{{ asset('images/magazine/thumb/1.jpg') }}" alt="Image"></a>
						</div>
						<div class="entry-title">
							<h3><a href="#blog-single.html">Chinese Stocks Erase All Gains for the Year as Crackdown Deepens</a></h3>
						</div>
						<ul class="entry-meta clearfix">
							<li><i class="icon-calendar3"></i> 13th April 2017</li>
							<li><a href="#blog-single.html#comments"><i class="icon-comments"></i> 53</a></li>
						</ul>
						<div class="entry-content">
							<p>Prevention effect, advocate dialogue rural development lifting people up community civil society. Catalyst, grantees leverage.</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 bottommargin">
					<div class="ipost clearfix">
						<div class="entry-image">
							<a href="#"><img class="image_fade" src="{{ asset('images/magazine/thumb/2.jpg') }}" alt="Image"></a>
						</div>
						<div class="entry-title">
							<h3><a href="#blog-single.html">Samsung Rejects Holding Company as Profit Tops Estimates</a></h3>
						</div>
						<ul class="entry-meta clearfix">
							<li><i class="icon-calendar3"></i> 24th Apr 2017</li>
							<li><a href="#blog-single.html#comments"><i class="icon-comments"></i> 17</a></li>
						</ul>
						<div class="entry-content">
							<p>Cross-agency coordination clean water rural, promising development turmoil inclusive education transformative community.</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 bottommargin">
					<div class="ipost clearfix">
						<div class="entry-image">
							<a href="#"><img class="image_fade" src="{{ asset('images/magazine/thumb/3.jpg') }}" alt="Image"></a>
						</div>
						<div class="entry-title">
							<h3><a href="#blog-single.html">Hong Kong's Luxury Homes Are No Longer World's Most Expensive</a></h3>
						</div>
						<ul class="entry-meta clearfix">
							<li><i class="icon-calendar3"></i> 26th Apr 2017</li>
							<li><a href="#blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
						</ul>
						<div class="entry-content">
							<p>Micro-finance; vaccines peaceful contribution citizens of change generosity. Measures design thinking accelerate progress medical initiative.</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 bottommargin">
					<div class="ipost clearfix">
						<div class="entry-image">
							<a href="#"><img class="image_fade" src="{{ asset('images/magazine/thumb/4.jpg') }}" alt="Image"></a>
						</div>
						<div class="entry-title">
							<h3><a href="#blog-single.html">Compassion conflict resolution, progressive; tackle</a></h3>
						</div>
						<ul class="entry-meta clearfix">
							<li><i class="icon-calendar3"></i> 15th Jan 2014</li>
							<li><a href="#blog-single.html#comments"><i class="icon-comments"></i> 54</a></li>
						</ul>
						<div class="entry-content">
							<p>Community health workers best practices, effectiveness meaningful work The Elders fairness. Our ambitions local solutions globalization.</p>
						</div>
					</div>
				</div>
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
				<div class="oc-item"><a href="#"><img src="{{ asset('images/clients/logo/1.png') }}" alt="Clients"></a></div>
				<div class="oc-item"><a href="#"><img src="{{ asset('images/clients/logo/2.png') }}" alt="Clients"></a></div>
				<div class="oc-item"><a href="#"><img src="{{ asset('images/clients/logo/3.png') }}" alt="Clients"></a></div>
				<div class="oc-item"><a href="#"><img src="{{ asset('images/clients/logo/4.png') }}" alt="Clients"></a></div>
				<div class="oc-item"><a href="#"><img src="{{ asset('images/clients/logo/5.png') }}" alt="Clients"></a></div>
				<div class="oc-item"><a href="#"><img src="{{ asset('images/clients/logo/6.png') }}" alt="Clients"></a></div>
				<div class="oc-item"><a href="#"><img src="{{ asset('images/clients/logo/7.png') }}" alt="Clients"></a></div>
				<div class="oc-item"><a href="#"><img src="{{ asset('images/clients/logo/8.png') }}" alt="Clients"></a></div>
				<div class="oc-item"><a href="#"><img src="{{ asset('images/clients/logo/9.png') }}" alt="Clients"></a></div>
				<div class="oc-item"><a href="#"><img src="{{ asset('images/clients/logo/10.png') }}" alt="Clients"></a></div>
			</div>
		</div>
	</div>
</section>
<?php
/*
<a href="{{ route('tasks.index') }}" class="btn btn-info btn-xs">View Tasks</a>
<a href="{{ route('tasks.create') }}" class="btn btn-primary btn-xs">Add New Task</a>
*/
?>
@stop
