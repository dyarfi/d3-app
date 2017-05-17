@extends('Auth::layouts.template')

@section('body')

<h1>{{ $row->name }}</h1>
<p class="lead">
@if ($row->image != '')
<div class="container clearfix">
    <a href="{{ asset('uploads/'.$row->image) }}" target="_blank" title="{{ $row->image }}"/>
        <img src="{{ asset('uploads/'.$row->image) }}" class="img-responsive"/>
    </a>
</div>    
@endif
<div class="container clearfix">
    <div class="col-md-12">
        <h3>Description</h3>
        {!! $row->description !!}
    </div>
    <div class="col-md-12">
        <h3>Requirement</h3>
        {!! $row->requirement !!}
    </div>
    <div class="col-md-12">
        <h3>Responsibility</h3>
        {!! $row->responsibility !!}
    </div>
    <div class="col-md-12">
        <h3>Facility</h3>
        {!! $row->facility !!}
    </div>
</div>

</p>
<hr>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('admin.careers.index') }}" class="btn btn-info btn-xs">Back to all careers</a>
        <a href="{{ route('admin.careers.edit', $row->id) }}" class="btn btn-primary btn-xs">Edit Career</a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['admin.careers.trash', $row->id]
        ]) !!}
            {!! Form::submit('Delete this career?', ['class' => 'btn btn-danger btn-xs']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop
