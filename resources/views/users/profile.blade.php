@extends('layouts.master')

@section('content')

<h1>{{ $user->name }}</h1>
<hr>
<div class="container-fluid">
		<p class="lead">Joined : {{ $user->created_at }}</p>
		@if (count($user->provider) === 1)
	    	<p class="lead">Register with : {{ $user->provider }}</p>
		@else
		    You don't have any providers!
		@endif 

		<div class="row">
			{!! Form::open([
				'method' => 'PATCH',
		       	'route' => ['profile.update', $user->id]
			]) !!}

			<div class="form-group">
				<div class="col-md-3">
			    {!! Form::label('username', 'Username:', ['class' => 'control-label']) !!}
			    {!! Form::text('username', $user->username, ['class' => 'form-control']) !!}
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3">
				    {!! Form::label('first_name', 'First Name:', ['class' => 'control-label']) !!}
				    {!! Form::text('first_name', $user->first_name, ['class' => 'form-control']) !!}
				</div>
				<div class="col-md-3">			   
			    	{!! Form::label('last_name', 'Last Name:', ['class' => 'control-label']) !!}
			    	{!! Form::text('last_name', $user->last_name, ['class' => 'form-control']) !!}
		    	</div>		
			</div>

			<div class="form-group">
				<div class="col-md-12">			
			    	{!! Form::label('about', 'About:', ['class' => 'control-label']) !!}
			    	{!! Form::textarea('about', $user->about, ['class' => 'form-control']) !!}
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12">	
				{!! Form::submit('Update Profile', ['class' => 'btn btn-primary btn-xs']) !!}
				</div>
			</div>
			
			{!! Form::close() !!}
		</div>

</div>

@stop