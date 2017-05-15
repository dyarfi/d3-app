@extends('layouts.master')

@section('content')
<h1>{{ trans('label.career') }} List</h1>
<p class="lead">Welcome to our {{ $menu->description }}<br/>Here's a list of all our career.</p>
<hr>

<div id="entry-listing" class="container-fluid">
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
</div>

{!! $careers->render() !!}

@stop