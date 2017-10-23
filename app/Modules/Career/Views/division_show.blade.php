@extends('Admin::layouts.template')

@section('body')
<div class="container-fluid">
    @if($row->name)
    <h4 class="red">Name</h4>
    <div class="row-fluid">
        {{ $row->name }}
    </div>
    @endif
    @if($row->phone_number)
    <h4 class="red">Phone Number</h4>
    <div class="row-fluid">
        {{ $row->phone_number }}
    </div>
    @endif
    @if($row->phone_home)
    <h4 class="red">Phone Home</h4>
    <div class="row-fluid">
        {{ $row->phone_home }}
    </div>
    @endif
    @if($row->address)
    <h4 class="red">Address</h4>
    <div class="row-fluid">
        {{ $row->address }}
    </div>
    @endif
    @if($row->description)
    <h4 class="red">Description</h4>
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
    <hr/>
    <div class="row">
        <div class="col-md-5 col-xs-6">
            <a href="{{ route('admin.divisions.index') }}" class="btn btn-info btn-xs">Back to all divisions</a>
            <a href="{{ route('admin.divisions.edit', $row->id) }}" class="btn btn-primary btn-xs">Edit division</a>
            <a href="{{ route('admin.divisions.create') }}" class="btn btn-warning btn-xs">Create Division</a>
        </div>
        <div class="col-md-5 col-xs-6 text-right">
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['admin.divisions.trash', $row->id]
            ]) !!}
                {!! Form::submit('Delete this division?', ['class' => 'btn btn-danger btn-xs']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop
