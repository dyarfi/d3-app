@extends('Admin::layouts.template')

{{-- Page content --}}
@section('body')
<div class="page-header">
	<h1>Logs <span class="pull-right"><!--a href="{{-- {{ route('admin.logs.create') }} --}}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span> Create</a></span-->{{$junked ? ' &raquo; Trashed' :''}}
		<div class="pull-right">
		   <div class="col-md-6 dropdown">
			   <button class="btn btn-default btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				  <span class="fa fa-external-link-square"></span> Export
				  <span class="caret"></span>
			   </button>
			   <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				   <li><a href="{{route('admin.logs.export','rel=xls')}}" class=""><span class="fa fa-file-excel-o"></span> XLS</a></li>
				   <li><a href="{{route('admin.logs.export','rel=csv')}}" class=""><span class="fa fa-file-text-o"></span> CSV</a></li>
			   </ul>
		   </div>
		</div>
	</h1>
</div>
@if($deleted)
<div class="pull-right">
	<a href="{{route('admin.logs.index','path=trashed')}}" title="Restored Deleted"><span class="fa fa-trash"></span> {{ $deleted }} Deleted</a>
</div>
@endif
@if ($rows)
<div class="row">
	<div class="col-xs-12">
		<div class="clearfix">
			<div class="pull-right tableTools-container"></div>
		</div>
		{!! Form::open(['route'=>'admin.logs.index']) !!}
		<table id="dynamic-table" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th class="center"><label class="pos-rel"><input type="checkbox" class="ace" /><span class="lbl"></span></label></th>
					<th class="col-lg-2">User</th>
					<th class="col-lg-1">Description</th>
					<th class="col-lg-6">Request</th>
					<th class="col-lg-2">Logged At</th>
					<th class="col-lg-5 col-xs-2">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($rows as $row)
				<tr class="{{ $row->deleted_at ? ' bg-warning' :'' }}">
					<td class="center">
						@if(Sentinel::getUser()->id != $row->user_id)
							<label class="pos-rel">
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						@endif
					</td>
					<td class="left">
						@if($row->user)
							{{ $row->user->email ? $row->user->email : $row->user->username }}
						@endif
					</td>
					<td>
						<?php
						$label = ($row->description == 'processForm') ? 'label-warning' : 'label-success';
						?>
						@if ($row->description)
							<span class="label {{$label}} label-sm">{{ $row->description }}</span>
						@endif
					</td>
					<td>
						@if ($row->request)
							URL : {{ $row->request->url }} <br/>
							METHOD : {{ $row->request->method }} <br/>
							QUERY : {{ $row->request->query }} <br/>							
							IP ADDRESS : {{ $row->request->client_ip }} <br/>
							SSL : {{ $row->request->secure ? 'Yes' : 'No' }} <br/>
							@if($row->request->payload)
							PAYLOAD : [{{$row->request->payload->_token}}]								
							@endif
							<?php 
							/*
							@if($row->request->payload)
							PAYLOAD : [<a href="javascript:;" onclick="$(this).next('.description').toggleClass('hide');">{{$row->request->payload->_token}}</a>]
								<div class="description hide">
									@foreach ($row->request->payload as $payload => $value)
										@if(isset($value))
										[{{ $payload }}] : {!! $value !!} <br/>
										@endif
									@endforeach
								</div>
							@endif
							*/ 
							?>
						@endif
					</td>					
		        	<td>
		        		{{ $row->created_at }}
		        	</td>
					<td>
						<div class="btn-group">
							@if (!$row->deleted_at)
							<a data-rel="tooltip" data-original-title="View" title="" href="{{ route('admin.logs.show', $row->id) }}" class="btn btn-xs btn-success tooltip-default">
								<i class="ace-icon fa fa-check bigger-120"></i>
							</a>
							<?php 
							/*
							<a data-rel="tooltip" data-original-title="Edit"  href="{{ route('admin.logs.edit', $row->id) }}" class="btn btn-xs btn-info tooltip-default">
								<i class="ace-icon fa fa-pencil bigger-120"></i>
							</a>
							*/
							?>
							@if(Sentinel::getUser()->id != $row->user_id)
							<a data-rel="tooltip" data-original-title="Trashed"  href="{{ route('admin.logs.trash', $row->id) }}" class="btn btn-xs btn-danger tooltip-default">
								<i class="ace-icon fa fa-trash-o bigger-120"></i>
							</a>
							@endif
							<!--a data-rel="tooltip" data-original-title="Permanent Delete" href="" class="btn btn-xs btn-warning tooltip-default">
								<i class="ace-icon fa fa-flag bigger-120"></i>
							</a-->
							@else
							<a data-rel="tooltip" data-original-title="Restore!" href="{{route('admin.logs.restored', $row->id)}}" class="btn btn-xs btn-primary tooltip-default">
								<i class="ace-icon fa fa-save bigger-120"></i>
							</a>
							<a title="Permanent Delete!" href="{{route('admin.logs.delete', $row->id)}}" class="btn btn-xs btn-danger">
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
		<small class="grey">@if ($rows) Page {{ @$rows->currentPage() }} of {{ @$rows->lastPage() }} @endif</small>
		<div class="pull-right">
			{!! $rows->render() !!}
		</div>
	</div>
</div>
@else
<br><br>
<div class="well">
	Nothing to show here.
</div>
@endif

@stop
