@extends('Auth::layouts.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>Permissions</h1>
</div>

@if ($permissions->count())
<div class="pull-right"></div>
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<td class="col-lg-3"><b>Role Name</b></td>
			<td class="col-lg-3"><b>Access Permission</b></td>
			<td class="col-lg-6"><b>Users Permissions</b></td>
		</tr>
	</thead>
	<tbody>
		@foreach ($permissions as $role)
		<tr>
			<td>{{ $role->name }} @if($role->slug) <span class="green" data-placement="right" data-rel="tooltip" data-original-title="Slug">[{{ $role->slug }}]</span> @endif</td>
			<!--td>
				@if($role->users()->count()) <a href="{{route('admin.permissions.edit', $role->id)}}">Add Users ({{ $role->users()->count() }})</a>
				@else
				@endif
			</td-->
			<td>
				@if(is_array($role->permissions))
					@foreach ($role->permissions as $permission => $val)
						<?php
						/*
						@if ($val) {{ ucfirst($permission) }}
						@else <span class="label label-danger label-sm">No Access</span>
						@endif
						*/
						?>
					@endforeach
				@else
					<span class="label label-danger label-sm">No Access</span>
				@endif
				<span class="label label-info" data-placement="top" data-rel="tooltip" data-original-title="View Permission"><span class="fa fa-key"></span> {!! link_to_route('admin.permissions.edit', 'Access Permission', ['id'=>$role->id,'access=role'], ['class'=>'white']) !!}</span>
			</td>
			<td>
				{!! Form::open() !!}
				@if($role->users()->count())
					<?php
						$users = $role->users()->get();
						foreach ($users as $user) {
						?>
							<a href="{{ route('admin.permissions.edit', $user->id .'?access=user') }}" data-placement="top" data-rel="tooltip" data-original-title="View Permissions">
								@if($user->first_name && $user->last_name)
								[{{ $user->first_name }} {{ $user->last_name }}]
								@else
								[{{ $user->email }}]
								@endif
							</a>&nbsp;
						<?php
						}
					?>
				@else
					<a class="label label-warning label-small" href="{{route('admin.users.create','role_id='.$role->id)}}" data-placement="top" data-rel="tooltip" data-original-title="Add User to this Role"><span class="fa fa-users"> </span>&nbsp; Add User</a>
				@endif
				{!! Form::close() !!}
			</td>
			<!--td>
				<a class="btn btn-warning btn-xs" href="{{ URL::to("apanel/permissions/{$role->id}") }}">Edit</a>
				<a class="btn btn-danger btn-xs" href="{{ URL::to("apanel/permissions/{$role->id}/delete") }}">Delete</a>
			</td-->
		</tr>
		@endforeach
	</tbody>
</table>

<div class="pull-right">
</div>
@else
<br><br>
<div class="well">
	Nothing to show here.
</div>
@endif

@stop
