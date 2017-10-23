@extends('Admin::layouts.template')

@section('body')
<div class="container-fluid">
<h1>{{ $setting->name }} <small>{{ ucfirst($setting->group) }} Setting</small></h1>
<div class="lead">
    Name : {{ $setting->name }}
</div>
<div class="lead">
    Value : {{ $setting->value }}
</div>
<div class="lead">
    Description : {{ $setting->description }}
</div>
<div class="lead">
    Help Text : {{ $setting->help_text }}
</div>
<hr>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('admin.settings.index') }}" class="btn btn-info btn-xs">Back to all settings</a>
        <a href="{{ route('admin.settings.edit', $setting->id) }}" class="btn btn-primary btn-xs">Edit setting</a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['admin.settings.trash', $setting->id]
        ]) !!}
            {!! Form::submit('Delete this setting?', ['class' => 'btn btn-danger btn-xs']) !!}
        {!! Form::close() !!}
    </div>
</div>
</div>
@stop
