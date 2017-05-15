@extends('layouts.master')

@section('content')

<h1>{{ $career->name }}</h1>
<p class="lead">
@if ($career->image != '')
    <a href="{{ asset('uploads/'.$career->image) }}" target="_blank" title="{{ $career->image }}"/><img src="{{ asset('uploads/'.$career->image) }}" class="pull-left"/></a>
@endif
{{ $career->description }}
</p>
<hr>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('career') }}" class="btn btn-info btn-xs">Back to all careers</a>
    </div>    
</div>

@stop