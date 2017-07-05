@extends('Auth::layouts.template')

{{-- Page content --}}
@section('body')
<div class="page-header">
	<h1><a href="{{ route('admin.contacts.index') }}">Contacts</a>
		<span class="pull-right"><a href="{{ route('admin.contacts.create') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span> Create</a></span>{{$junked ? ' &raquo; Trashed' :''}}
		<div class="pull-right">
		   <div class="col-md-6 dropdown">
			   <button class="btn btn-default btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				  <span class="fa fa-external-link-square"></span> Export
				  <span class="caret"></span>
			   </button>
			   <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				   <li><a href="{{route('admin.contacts.export','rel=xls')}}" class=""><span class="fa fa-file-excel-o"></span> XLS</a></li>
				   <li><a href="{{route('admin.contacts.export','rel=csv')}}" class=""><span class="fa fa-file-text-o"></span> CSV</a></li>
			   </ul>
		   </div>
	   </div>
	</h1>
</div>
@if($deleted)
<div class="clearfix">
	<div class="pull-right">
		<a href="{{route('admin.contacts.index','path=trashed')}}" title="Restored Deleted" class="btn btn-link btn-xs"><span class="fa fa-trash"></span> {{ $deleted }} Deleted</a>
	</div>
</div>
@endif
{!! Form::open(['route'=>'admin.contacts.change']) !!}
	<table class="table table-bordered table-hover" id="datatable-table" rel="portfolio">
		<thead>
			<tr>
				<th class="center col-lg-1"><label class="pos-rel"><input type="checkbox" class="ace" /><span class="lbl"></span></label></th>
				<th class="col-lg-2">Name</th>
				<th class="col-lg-1">Email</th>
				<th class="col-lg-1">Phone</th>
				<th class="col-lg-3">Subject</th>
				<th class="col-lg-1">Status</th>
				<th class="col-lg-1">Created At</th>
				<th class="col-lg-2 col-md-3 col-sm-3 col-xs-3">Actions</th>
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
							@foreach (config('setting.status') as $val => $config)
								<option value="{{$val}}">{{$config}}</option>
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
