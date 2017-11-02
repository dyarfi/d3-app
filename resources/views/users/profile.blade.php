@extends('layouts.master')

@section('content')
@if($user)
<h1>{{ $user->name }}</h1>
@endif
<hr>

<div class="container-fluid">
	<div class="col-lg-12">
		<p class="lead">Boards</p>
		<!-- Nav tabs -->
	  	<ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active">
		    	<a href="#twitter" aria-controls="home" role="tab" data-toggle="tab">
		    		<span class="fa fa-twitter"></span>&nbsp;Twitter
		    	</a>
		    </li>
		    <li role="presentation">
		    	<a href="#facebook" aria-controls="profile" role="tab" data-toggle="tab">
		    		<span class="fa fa-facebook"></span>&nbsp;Facebook
		    	</a>
		    </li>
		    <li role="presentation">
		    	<a href="#instagram" aria-controls="messages" role="tab" data-toggle="tab">
		    		<span class="fa fa-instagram"></span>&nbsp;Instagram
		    	</a>
		    </li>
		    <li role="presentation">
		    	<a href="#google" aria-controls="google" role="tab" data-toggle="tab">
		    		<span class="fa fa-google"></span>&nbsp;Google +
		    	</a>
		    </li>		    
		    <li role="presentation">
		    	<a href="#youtube" aria-controls="google" role="tab" data-toggle="tab">
		    		<span class="fa fa-youtube-play"></span>&nbsp;Youtube
		    	</a>
		    </li>
	  	</ul>
		  <!-- Tab panes -->
	  	<div class="tab-content">
		    <div role="tabpanel" class="tab-pane active" id="twitter">
		    	<div class="container">
		    		<p class="lead"><h4>Twitter Boards</h4></p>
		    		<p class="lead pull-right">Administrator</p>
					<form action="/approve-tweets" method="post">
					{{ csrf_field() }}
					@foreach($tweets as $tweet)
					    <div class="tweet row">
					        <div class="col-xs-8">
					            @include('tweets.tweet')
					        </div>
					        <div class="col-xs-4 approval">
					            <label class="radio-inline">
					                <input
					                    type="radio"
					                    name="approval-status-{{ $tweet->id }}"
					                    value="1"
					                    @if($tweet->approved)
					                    checked="checked"
					                    @endif
					                    >
					                Approved
					            </label>
					            <label class="radio-inline">
					                <input
					                    type="radio"
					                    name="approval-status-{{ $tweet->id }}"
					                    value="0"
					                    @unless($tweet->approved)
					                    checked="checked"
					                    @endif
					                    >
					                Unapproved
					            </label>
					        </div>
					    </div>
					@endforeach

					<div class="row">
					    <div class="col-sm-12">
					        <input type="submit" class="btn btn-primary" value="Approve Tweets">
					    </div>
					</div>

					</form>

					{!! $tweets->links() !!}

		    	</div>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="facebook">
		    	<div class="container">
		    		<p class="lead"><h4>Facebook Boards</h4></p>
		    	</div>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="instagram">
		    	<div class="container">
		    		<p class="lead"><h4>Instagram Boards</h4></p>
		    	</div>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="google">
		    	<div class="container">
		    		<p class="lead"><h4>Google + Boards</h4></p>
		    	</div>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="youtube">
		    	<div class="container">
		    		<p class="lead"><h4>YouTube Boards</h4></p>
		    	</div>
		    </div>
	  	</div>	
	</div>
	<div class="col-lg-6 hidden">
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
</div>

@stop