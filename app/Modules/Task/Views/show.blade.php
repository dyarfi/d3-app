@extends('Auth::layouts.template')

@section('body')

<h1>{{ $row->title }}</h1>
<p class="lead">
@if ($row->image != '')
    <a href="{{ asset('uploads/'.$row->image) }}" target="_blank" title="{{ $row->image }}"/>
        <img src="{{ asset('uploads/'.$row->image) }}" class="pull-left img-responsive"/>
    </a>
@endif
{{ $row->description }}
</p>
<hr>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('admin.tasks.index') }}" class="btn btn-info btn-xs">Back to all tasks</a>
        <a href="{{ route('admin.tasks.edit', $row->id) }}" class="btn btn-primary btn-xs">Edit Task</a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['admin.tasks.trash', $row->id]
        ]) !!}
            {!! Form::submit('Delete this task?', ['class' => 'btn btn-danger btn-xs']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop