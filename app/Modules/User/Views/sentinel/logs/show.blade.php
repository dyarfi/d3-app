@extends('Admin::layouts.template')

@section('body')
<div class="container-fluid">
    <h3>{{ $row->name }}</h3>
    <h4 class="red">Log</h4>
    <ul class="list-unstyled"><li>{{ ($row->user->email) ? $row->user->email : '-' }}</li></ul>
    <h4 class="red">Description</h4>
    <ul class="list-unstyled">
        <li>
           <?php
            $label = ($row->description == 'processForm') ? 'label-warning' : 'label-success';
            ?>
            @if ($row->description)
                <span class="label {{$label}} label-sm">{{ $row->description }}</span>
            @endif
        </li>
    </ul>    
    <h4 class="red">Request</h4>
    <ul class="list-unstyled">
        <li>
        @if ($row->request)
            URL : {{ $row->request->url }} <br/>
            METHOD : {{ $row->request->method }} <br/>
            QUERY : {{ $row->request->query }} <br/>                            
            IP ADDRESS : {{ $row->request->client_ip }} <br/>
            SSL : {{ $row->request->secure ? 'Yes' : 'No' }} <br/>
            @if($row->request->payload)
            PAYLOAD : [{{$row->request->payload->_token}}]                              
            @endif
            <?php 
            /*
            @if($row->request->payload)
            PAYLOAD : [<a href="javascript:;" onclick="$(this).next('.description').toggleClass('hide');">{{$row->request->payload->_token}}</a>]
                <div class="description hide">
                    @foreach ($row->request->payload as $payload => $value)
                        @if(isset($value))
                        [{{ $payload }}] : {!! $value !!} <br/>
                        @endif
                    @endforeach
                </div>
            @endif
            */ 
            ?>
        @else
            <span class="label label-danger label-sm">No Access</span>
        @endif
        </li>
    </ul>
    <h4 class="red">Logged At</h4>
    @if($row->created_at) {{ $row->created_at }} @else {{ '-' }} @endif
    <div class="space-10"></div>
    <div class="row">
        <div class="col-md-5 col-xs-6">
            <a href="{{ route('admin.logs.index') }}" class="btn btn-info btn-xs">Back to all logs</a>
            {{-- <a href="{{ route('admin.logs.edit', $row->id) }}" class="btn btn-primary btn-xs">Edit Log</a> --}}
            {{-- <a href="{{ route('admin.logs.create') }}" class="btn btn-warning btn-xs">Create Log</a> --}}
        </div>
        <div class="col-md-5 col-xs-6 text-right">
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['admin.logs.trash', $row->id]
            ]) !!}
                {!! Form::submit('Delete this log?', ['class' => 'btn btn-danger btn-xs']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop
