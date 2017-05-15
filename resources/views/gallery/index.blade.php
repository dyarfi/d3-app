@extends('layouts.master')

@section('content')	
<h1>{{ trans('label.gallery') }} List</h1>
<p class="lead">Welcome to our {{ $menu->description }}<br/>Here's a list of all our image.</p>
<a href="{{ route('gallery.upload') }}" class="btn btn-primary">Upload</a>
<hr/>
<ul id="entry-listing" class="list-inline list-unstyled">
	@if($images->count())
		@foreach($images as $image)
		<li class="entry isotope-item">
		    <div style="width:300px; height:300px; overflow:hidden">
		    	<h3>{{ $image->participant->username }} </h3>		    
		    	<img src="{{ asset('uploads/'.$image->file_name) }}" class="img-responsive"/>
			    <div class="clearfix">
			    	<small><span class="fa fa-check"></span> {{ $image->created_at }}</small>
				</div>
			</div>
		    <!--p>{{ str_limit($image->description, 400,' [...]')}}</p-->
		    <!--p>
		        <a href="{{ url('image/show', $image->slug) }}" class="btn btn-info btn-xs"><span class="fa fa-search"></span> View Career</a>
		        <a href="{{ url('image/apply', $image->slug) }}" class="btn btn-primary btn-xs"><span class="fa fa-upload"></span> Apply Career</a>
		    </p-->
		</li>    
		@endforeach
	@else
		{!! '<li><h4>Not Available at the Moment</h4></li>' !!}
	@endif
</ul>

{!! $images->render() !!}

@stop