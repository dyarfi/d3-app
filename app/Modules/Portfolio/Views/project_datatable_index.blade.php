@extends('Admin::layouts.template')

{{-- Project content --}}
@section('body')
<div class="page-header">
	<h1><a href="{{ route('admin.projects.index') }}">Projects</a>
		<span class="pull-right"><a href="{{ route('admin.projects.create') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span> Create</a></span>{{$junked ? ' &raquo; Trashed' :''}}
		<div class="pull-right">
		   <div class="col-md-6 dropdown">
			   <button class="btn btn-default btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				  <span class="fa fa-external-link-square"></span> Export
				  <span class="caret"></span>
			   </button>
			   <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				   <li><a href="{{route('admin.projects.export','rel=xls')}}" class=""><span class="fa fa-file-excel-o"></span> XLS</a></li>
				   <li><a href="{{route('admin.projects.export','rel=csv')}}" class=""><span class="fa fa-file-text-o"></span> CSV</a></li>
			   </ul>
		   </div>
	   </div>
	</h1>
</div>
@if($deleted)
<div class="pull-right">
	<a href="{{route('admin.projects.index','path=trashed')}}" title="Restored Deleted"><span class="fa fa-trash"></span> {{ $deleted }} Deleted</a>
</div>
@endif
{!! Form::open(['route'=>'admin.projects.change']) !!}
	<table id="datatable-table" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th class="center col-lg-1"><label class="pos-rel"><input type="checkbox" class="ace" /><span class="lbl"></span></label></th>
				<th class="col-lg-2">Name</th>
				<th class="col-lg-2">Client</th>
				<th class="col-lg-2">Description</th>
				<th class="col-lg-1">Status</th>
				<th class="col-lg-1">Created At</th>
				<th class="col-lg-1">Updated At</th>
				<th class="col-lg-6 col-xs-3">Actions</th>
			</tr>
		</thead>
		<tbody>
			{{-- Datatable content --}}
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
@stop
