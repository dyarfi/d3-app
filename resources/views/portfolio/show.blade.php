@extends('layouts.master')

@section('content')
		<section id="page-title">
			<div class="container clearfix">
				<h1>Portfolio - {{ $portfolio->name }}</h1>
				<div id="portfolio-navigation">
					<a href="#"><i class="icon-angle-left"></i></a>
					<a href="#"><i class="icon-line-grid"></i></a>
					<a href="#"><i class="icon-angle-right"></i></a>
				</div>
			</div>
		</section>
		<section id="content">
			<div class="content-wrap">
				<div class="container clearfix">
					<div class="col_two_third portfolio-single-image nobottommargin">
						<a href="#"><img src="{{ asset('uploads/1200x1200px_'.$portfolio->image) }}" alt=""></a>
					</div>
					<div class="col_one_third portfolio-single-content col_last nobottommargin">
						<div class="fancy-title title-bottom-border">
							<h2>Project Info:</h2>
						</div>
                        {{ $portfolio->description }}
						<!--p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis, dolores, facere, corrupti delectus ex quidem adipisci tempore.</p>
						<p>Illum molestias cupiditate eveniet dolore obcaecati voluptatibus est quos eos id recusandae officia. Cupiditate, voluptates quibusdam ipsum vel corporis laboriosam id est doloremque?</p-->
						<div class="line"></div>
						<ul class="portfolio-meta bottommargin">
							<li><span><i class="icon-user"></i>Created by:</span> Nick North</li>
							<li><span><i class="icon-calendar3"></i>Completed on:</span> 17th March 2017</li>
							<li><span><i class="icon-lightbulb"></i>Skills:</span> HTML5 / PHP / CSS3</li>
							<li><span><i class="icon-link"></i>Client:</span> <a href="#">{{ $portfolio->client->name }}</a></li>
						</ul>
						<div class="si-share clearfix">
							<span>Share:</span>
							<div>
								<a href="#" class="social-icon si-borderless si-facebook">
									<i class="icon-facebook"></i>
									<i class="icon-facebook"></i>
								</a>
								<a href="#" class="social-icon si-borderless si-twitter">
									<i class="icon-twitter"></i>
									<i class="icon-twitter"></i>
								</a>
								<a href="#" class="social-icon si-borderless si-pinterest">
									<i class="icon-pinterest"></i>
									<i class="icon-pinterest"></i>
								</a>
								<a href="#" class="social-icon si-borderless si-gplus">
									<i class="icon-gplus"></i>
									<i class="icon-gplus"></i>
								</a>
								<a href="#" class="social-icon si-borderless si-rss">
									<i class="icon-rss"></i>
									<i class="icon-rss"></i>
								</a>
								<a href="#" class="social-icon si-borderless si-email3">
									<i class="icon-email3"></i>
									<i class="icon-email3"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="clear"></div>
					<div class="divider divider-center"><i class="icon-circle"></i></div>
					<h4>Related Projects:</h4>
					<div id="related-portfolio" class="owl-carousel portfolio-carousel carousel-widget" data-margin="20" data-nav="false" data-autoplay="5000" data-items-xxs="1" data-items-xs="2" data-items-sm="3" data-items-lg="4">
						<div class="oc-item">
							<div class="iportfolio">
								<div class="portfolio-image">
									<a href="portfolio-single.html">
										<img src="images/portfolio/4/1.jpg" alt="Open Imagination">
									</a>
									<div class="portfolio-overlay">
										<a href="images/portfolio/full/1.jpg" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
										<a href="portfolio-single.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
								<div class="portfolio-desc">
									<h3><a href="portfolio-single.html">Open Imagination</a></h3>
									<span><a href="#">Media</a>, <a href="#">Icons</a></span>
								</div>
							</div>
						</div>
						<div class="oc-item">
							<div class="iportfolio">
								<div class="portfolio-image">
									<a href="portfolio-single.html">
										<img src="images/portfolio/4/2.jpg" alt="Locked Steel Gate">
									</a>
									<div class="portfolio-overlay">
										<a href="images/portfolio/full/2.jpg" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
										<a href="portfolio-single.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
								<div class="portfolio-desc">
									<h3><a href="portfolio-single.html">Locked Steel Gate</a></h3>
									<span><a href="#">Illustrations</a></span>
								</div>
							</div>
						</div>
						<div class="oc-item">
							<div class="iportfolio">
								<div class="portfolio-image">
									<a href="#">
										<img src="images/portfolio/4/3.jpg" alt="Mac Sunglasses">
									</a>
									<div class="portfolio-overlay">
										<a href="http://vimeo.com/89396394" class="left-icon" data-lightbox="iframe"><i class="icon-line-play"></i></a>
										<a href="portfolio-single-video.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
								<div class="portfolio-desc">
									<h3><a href="portfolio-single-video.html">Mac Sunglasses</a></h3>
									<span><a href="#">Graphics</a>, <a href="#">UI Elements</a></span>
								</div>
							</div>
						</div>
						<div class="oc-item">
							<div class="iportfolio">
								<div class="portfolio-image">
									<a href="#">
										<img src="images/portfolio/4/4.jpg" alt="Mac Sunglasses">
									</a>
									<div class="portfolio-overlay" data-lightbox="gallery">
										<a href="images/portfolio/full/4.jpg" class="left-icon" data-lightbox="gallery-item"><i class="icon-line-stack-2"></i></a>
										<a href="images/portfolio/full/4-1.jpg" class="hidden" data-lightbox="gallery-item"></a>
										<a href="portfolio-single-gallery.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
								<div class="portfolio-desc">
									<h3><a href="portfolio-single-gallery.html">Morning Dew</a></h3>
									<span><a href="#"><a href="#">Icons</a>, <a href="#">Illustrations</a></span>
								</div>
							</div>
						</div>
						<div class="oc-item">
							<div class="iportfolio">
								<div class="portfolio-image">
									<a href="portfolio-single.html">
										<img src="images/portfolio/4/5.jpg" alt="Console Activity">
									</a>
									<div class="portfolio-overlay">
										<a href="images/portfolio/full/5.jpg" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
										<a href="portfolio-single.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
								<div class="portfolio-desc">
									<h3><a href="portfolio-single.html">Console Activity</a></h3>
									<span><a href="#">UI Elements</a>, <a href="#">Media</a></span>
								</div>
							</div>
						</div>
						<div class="oc-item">
							<div class="iportfolio">
								<div class="portfolio-image">
									<a href="portfolio-single-gallery.html">
										<img src="images/portfolio/4/6.jpg" alt="Shake It!">
									</a>
									<div class="portfolio-overlay" data-lightbox="gallery">
										<a href="images/portfolio/full/6.jpg" class="left-icon" data-lightbox="gallery-item"><i class="icon-line-stack-2"></i></a>
										<a href="images/portfolio/full/6-1.jpg" class="hidden" data-lightbox="gallery-item"></a>
										<a href="images/portfolio/full/6-2.jpg" class="hidden" data-lightbox="gallery-item"></a>
										<a href="images/portfolio/full/6-3.jpg" class="hidden" data-lightbox="gallery-item"></a>
										<a href="portfolio-single-gallery.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
								<div class="portfolio-desc">
									<h3><a href="portfolio-single-gallery.html">Shake It!</a></h3>
									<span><a href="#">Illustrations</a>, <a href="#">Graphics</a></span>
								</div>
							</div>
						</div>
						<div class="oc-item">
							<div class="iportfolio">
								<div class="portfolio-image">
									<a href="portfolio-single-video.html">
										<img src="images/portfolio/4/7.jpg" alt="Backpack Contents">
									</a>
									<div class="portfolio-overlay">
										<a href="http://www.youtube.com/watch?v=kuceVNBTJio" class="left-icon" data-lightbox="iframe"><i class="icon-line-play"></i></a>
										<a href="portfolio-single-video.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
								<div class="portfolio-desc">
									<h3><a href="portfolio-single-video.html">Backpack Contents</a></h3>
									<span><a href="#">UI Elements</a>, <a href="#">Icons</a></span>
								</div>
							</div>
						</div>
						<div class="oc-item">
							<div class="iportfolio">
								<div class="portfolio-image">
									<a href="portfolio-single.html">
										<img src="images/portfolio/4/8.jpg" alt="Sunset Bulb Glow">
									</a>
									<div class="portfolio-overlay">
										<a href="images/portfolio/full/8.jpg" class="left-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
										<a href="portfolio-single.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
								<div class="portfolio-desc">
									<h3><a href="portfolio-single.html">Sunset Bulb Glow</a></h3>
									<span><a href="#">Graphics</a></span>
								</div>
							</div>
						</div>
						<div class="oc-item">
							<div class="iportfolio">
								<div class="portfolio-image">
									<a href="portfolio-single.html">
										<img src="images/portfolio/4/9.jpg" alt="Bridge Side">
									</a>
									<div class="portfolio-overlay" data-lightbox="gallery">
										<a href="images/portfolio/full/9.jpg" class="left-icon" data-lightbox="gallery-item"><i class="icon-line-stack-2"></i></a>
										<a href="images/portfolio/full/9-1.jpg" class="hidden" data-lightbox="gallery-item"></a>
										<a href="images/portfolio/full/9-2.jpg" class="hidden" data-lightbox="gallery-item"></a>
										<a href="portfolio-single-gallery.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
								<div class="portfolio-desc">
									<h3><a href="portfolio-single.html">Bridge Side</a></h3>
									<span><a href="#">Illustrations</a>, <a href="#">Icons</a></span>
								</div>
							</div>
						</div>
						<div class="oc-item">
							<div class="iportfolio">
								<div class="portfolio-image">
									<a href="portfolio-single-video.html">
										<img src="images/portfolio/4/10.jpg" alt="Study Table">
									</a>
									<div class="portfolio-overlay">
										<a href="http://vimeo.com/91973305" class="left-icon" data-lightbox="iframe"><i class="icon-line-play"></i></a>
										<a href="portfolio-single-video.html" class="right-icon"><i class="icon-line-ellipsis"></i></a>
									</div>
								</div>
								<div class="portfolio-desc">
									<h3><a href="portfolio-single-video.html">Study Table</a></h3>
									<span><a href="#">Graphics</a>, <a href="#">Media</a></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

@stop
