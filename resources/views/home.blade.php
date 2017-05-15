@extends('layouts.master')

@section('content')

<h1>{{ trans('label.welcome_text') }}</h1>
<p class="lead">
	{{ trans('label.welcome') }}
</p>
<hr>
<?php 
/*
<a href="{{ route('tasks.index') }}" class="btn btn-info btn-xs">View Tasks</a>
<a href="{{ route('tasks.create') }}" class="btn btn-primary btn-xs">Add New Task</a>
*/
?>
@stop