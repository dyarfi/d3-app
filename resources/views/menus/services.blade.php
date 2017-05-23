@extends('layouts.master')

@section('content')

		<section id="page-title">
			<div class="container clearfix">
				<h1>{{ $menu->name }}</h1>
				<span>{{ $menu->description }}</span>
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">Pages</a></li>
					<li class="active">Services</li>
				</ol>
			</div>
		</section>

		<section id="content">
			<div class="content-wrap">
				<div class="container clearfix">
					<div class="col_one_third nobottommargin">
						<div class="feature-box media-box">
							<div class="fbox-media">
								<img src="images/services/1.jpg" alt="Why choose Us?">
							</div>
							<div class="fbox-desc">
								<h3>Why choose Us.<span class="subtitle">Because we are Reliable.</span></h3>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi rem, facilis nobis voluptatum est voluptatem accusamus molestiae eaque perspiciatis mollitia.</p>
							</div>
						</div>
					</div>
					<div class="col_one_third nobottommargin">
						<div class="feature-box media-box">
							<div class="fbox-media">
								<img src="images/services/2.jpg" alt="Why choose Us?">
							</div>
							<div class="fbox-desc">
								<h3>Our Mission.<span class="subtitle">To Redefine your Brand.</span></h3>
								<p>Quos, non, esse eligendi ab accusantium voluptatem. Maxime eligendi beatae, atque tempora ullam. Vitae delectus quia, consequuntur rerum molestias quo.</p>
							</div>
						</div>
					</div>
					<div class="col_one_third nobottommargin col_last">
						<div class="feature-box media-box">
							<div class="fbox-media">
								<img src="images/services/3.jpg" alt="Why choose Us?">
							</div>
							<div class="fbox-desc">
								<h3>What we Do.<span class="subtitle">Make our Customers Happy.</span></h3>
								<p>Porro repellat vero sapiente amet vitae quibusdam necessitatibus consectetur, labore totam. Accusamus perspiciatis asperiores labore esse ab accusantium ea modi ut.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="section">
					<div class="container clearfix">
						<div class="heading-block center">
							<h2>Easy Configurable Options.</h2>
							<span>Choose from a wide array of Options for your best matched Customizations</span>
						</div>
						<div class="col_full">
							<img data-animate="fadeIn" class="aligncenter" src="images/services/business.png" alt="business">
						</div>
						<div class="col_one_third nobottommargin">
							<div class="feature-box fbox-plain">
								<div class="fbox-icon">
									<a href="#"><i class="i-alt">1.</i></a>
								</div>
								<h3>Choose a Product.</h3>
								<p>Perferendis, nam. Eum aperiam vel animi beatae corporis dignissimos, molestias, placeat, maxime optio ipsam nostrum atque quidem.</p>
							</div>
						</div>
						<div class="col_one_third nobottommargin">
							<div class="feature-box fbox-plain">
								<div class="fbox-icon">
									<a href="#"><i class="i-alt">2.</i></a>
								</div>
								<h3>Enter Shipping Info.</h3>
								<p>Saepe qui enim at animi. Repellendus, blanditiis doloremque asperiores reprehenderit deleniti. Ipsam nam accusantium ex!</p>
							</div>
						</div>
						<div class="col_one_third nobottommargin col_last">
							<div class="feature-box fbox-plain">
								<div class="fbox-icon">
									<a href="#"><i class="i-alt">3.</i></a>
								</div>
								<h3>Complete your Payment.</h3>
								<p>Necessitatibus accusamus, inventore atque commodi, animi architecto ea sed, suscipit tempora ex deleniti quae. Consectetur, sint velit.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="container clearfix">
					<div class="col_two_fifth topmargin nobottommargin" id="radarChart" style="opacity: 0;">
						<canvas id="radarChartCanvas" width="430" height="300"></canvas>
					</div>
					<div class="col_three_fifth nobottommargin col_last">
						<div class="heading-block">
							<h3>Powerful insights to help grow your business.</h3>
							<span>Reports let you easily track and analyze your product sales, orders, and payments.</span>
						</div>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero quod consequuntur quibusdam, enim expedita sed quia nesciunt incidunt accusamus necessitatibus modi adipisci officia libero accusantium esse hic, obcaecati, ullam, laboriosam!</p>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti vero, animi suscipit id facere officia. Aspernatur, quo, quos nisi dolorum aperiam fugiat deserunt velit rerum laudantium cum magnam excepturi quod, fuga architecto provident, cupiditate delectus voluptate eaque! Sit neque ut eum, voluptatibus odit cum dolorum ipsa voluptates inventore cumque a.</p>
						<a href="#">Learn more &rarr;</a>
					</div>
					<div class="clear"></div><div class="line"></div>
					<div class="col_three_fifth">
						<div class="heading-block">
							<h3>Advanced store statistics.</h3>
							<span>Benchmarking your website's performance helps you make great choices for your business.</span>
						</div>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero quod consequuntur quibusdam, enim expedita sed quia nesciunt incidunt accusamus necessitatibus modi adipisci officia libero accusantium esse hic, obcaecati, ullam, laboriosam!</p>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti vero, animi suscipit id facere officia. Aspernatur, quo, quos nisi dolorum aperiam fugiat deserunt velit rerum laudantium cum magnam excepturi quod, fuga architecto provident, cupiditate delectus voluptate eaque! Sit neque ut eum, voluptatibus odit cum dolorum ipsa voluptates inventore cumque a.</p>
						<a href="#">Learn more &rarr;</a>
					</div>
					<div class="col_two_fifth topmargin col_last" id="doughnutChart" style="opacity: 0;">
						<canvas id="doughnutChartCanvas" width="430" height="300"></canvas>
					</div>
				</div>
				<a class="button button-full center tright topmargin footer-stick">
					<div class="container clearfix">
						Need help with your Business? <strong>Start here</strong> <i class="icon-caret-right" style="top:4px;"></i>
					</div>
				</a>
			</div>
		</section>
@stop
