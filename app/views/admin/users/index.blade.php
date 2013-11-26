@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ $title }}} ::
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
	<h3> {{{ $title }}}
	<div class="pull-right">
		<a href="{{{ URL::to('admin/users/create') }}}" class="btn btn-small btn-info iframe">
			<span class="icon-plus-sign icon-white"></span> {{{ Lang::get('admin/general.create') }}}</a>
	</div></h3>
</div>

<table id="users" class="table table-striped table-hover">
	<thead>
		<tr>
			<th class="col-md-2">{{{ Lang::get('admin/users/table.first_name') }}}</th>
			<th class="col-md-2">{{{ Lang::get('admin/users/table.last_name') }}}</th>
			<th class="col-md-2">{{{ Lang::get('admin/users/table.username') }}}</th>
			<th class="col-md-2">{{{ Lang::get('admin/users/table.email') }}}</th>
			<th class="col-md-1">{{{ Lang::get('admin/users/table.activated') }}}</th>
			<th class="col-md-2">{{{ Lang::get('admin/users/table.created_at') }}}</th>
			<th class="col-md-1">{{{ Lang::get('table.actions') }}}</th>
		</tr>
	</thead>
	<tbody></tbody>
</table>
@stop

{{-- Scripts --}}
@section('scripts')
<script type="text/javascript">
	var oTable;
	$(document).ready(function() {
		oTable = $('#users').dataTable({
			"sDom" : "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
			"sPaginationType" : "bootstrap",
			"oLanguage" : {
				"sLengthMenu" : "_MENU_ {{{ Lang::get('admin/general.records_per_page') }}}"
			},
			"bProcessing" : true,
			"bServerSide" : true,
			"sAjaxSource" : "{{ URL::to('admin/users/data') }}",
			"fnDrawCallback" : function(oSettings) {
				$(".iframe").colorbox({
					iframe : true,
					width : "80%",
					height : "80%"
				});
			}
		});
	}); 
</script>
@stop