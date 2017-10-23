@extends('Admin::layouts.template')

@section('body')
<div class="container-fluid">
    <h4 class="red">Name</h4>
    <div>{{ $row->name }}</div>
    @if (count($row->users))
        <h4 class="red">Users</h4>
        <div class="row">
            <div class="col-lg-12">
            {!! Form::open(['route'=>['admin.permissions.change',$row->id],'method'=>'POST','class'=>'form-vertical','team'=>'form','id'=>'permissions_update']) !!}
            {!! Form::hidden('team_form',csrf_token()) !!}
            <div class="well well-sm height170">
                <div class="container-fluid">
                    <div class="checkbox-handler">
                        <ul class="list-unstyled">
                        @foreach ($row->users as $users => $user)
                            <li>
                                @if($user->first_name && $user->last_name )
                                <h4 class="row green">{{ $user->first_name .' '.$user->last_name }}</h4>
                                @else
                                <h4 class="row green">{{ $user->email }}</h4>
                                @endif
                                <div class="control-group">
                                    <div class="form-group">
                                        <div class="clearfix">
                                            <label for="">Username
                                                <span class="green clearfix">{{ $user->username }}</span>
                                            </label>
                                        </div>
                                        <div class="clearfix">
                                        <label for="">Email
                                            <span class="green clearfix">{{ $user->email }}</span>
                                        </label>
                                        </div>
                                        <div class="clearfix">
                                        <label for="">Last Login
                                            <span class="green clearfix">{{ $user->last_login }}</span>
                                        </label>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <!--div class="pull-right">{!! Form::submit('Save All Permissions',['class'=>'btn btn-primary btn-sm']) !!}</div-->
            {!! Form::close() !!}
            </div>
        </div>
        <hr/>
    @else
        <!--span class="label label-danger label-sm">No Permissions</span-->
    @endif
    @if(sizeof($row->owner) > 0)
    <h4 class="red">Owner</h4>
    <div>{{ @$row->owner->first_name .' '. @$row->owner->last_name }}</div>
    @endif
    @if(sizeof($row->description) > 0)
    <h4 class="red">Description</h4>
    <div>{!! $row->description !!}</div>
    @endif
    <div class="space-10 clearfix"></div>    
    <div class="row">
        <div class="col-md-5 col-xs-6">
            <a href="{{ route('admin.teams.index') }}" class="btn btn-info btn-xs">Back to all teams</a>
            <a href="{{ route('admin.teams.edit', $row->id) }}" class="btn btn-primary btn-xs">Edit Team</a>
            <a href="{{ route('admin.teams.create') }}" class="btn btn-warning btn-xs">Create Team</a>
        </div>
        <div class="col-md-5 col-xs-6 text-right">
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['admin.teams.trash', $row->id]
            ]) !!}
                {!! Form::submit('Delete this team?', ['class' => 'btn btn-danger btn-xs']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop
