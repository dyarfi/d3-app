@extends('Auth::layouts.template')
{{-- Page content --}}
@section('body')
<div class="page-header">
	<h1>Teams <span class="pull-right"><a href="{{ route('admin.teams.invitation') }}" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-envelope"></span> Send Invitations</a> <a href="{{ route('admin.teams.create') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span> Create</a></span>{{$junked ? ' &raquo; Trashed' :''}}</h1>
</div>
@if($deleted)
<div class="pull-right">
	<a href="{{route('admin.teams.index','path=trashed')}}" title="Restored Deleted"><span class="fa fa-trash"></span> {{ $deleted }} Deleted</a>
</div>
@endif
@if ($rows)
<!--small class="grey">@if ($rows) Page {{ @$rows->currentPage() }} of {{ @$rows->lastPage() }} @endif</small-->
<table class="table table-bordered table-hover">
	<thead>
		<th class="col-lg-2">Name</th>
		<th class="col-lg-2">Created At</th>
		<th class="col-lg-2">Updated At</th>
		<th class="col-lg-4">Teams</a>
		<th class="col-lg-4">Actions</th>
	</thead>
	<tbody>
		@foreach ($rows as $row)
		<tr class="{{ $row->deleted_at ? ' bg-warning' :'' }}">
			<td>
				{{ $row->name }}
				@if($row->owner )
					<small class="label label-info label-sm clearfix">Owner : {{ $row->owner->first_name.' '.$row->owner->last_name}}</small>
				@endif
			</td>
			<td>
				<!-- {{ Carbon::parse($row->created_at)->format('l, jS M Y') }} -->
				{{ $row->created_at }}
				<!--
				{!! (!empty($row->permissions['admin']) && $row->permissions['admin'] === true) ? '<span class="label label-success arrowed-in arrowed-in-right"><span class="fa fa-user fa-sm"></span> Superadmin</span>'
				: '<span class="label label-danger arrowed-in arrowed-in-right"><span class="fa fa-ban fa-sm"></span> General</span>' !!}</td>
				-->
			</td>
			<td>
				{{ $row->created_at }}
			</td>
			<td>
				<?php
				//print_r($row->users->count());
				foreach ($row->users as $user) {
					echo '<a style="margin-bottom:2px;margin-right:2px;" href="'.route('admin.users.show',$user->id).'" class="btn btn-info btn-xs"><span class="fa fa-user fa-1x"></span>&nbsp;';
					if($user->first_name && $user->last_name) {
						echo $user->first_name.' '.$user->last_name;
					} else {
						echo $user->email;
					}
					echo '</a>';
				}
				?>
				<!--span class="label label-info">
					@if(!empty($row->permissions['admin']) && $row->permissions['admin'] == true)
						[{{ ucwords(implode(', ', array_keys($row->permissions))) }}]
					@else
						NO ADMIN
						@if(is_array($row->permissions) && count($row->permissions) > 1)
							-
							@foreach($row->permissions as $permission => $access)
								@if ($access === true)
									[{{ ucwords($permission) }}]
								@endif
							@endforeach
						@endif
					@endif
				</span-->
				<div class="space-2"></div>
				<a href="{{ route('admin.teams.invite', $row->id) }}" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-envelope"></span> Invite User</a>
			</td>
			<td>
				<div class="btn-group">
					@if (!$row->deleted_at)
					<a data-rel="tooltip" data-original-title="View" title="" href="{{ route('admin.teams.show', $row->id) }}" class="btn btn-xs btn-success tooltip-default">
						<i class="ace-icon fa fa-check bigger-120"></i>
					</a>
					<a data-rel="tooltip" data-original-title="Edit"  href="{{ route('admin.teams.edit', $row->id) }}" class="btn btn-xs btn-info tooltip-default">
						<i class="ace-icon fa fa-pencil bigger-120"></i>
					</a>
					<a data-rel="tooltip" data-original-title="Trashed"  href="{{ route('admin.teams.trash', $row->id) }}" class="btn btn-xs btn-danger tooltip-default">
						<i class="ace-icon fa fa-trash-o bigger-120"></i>
					</a>
					<!--a data-rel="tooltip" data-original-title="Permanent Delete" href="" class="btn btn-xs btn-warning tooltip-default">
						<i class="ace-icon fa fa-flag bigger-120"></i>
					</a-->
					@else
						<a data-rel="tooltip" data-original-title="Restore!" href="{{route('admin.teams.restored', $row->id)}}" class="btn btn-xs btn-primary tooltip-default">
							<i class="ace-icon fa fa-save bigger-120"></i>
						</a>
						<a title="Permanent Delete!" href="{{route('admin.teams.delete', $row->id)}}" class="btn btn-xs btn-danger">
							<i class="ace-icon fa fa-trash bigger-120"></i>
						</a>
					@endif
				</div>

			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<!--small class="grey">@if ($rows) Page {{ @$rows->currentPage() }} of {{ @$rows->lastPage() }} @endif</small-->
<div class="pull-right">
	{!! $rows->render() !!}
</div>
@else
<br><br>
<div class="well">
	Nothing to show here.
</div>
@endif

@stop
