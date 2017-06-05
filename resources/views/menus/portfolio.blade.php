@extends('layouts.master')

@section('content')

		<section id="page-title">
			<div class="container clearfix">
				<h1>{{ $menu->name }}</h1>
				<span>{{ $menu->description }}</span>
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li class="active">Portfolio</li>
				</ol>
			</div>
		</section>

		<section id="content">
			<div class="content-wrap nopadding">
				<div id="portfolio" class="portfolio portfolio-parallax clearfix">
					<div id="entry-listing">
						<div class="entry">
						@foreach($portfolios as $portfolio)
						<article class="portfolio-item pf-media pf-icons">
							<div class="portfolio-image" style="background-image: url('{{ asset('uploads/'.$portfolio->image) }}');" data-stellar-background-ratio="0.5"><div class="portfolio-overlay"></div></div>
							<div class="portfolio-desc">
								<h3><a href="{{ route('portfolio.show',$portfolio->slug) }}">{{ $portfolio->name }}</a></h3>
								<!--span><a href="#">Media</a>, <a href="#">Icons</a></span-->
								<span>
								<?php
								$i=1;
								$t=count($portfolio->tags);
								foreach ($portfolio->tags as $tags) { ?>
									<a href="javascript:;" title="{{ $tags->name }}">{{ $tags->name }}@if ($i != $t),@endif</a>
									<?php $i++;
								}
								?>
								</span>
								<span><a href="#" title="{{ $portfolio->project->name }}">{{ $portfolio->project->name }}</a></span>
								<div class="portfolio-divider"><div></div></div>
								<span>Client : <a href="#" title="{{ $portfolio->client->name }}">{{ $portfolio->client->name }}</a></span>
							</div>
						</article>
						@endforeach
						</div>
					</div>
					{!! $portfolios->render() !!}
					<!--article class="portfolio-item pf-media pf-icons">
						<div class="portfolio-image" style="background-image: url('images/portfolio/parallax/1.jpg');" data-stellar-background-ratio="0.5"><div class="portfolio-overlay"></div></div>
						<div class="portfolio-desc">
							<h3><a href="portfolio-single.html">Open Imagination</a></h3>
							<span><a href="#">Media</a>, <a href="#">Icons</a></span>
							<div class="portfolio-divider"><div></div></div>
						</div>
					</article>
					<article class="portfolio-item pf-media pf-icons">
						<div class="portfolio-image" style="background-image: url('images/portfolio/parallax/2.jpg');" data-stellar-background-ratio="0.5"><div class="portfolio-overlay"></div></div>
						<div class="portfolio-desc">
							<h3><a href="portfolio-single.html">Locked Steel Gate</a></h3>
							<span><a href="#">Illustrations</a></span>
							<div class="portfolio-divider"><div></div></div>
						</div>
					</article>
					<article class="portfolio-item pf-media pf-icons">
						<div class="portfolio-image" style="background-image: url('images/portfolio/parallax/3.jpg');" data-stellar-background-ratio="0.5"><div class="portfolio-overlay"></div></div>
						<div class="portfolio-desc">
							<h3><a href="portfolio-single-video.html">Mac Sunglasses</a></h3>
							<span><a href="#">Graphics</a>, <a href="#">UI Elements</a></span>
							<div class="portfolio-divider"><div></div></div>
						</div>
					</article>
					<article class="portfolio-item pf-media pf-icons">
						<div class="portfolio-image" style="background-image: url('images/portfolio/parallax/4.jpg');" data-stellar-background-ratio="0.5"><div class="portfolio-overlay"></div></div>
						<div class="portfolio-desc">
							<h3><a href="portfolio-single-gallery.html">Morning Dew</a></h3>
							<span><a href="#"><a href="#">Icons</a>, <a href="#">Illustrations</a></span>
							<div class="portfolio-divider"><div></div></div>
						</div>
					</article>
					<article class="portfolio-item pf-media pf-icons">
						<div class="portfolio-image" style="background-image: url('images/portfolio/parallax/9.jpg');" data-stellar-background-ratio="0.5"><div class="portfolio-overlay"></div></div>
						<div class="portfolio-desc">
							<h3><a href="portfolio-single.html">Bridge Side</a></h3>
							<span><a href="#">Illustrations</a>, <a href="#">Icons</a></span>
							<div class="portfolio-divider"><div></div></div>
						</div>
					</article>
					<article class="portfolio-item pf-media pf-icons">
						<div class="portfolio-image" style="background-image: url('images/portfolio/parallax/6.jpg');" data-stellar-background-ratio="0.5"><div class="portfolio-overlay"></div></div>
						<div class="portfolio-desc">
							<h3><a href="portfolio-single-gallery.html">Shake It!</a></h3>
							<span><a href="#">Illustrations</a>, <a href="#">Graphics</a></span>
							<div class="portfolio-divider"><div></div></div>
						</div>
					</article>
					<article class="portfolio-item pf-media pf-icons">
						<div class="portfolio-image" style="background-image: url('images/portfolio/parallax/7.jpg');" data-stellar-background-ratio="0.5"><div class="portfolio-overlay"></div></div>
						<div class="portfolio-desc">
							<h3><a href="portfolio-single-video.html">Backpack Contents</a></h3>
							<span><a href="#">UI Elements</a>, <a href="#">Icons</a></span>
							<div class="portfolio-divider"><div></div></div>
						</div>
					</article>
					<article class="portfolio-item pf-media pf-icons">
						<div class="portfolio-image" style="background-image: url('images/portfolio/parallax/10.jpg');" data-stellar-background-ratio="0.5"><div class="portfolio-overlay"></div></div>
						<div class="portfolio-desc">
							<h3><a href="portfolio-single-video.html">Study Table</a></h3>
							<span><a href="#">Graphics</a>, <a href="#">Media</a></span>
							<div class="portfolio-divider"><div></div></div>
						</div>
					</article-->
				</div>
			</div>
		</section>
@stop
