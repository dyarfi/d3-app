@extends('Auth::layouts.template')

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
        <img src="{{ asset('uploads/'.$row->image) }}" class="img-responsive" />
    </div>
    @endif
    @if($row->description)
    <h4 class="red">Description</h4>
    <div class="row-fluid">
        {{ $row->description }}
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
            <a href="{{ route('admin.blogcategories.index') }}" class="btn btn-info btn-xs">Back to all categories</a>
            <a href="{{ route('admin.blogcategories.edit', $row->id) }}" class="btn btn-primary btn-xs">Edit Category</a>
            <a href="{{ route('admin.blogcategories.create') }}" class="btn btn-warning btn-xs">Create Category</a>
        </div>
        <div class="col-md-5 col-xs-6 text-right">
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['admin.blogcategories.trash', $row->id]
            ]) !!}
                {!! Form::submit('Delete this Category?', ['class' => 'btn btn-danger btn-xs']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop
