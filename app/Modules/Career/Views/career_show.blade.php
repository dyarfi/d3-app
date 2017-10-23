@extends('Admin::layouts.template')

@section('body')
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
        <h4 class="red">Name</h4>
        {!! $row->name !!}
    </div>
    <div class="col-md-12">
        <h4 class="red">Description</h4>
        {!! $row->description !!}
    </div>
    <div class="col-md-12">
        <h4 class="red">Requirement</h4>
        {!! $row->requirement !!}
    </div>
    <div class="col-md-12">
        <h4 class="red">Responsibility</h4>
        {!! $row->responsibility !!}
    </div>
    <div class="col-md-12">
        <h4 class="red">Facility</h4>
        {!! $row->facility !!}
    </div>
    @if($row->status)
    <div class="col-md-12">
        <h4 class="red">Status</h4>
        <div class="row-fluid">
            {{ config('setting.status')[$row->status] }}
        </div>
    </div>
    @endif
    @if($row->created_at)
    <div class="col-md-12">
        <h4 class="red">Created At</h4>
        <div class="row-fluid">
            {{ $row->created_at }}
        </div>
    </div>
    @endif
</div>
</p>
<hr>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('admin.careers.index') }}" class="btn btn-info btn-xs">Back to all careers</a>
        <a href="{{ route('admin.careers.edit', $row->id) }}" class="btn btn-primary btn-xs">Edit Career</a>
        <a href="{{ route('admin.careers.create') }}" class="btn btn-warning btn-xs">Create Career</a>
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
