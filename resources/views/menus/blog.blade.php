@extends('layouts.master')

@section('content')
		<section id="page-title">
			<div class="container clearfix">
				<h1>{{ $menu->name }}</h1>
				<span>{{ $menu->description }}</span>
				<ol class="breadcrumb">
					<li><a href="{{ route('home') }}">Home</a></li>
					<li class="active">Blog</li>
				</ol>
			</div>
		</section>

		<section id="content">
			<div class="content-wrap">
				<div class="container clearfix">
					<div id="posts" class="post-grid grid-container clearfix" data-layout="fitRows">
						@foreach ($blogs as $blog)
						<div class="entry clearfix">
							@if($blog->image)
							<div class="entry-image">
								<a href="{{ asset('uploads/'.$blog->image) }}" data-lightbox="image"><img class="image_fade" src="{{asset('uploads/'.$blog->image)}}" alt="{{ $blog->name }}"></a>
							</div>
							@endif
							<div class="entry-title">
								<h2><a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->name }}</a></h2>
							</div>
							<ul class="entry-meta clearfix">
								<li><i class="icon-calendar3"></i>
									{{ Carbon::parse($blog->publish_date)->format('l, jS M Y') }}
								</li>
								<li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
								<li><a href="#"><i class="icon-camera-retro"></i></a></li>
							</ul>
							<div class="entry-content">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
								<a href="blog-single-full.html" class="more-link">Read More</a>
							</div>
						</div>
						@endforeach
						<div class="entry clearfix">
							<div class="entry-image">
								<a href="images/blog/full/17.jpg" data-lightbox="image"><img class="image_fade" src="images/blog/grid/17.jpg" alt="Standard Post with Image"></a>
							</div>
							<div class="entry-title">
								<h2><a href="blog-single.html">This is a Standard post with a Preview Image</a></h2>
							</div>
							<ul class="entry-meta clearfix">
								<li><i class="icon-calendar3"></i> 10th Feb 2017</li>
								<li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
								<li><a href="#"><i class="icon-camera-retro"></i></a></li>
							</ul>
							<div class="entry-content">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
								<a href="blog-single-full.html" class="more-link">Read More</a>
							</div>
						</div>
						<div class="entry clearfix">
							<div class="entry-image">
								<iframe src="http://player.vimeo.com/video/87701971" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
							</div>
							<div class="entry-title">
								<h2><a href="blog-single-full.html">This is a Standard post with a Vimeo Video</a></h2>
							</div>
							<ul class="entry-meta clearfix">
								<li><i class="icon-calendar3"></i> 16th Feb 2017</li>
								<li><a href="blog-single-full.html#comments"><i class="icon-comments"></i> 19</a></li>
								<li><a href="#"><i class="icon-film"></i></a></li>
							</ul>
							<div class="entry-content">
								<p>Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem consectetur pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt!</p>
								<a href="blog-single-full.html" class="more-link">Read More</a>
							</div>
						</div>
						<div class="entry clearfix">
							<div class="entry-image">
								<div class="fslider" data-arrows="false" data-lightbox="gallery">
									<div class="flexslider">
										<div class="slider-wrap">
											<div class="slide"><a href="images/blog/full/10.jpg" data-lightbox="gallery-item"><img class="image_fade" src="images/blog/grid/10.jpg" alt="Standard Post with Gallery"></a></div>
											<div class="slide"><a href="images/blog/full/20.jpg" data-lightbox="gallery-item"><img class="image_fade" src="images/blog/grid/20.jpg" alt="Standard Post with Gallery"></a></div>
											<div class="slide"><a href="images/blog/full/21.jpg" data-lightbox="gallery-item"><img class="image_fade" src="images/blog/grid/21.jpg" alt="Standard Post with Gallery"></a></div>
										</div>
									</div>
								</div>
							</div>
							<div class="entry-title">
								<h2><a href="blog-single-full.html">This is a Standard post with a Slider Gallery</a></h2>
							</div>
							<ul class="entry-meta clearfix">
								<li><i class="icon-calendar3"></i> 24th Feb 2017</li>
								<li><a href="blog-single.html#comments"><i class="icon-comments"></i> 21</a></li>
								<li><a href="#"><i class="icon-picture"></i></a></li>
							</ul>
							<div class="entry-content">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
								<a href="blog-single.html" class="more-link">Read More</a>
							</div>
						</div>
						<div class="entry clearfix">
							<div class="entry-image clearfix">
								<iframe width="100%" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/115823769&amp;auto_play=false&amp;hide_related=true&amp;visual=true"></iframe>
							</div>
							<div class="entry-title">
								<h2><a href="blog-single.html">This is an Embedded SoundCloud Post</a></h2>
							</div>
							<ul class="entry-meta clearfix">
								<li><i class="icon-calendar3"></i> 28th Apr 2017</li>
								<li><a href="blog-single.html#comments"><i class="icon-comments"></i> 16</a></li>
								<li><a href="#"><i class="icon-music2"></i></a></li>
							</ul>
							<div class="entry-content">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
								<a href="blog-single-full.html" class="more-link">Read More</a>
							</div>
						</div>
						<div class="entry clearfix">
							<div class="entry-image">
								<!--iframe width="560" height="315" src="http://www.youtube.com/embed/SZEflIVnhH8" frameborder="0" allowfullscreen></iframe-->
								<iframe width="560" height="315" src="https://youtube.com/embed/aatr_2MstrI" frameborder="0" allowfullscreen></iframe>
							</div>
							<div class="entry-title">
								<h2><a href="blog-single-full.html">This is a Standard post with a Youtube Video</a></h2>
							</div>
							<ul class="entry-meta clearfix">
								<li><i class="icon-calendar3"></i> 30th Apr 2017</li>
								<li><a href="blog-single-full.html#comments"><i class="icon-comments"></i> 34</a></li>
								<li><a href="#"><i class="icon-film"></i></a></li>
							</ul>
							<div class="entry-content">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
								<a href="blog-single-full.html" class="more-link">Read More</a>
							</div>
						</div>
						<div class="entry clearfix">
							<div class="entry-image clearfix">
								<div class="fslider" data-animation="fade" data-pagi="false" data-lightbox="gallery">
									<div class="flexslider">
										<div class="slider-wrap">
											<div class="slide"><a href="images/blog/full/2.jpg" data-lightbox="gallery-item"><img class="image_fade" src="images/blog/grid/2.jpg" alt="Standard Post with Gallery"></a></div>
											<div class="slide"><a href="images/blog/full/3.jpg" data-lightbox="gallery-item"><img class="image_fade" src="images/blog/grid/3.jpg" alt="Standard Post with Gallery"></a></div>
											<div class="slide"><a href="images/blog/full/12.jpg" data-lightbox="gallery-item"><img class="image_fade" src="images/blog/grid/12.jpg" alt="Standard Post with Gallery"></a></div>
											<div class="slide"><a href="images/blog/full/13.jpg" data-lightbox="gallery-item"><img class="image_fade" src="images/blog/grid/13.jpg" alt="Standard Post with Gallery"></a></div>
										</div>
									</div>
								</div>
							</div>
							<div class="entry-title">
								<h2><a href="blog-single.html">This is a Standard post with Fade Gallery</a></h2>
							</div>
							<ul class="entry-meta clearfix">
								<li><i class="icon-calendar3"></i> 3rd Mar 2017</li>
								<li><a href="blog-single-thumbs.html#comments"><i class="icon-comments"></i> 21</a></li>
								<li><a href="#"><i class="icon-picture"></i></a></li>
							</ul>
							<div class="entry-content">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
								<a href="blog-single-full.html" class="more-link">Read More</a>
							</div>
						</div>
						<div class="entry clearfix">
							<div class="entry-image">
								<a href="images/blog/full/1.jpg" data-lightbox="image"><img class="image_fade" src="images/blog/grid/1.jpg" alt="Standard Post with Image"></a>
							</div>
							<div class="entry-title">
								<h2><a href="blog-single.html">This is a Standard post with another Preview Image</a></h2>
							</div>
							<ul class="entry-meta clearfix">
								<li><i class="icon-calendar3"></i> 5th May 2017</li>
								<li><a href="blog-single.html#comments"><i class="icon-comments"></i> 6</a></li>
								<li><a href="#"><i class="icon-camera-retro"></i></a></li>
							</ul>
							<div class="entry-content">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
								<a href="blog-single-full.html" class="more-link">Read More</a>
							</div>
						</div>
						<div class="entry clearfix">
							<div class="entry-image">
								<iframe frameborder="0" width="480" height="270" src="http://www.dailymotion.com/embed/video/x54uc6c_initial-d-extra-stage-2-preview-trailer_shortfilms" allowfullscreen></iframe>
							</div>
							<div class="entry-title">
								<h2><a href="blog-single-full.html">This is a Standard post with a Dailymotion Video</a></h2>
							</div>
							<ul class="entry-meta clearfix">
								<li><i class="icon-calendar3"></i> 11th May 2017</li>
								<li><a href="blog-single-full.html#comments"><i class="icon-comments"></i> 9</a></li>
								<li><a href="#"><i class="icon-film"></i></a></li>
							</ul>
							<div class="entry-content">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
								<a href="blog-single-full.html" class="more-link">Read More</a>
							</div>
						</div>
					</div><!-- #posts end -->

					<!-- Pagination
					============================================= -->
					<ul class="pagination nobottommargin">
						<li class="disabled"><a href="#">&laquo;</a></li>
						<li class="active"><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li><a href="#">&raquo;</a></li>
					</ul>
				</div>
			</div>
		</section>
@stop
