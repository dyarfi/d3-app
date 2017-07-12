@extends('Auth::layouts.template')

@section('body')

@if($row->name)
<h4 class="red">Name</h4>
<div class="row-fluid">
    {{ $row->name }}
</div>
@endif
@if($row->subject)
<h4 class="red">Subject</h4>
<div class="row-fluid">
    {{ $row->subject }}
</div>
@endif
@if($row->about)
<h4 class="red">Service</h4>
<div class="row-fluid">
    {{ $row->about }}
</div>
@endif
<p class="lead">
@if ($row->image != '')
    <a href="{{ asset('uploads/'.$row->image) }}" target="_blank" title="{{ $row->image }}"/>
        <img src="{{ asset('uploads/'.$row->image) }}" class="pull-left img-responsive"/>
    </a>
@endif
@if($row->description)
<h4 class="red">Message</h4>
<div class="row-fluid">
    {{ $row->description }}
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
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-info btn-xs">Back to all contacts</a>
        <a href="{{ route('admin.contacts.edit', $row->id) }}" class="btn btn-primary btn-xs">Edit Contact</a>
        <a href="{{ route('admin.contacts.create') }}" class="btn btn-warning btn-xs">Create Contact</a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['admin.contacts.trash', $row->id]
        ]) !!}
            {!! Form::submit('Delete this contact?', ['class' => 'btn btn-danger btn-xs']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop
