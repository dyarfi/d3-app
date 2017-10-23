@extends('Admin::layouts.template')

@section('body')

@if($row->name)
<h4 class="red">Name</h4>
<div class="row-fluid">
    {{ $row->name }}
</div>
@endif
@if($row->description)
<h4 class="red">Description</h4>
<div class="row-fluid">
    <p>
        {!! $row->description !!}
    </p>
</div>
@endif
@if ($row->image != '')
<div class="row-fluid">
    <a href="{{ asset('uploads/'.$row->image) }}" target="_blank" title="{{ $row->image }}"/>
        <img src="{{ asset('uploads/'.$row->image) }}" class="pull-left img-responsive"/>
    </a>
    <br><br>
</div>
@endif
@if($row->status)
<h4 class="red">Status</h4>
<div class="row-fluid">
    {{ config('setting.status')[$row->status] }}
</div>
@endif
@if($row->created_at)
<h4 class="red">Created At</h4>
<div class="row-fluid">
    {{ $row->created_at }}
</div>
@endif
<hr>
<div class="row">
    <div class="col-md-6">
        <a href="{{ route('admin.banners.index') }}" class="btn btn-info btn-xs">Back to all banners</a>
        <a href="{{ route('admin.banners.edit', $row->id) }}" class="btn btn-primary btn-xs">Edit Banner</a>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-warning btn-xs">Create Banner</a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['admin.banners.trash', $row->id]
        ]) !!}
            {!! Form::submit('Delete this banner?', ['class' => 'btn btn-danger btn-xs']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop
