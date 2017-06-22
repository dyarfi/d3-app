@extends('Auth::layouts.template')

{{-- Page content --}}
@section('body')
<div class="page-header">
	<h1>Roles <span class="pull-right"><a href="{{ route('admin.roles.create') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span> Create</a></span>{{$junked ? ' &raquo; Trashed' :''}}</h1>
</div>
@if($deleted)
<div class="pull-right">
	<a href="{{route('admin.roles.index','path=trashed')}}" title="Restored Deleted"><span class="fa fa-trash"></span> {{ $deleted }} Deleted</a>
</div>
@endif
@if ($rows->count())
<small class="grey">@if ($rows->count()) Page {{ @$rows->currentPage() }} of {{ @$rows->lastPage() }} @endif</small>
<table class="table table-bordered table-hover">
	<thead>
		<th class="col-lg-2">Name</th>
		<th class="col-lg-2">Slug</th>
		<th class="col-lg-1">Permission</th>
		<th class="col-lg-5">Access Page</a>
		<th class="col-lg-4">Actions</th>
	</thead>
	<tbody>
		@foreach ($rows as $row)
		<tr class="{{ $row->deleted_at ? ' bg-warning' :'' }}">
			<td>{{ $row->name }}</td>
			<td>{{ $row->slug }}
			</td>
			<td>
				{!! (!empty($row->permissions['admin']) && $row->permissions['admin'] === true) ? '<span class="label label-success arrowed-in arrowed-in-right"><span class="fa fa-user fa-sm"></span> Superadmin</span>'
				: '<span class="label label-danger arrowed-in arrowed-in-right"><span class="fa fa-ban fa-sm"></span> General</span>' !!}</td>
			<td>
				<span class="label label-info">
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
				</span>
			</td>
			<td>
				<div class="btn-group">
					@if (!$row->deleted_at)
					<a data-rel="tooltip" data-original-title="View" title="" href="{{ route('admin.roles.show', $row->id) }}" class="btn btn-xs btn-success tooltip-default">
						<i class="ace-icon fa fa-check bigger-120"></i>
					</a>
					<a data-rel="tooltip" data-original-title="Edit"  href="{{ route('admin.roles.edit', $row->id) }}" class="btn btn-xs btn-info tooltip-default">
						<i class="ace-icon fa fa-pencil bigger-120"></i>
					</a>
					@if(Sentinel::getUser()->roles->first()->id != $row->id)
					<a data-rel="tooltip" data-original-title="Trashed"  href="{{ route('admin.roles.trash', $row->id) }}" class="btn btn-xs btn-danger tooltip-default">
						<i class="ace-icon fa fa-trash-o bigger-120"></i>
					</a>
					@endif
					<!--a data-rel="tooltip" data-original-title="Permanent Delete" href="" class="btn btn-xs btn-warning tooltip-default">
						<i class="ace-icon fa fa-flag bigger-120"></i>
					</a-->
					@else
						<a data-rel="tooltip" data-original-title="Restore!" href="{{route('admin.roles.restored', $row->id)}}" class="btn btn-xs btn-primary tooltip-default">
							<i class="ace-icon fa fa-save bigger-120"></i>
						</a>
						<a title="Permanent Delete!" href="{{route('admin.roles.delete', $row->id)}}" class="btn btn-xs btn-danger">
							<i class="ace-icon fa fa-trash bigger-120"></i>
						</a>
					@endif
				</div>

			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<small class="grey">@if ($rows->count()) Page {{ @$rows->currentPage() }} of {{ @$rows->lastPage() }} @endif</small>
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
