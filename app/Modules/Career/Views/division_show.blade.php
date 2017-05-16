@extends('Auth::layouts.template')

@section('body')
<div class="container-fluid">
    <h3>{{ $row->name }}</h3>
    <h4 class="red">Email</h4>
    <ul class="list-unstyled"><li>{{ $row->email }}</li></ul>
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
    @if($row->about)
    <h4 class="red">About</h4>    
    <div class="row-fluid">
        {{ $row->about }}
    </div>
    @endif
    <hr/>
    <div class="row">
        <div class="col-md-5 col-xs-6">
            <a href="{{ route('admin.divisions.index') }}" class="btn btn-info btn-xs">Back to all divisions</a>
            <a href="{{ route('admin.divisions.edit', $row->id) }}" class="btn btn-primary btn-xs">Edit division</a>
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