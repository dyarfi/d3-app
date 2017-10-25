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
    @if($row->category)
    <h4 class="red">Category</h4>
    <div class="row-fluid">
        {{ $row->category->name }}
    </div>
    @endif
    @if($row->image)
    <h4 class="red">Image</h4>
    <div class="row-fluid">
        <img src="{{ asset('uploads/'.$row->image) }}" class="img-responsive"/>
    </div>
    @endif
    @if($row->excerpt)
    <h4 class="red">Excerpt</h4>
    <div class="row-fluid">
        {!! $row->excerpt !!}
    </div>
    @endif
    @if($row->description)
    <h4 class="red">Description</h4>
    <div class="row-fluid">
        {!! $row->description !!}
    </div>
    @endif
    @if($row->tags && count($row->tags) > 0)
    <h4 class="red">Tags</h4>
    <div class="row-fluid">
        @if(count($row->tags) > 1)
            @foreach ($row->tags as $tags)
                <span class="green">{{ $tags->name }}</span><br/>
            @endforeach
        @else
            <span class="green">
                {{ $row->tags[0]->name }}
            </span>
        @endif
    </div>
    @endif
    @if($row->publish_date)
    <h4 class="red">Publish Date</h4>
    <div class="row-fluid">
        {{ $row->publish_date }}
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
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-info btn-xs">Back to all blogs</a>
            <a href="{{ route('admin.blogs.edit', $row->id) }}" class="btn btn-primary btn-xs">Edit Blog</a>
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-warning btn-xs">Create Blog</a>
        </div>
        <div class="col-md-5 col-xs-6 text-right">
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['admin.blogs.trash', $row->id]
            ]) !!}
                {!! Form::submit('Delete this blog?', ['class' => 'btn btn-danger btn-xs']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop
