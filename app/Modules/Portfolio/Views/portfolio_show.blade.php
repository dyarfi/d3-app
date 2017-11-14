@extends('Admin::layouts.template')

@section('body')
<div class="container-fluid">
    @if($row->name)
    <h4 class="red">Name</h4>
    <ul class="list-unstyled"><li>{{ $row->name }}</li></ul>
    @endif
    @if($row->slug)
    <h4 class="red">Slug</h4>
    <div class="row-fluid">
        {{ $row->slug }}
    </div>
    @endif
    @if($row->image)
    <h4 class="red">Image</h4>
    <div class="row-fluid">
        <img src="{{ asset('uploads/'.$row->image) }}" class="img-responsive"/>
    </div>
    @endif
    @if(sizeof($row->media) > 0)
        <h4 class="red">Gallery</h4>    
        <div class="row-fluid">
        @foreach ($row->media as $media)
            <span class="img-thumbnail media-handler">
                <img src="{{ url($media->getDiskPath()) }}" class="img-responsive"/>
                <a href="javascript:;" class="btn btn-danger btn-xs media-delete" title="Delete Media" data-url="{{route('admin.portfolios.medialist',$row->id)}}" data-id="{{$media->id}}"><span class="fa fa-times"></span></a>
            </span>
        @endforeach
        </div>
    @endif
    @if($row->description)
    <h4 class="red">Description</h4>
    <div class="row-fluid">
        {!! $row->description !!}
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
            <a href="{{ route('admin.portfolios.index') }}" class="btn btn-info btn-xs">Back to all portfolios</a>
            <a href="{{ route('admin.portfolios.edit', $row->id) }}" class="btn btn-primary btn-xs">Edit Portfolio</a>
            <a href="{{ route('admin.portfolios.create') }}" class="btn btn-warning btn-xs">Create Portfolio</a>
        </div>
        <div class="col-md-5 col-xs-6 text-right">
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['admin.portfolios.trash', $row->id]
            ]) !!}
                {!! Form::submit('Delete this portfolio?', ['class' => 'btn btn-danger btn-xs']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop
