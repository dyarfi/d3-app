@extends('layouts.master')
@section('content')
	<section id="page-title">
		<div class="container">
			<ol class="breadcrumb clearfix col-md-12">
				<li><a href="{{ route('home') }}">Home</a></li>
				<li><a href="{{ route('blog') }}">Blog </a></li>
				<li><a href="{{ route('blog.tags') }}">Tags </a></li>
				@if(count($tag) === 1)
				<li class="active">{{ str_limit($tag->name,75) }}</li>
				@endif
			</ol>
		</div>
	</section>
	<section id="content">
		<div class="content-wrap">
			<div class="container clearfix">
				@if(count($tag) !== 1)
				<h1 class="clearfix nomargin nopadding">
					Tags :
				</h1>
				<h2 class="clearfix">
					<?php
					$i = 1;
					$n = count($tag);
					foreach ($tag as $val) { ?>
						<a href="{{ route('blog.tag',$val->slug) }}">{{ $val->name . ($i!=$n ? ', ' : '') }}</a>
						<?php
						$i++;
					}
					?>
				</h2>
				@else
				<h1 class="clearfix nopadding">{{ $tag->name }}</h1>
				@endif
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
							<p>{{ str_limit(strip_tags($blog->description),200) }}</p>
							<a href="blog-single-full.html" class="more-link">Read More</a>
						</div>
					</div>
					@endforeach
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
