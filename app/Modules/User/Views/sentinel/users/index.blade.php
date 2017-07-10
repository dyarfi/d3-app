@extends('Auth::layouts.template')

{{-- Page content --}}
@section('body')
<div class="page-header">
	<h1>Users <span class="pull-right"><a href="{{ route('admin.users.create') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span> Create</a></span>{{$junked ? ' &raquo; Trashed' :''}}
		<div class="pull-right">
		   <div class="col-md-6 dropdown">
			   <button class="btn btn-default btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				  <span class="fa fa-external-link-square"></span> Export
				  <span class="caret"></span>
			   </button>
			   <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				   <li><a href="{{route('admin.users.export','rel=xls')}}" class=""><span class="fa fa-file-excel-o"></span> XLS</a></li>
				   <li><a href="{{route('admin.users.export','rel=csv')}}" class=""><span class="fa fa-file-text-o"></span> CSV</a></li>
			   </ul>
		   </div>
		</div>
	</h1>
</div>
@if($deleted)
<div class="pull-right">
	<a href="{{route('admin.users.index','path=trashed')}}" title="Restored Deleted"><span class="fa fa-trash"></span> {{ $deleted }} Deleted</a>
</div>
@endif
@if ($rows)
<div class="row">
	<div class="col-xs-12">
		<div class="clearfix">
			<div class="pull-right tableTools-container"></div>
		</div>
		{!! Form::open(['route'=>'admin.users.index']) !!}
		<table id="dynamic-table" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th class="center"><label class="pos-rel"><input type="checkbox" class="ace" /><span class="lbl"></span></label></th>
					<th class="col-lg-2">Name</th>
					<th class="col-lg-3">Email</th>
					<th class="col-lg-3">Role</th>
					<th class="col-lg-2">Created At</th>
					<th class="col-lg-6 col-xs-3">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($rows as $row)
				<tr class="{{ $row->deleted_at ? ' bg-warning' :'' }}">
					<td class="center">
						@if(Sentinel::getUser()->id != $row->id)
							<label class="pos-rel">
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						@endif
					</td>
					<td>
						@if ($row->first_name || $row->last_name)
						{{ $row->first_name }} {{ $row->last_name }}
						@else
						{{ $row->username }}
						@endif
					</td>
					<td>
						@if ($row->image)
						<span class="tooltip-default" data-rel="tooltip" data-html="true" data-original-title="<img style='max-width:180px' src='{{ asset('uploads/'.$row->image) }}'/>">
							{{ $row->email }}
						</span>
						@else
							{{ $row->email }}
						@endif
					</td>
					<td>
					@if ($row->roles->count() > 0)
						@foreach($row->roles as $roles)
							@if ($roles->id === 1)
								<span class="label label-success arrowed-in arrowed-in-right">
									<span class="fa fa-user fa-sm"></span> {{ $roles->name }}
				                </span>
			              	@else
								<span class="label label-warning arrowed-in arrowed-in-right">
									<span class="fa fa-users fa-sm"></span> {{ $roles->name }}
								</span>
							@endif
						@endforeach
		            @else
		                <div class="label label-danger arrowed-in arrowed-in-right"><span class="fa fa-ban fa-sm"></span> No Role</div>
		            @endif
		        	</td>
		        	<td>
		        		{{ $row->created_at }}
		        	</td>
					<td>
						<div class="btn-group">
							@if (!$row->deleted_at)
							<a data-rel="tooltip" data-original-title="View" title="" href="{{ route('admin.users.show', $row->id) }}" class="btn btn-xs btn-success tooltip-default">
								<i class="ace-icon fa fa-check bigger-120"></i>
							</a>
							<a data-rel="tooltip" data-original-title="Edit"  href="{{ route('admin.users.edit', $row->id) }}" class="btn btn-xs btn-info tooltip-default">
								<i class="ace-icon fa fa-pencil bigger-120"></i>
							</a>
							@if(Sentinel::getUser()->id != $row->id)
							<a data-rel="tooltip" data-original-title="Trashed"  href="{{ route('admin.users.trash', $row->id) }}" class="btn btn-xs btn-danger tooltip-default">
								<i class="ace-icon fa fa-trash-o bigger-120"></i>
							</a>
							@endif
							<!--a data-rel="tooltip" data-original-title="Permanent Delete" href="" class="btn btn-xs btn-warning tooltip-default">
								<i class="ace-icon fa fa-flag bigger-120"></i>
							</a-->
							@else
							<a data-rel="tooltip" data-original-title="Restore!" href="{{route('admin.users.restored', $row->id)}}" class="btn btn-xs btn-primary tooltip-default">
								<i class="ace-icon fa fa-save bigger-120"></i>
							</a>
							<a title="Permanent Delete!" href="{{route('admin.users.delete', $row->id)}}" class="btn btn-xs btn-danger">
								<i class="ace-icon fa fa-trash bigger-120"></i>
							</a>
							@endif
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
			<tr>
			    <td id="corner"><span class="glyphicon glyphicon-minus"></span></td>
			    <td colspan="8">
				<div id="selection" class="input-group">
				    <div class="form-group form-group-sm">
						<label class="col-xs-6 control-label small grey" for="select_action">Change status :</label>
						<div class="col-xs-6" id="select_action">
						<select id="select_action" class="form-control input-sm" name="select_action">
							<option value="">&nbsp;</option>
							@foreach (config('setting.status') as $config => $val)
								<option value="{{$config}}">{{$val}}</option>
							@endforeach
						</select>
						</div>
				      </div>
				 </div>
			    </td>
			</tr>
		</table>
		{!! Form::close() !!}
	</div>
</div>
@else
<br><br>
<div class="well">
	Nothing to show here.
</div>
@endif

@stop
