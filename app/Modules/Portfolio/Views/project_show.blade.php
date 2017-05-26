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
    @if($row->project)
    <h4 class="red">Project</h4>
    <div class="row-fluid">
        {{ $row->project->name }}
    </div>
    @endif
    @if($row->description)
    <h4 class="red">Description</h4>
    <div class="row-fluid">
        {{ $row->description }}
    </div>
    @endif
    <hr/>
    <div class="row">
        <div class="col-md-5 col-xs-6">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-info btn-xs">Back to all pages</a>
            <a href="{{ route('admin.pages.edit', $row->id) }}" class="btn btn-primary btn-xs">Edit page</a>
        </div>
        <div class="col-md-5 col-xs-6 text-right">
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['admin.pages.trash', $row->id]
            ]) !!}
                {!! Form::submit('Delete this page?', ['class' => 'btn btn-danger btn-xs']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop
