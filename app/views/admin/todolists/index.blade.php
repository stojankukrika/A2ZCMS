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
		<a href="{{{ URL::to('admin/todolists/create') }}}" class="btn btn-small btn-info iframe">
			<span class="icon-plus-sign icon-white"></span> {{{ Lang::get('admin/general.create') }}}</a>
	</div></h3>
</div>

<table id="todos" class="table table-striped table-hover">
	<thead>
		<tr>
			<th class="col-md-4">{{{ Lang::get('admin/todolists/table.title') }}}</th>
			<th class="col-md-2">{{{ Lang::get('admin/todolists/table.active') }}}</th>
			<th class="col-md-2">{{{ Lang::get('admin/todolists/table.finished') }}}</th>			
			<th class="col-md-2">{{{ Lang::get('admin/todolists/table.created_at') }}}</th>
			<th class="col-md-3">{{{ Lang::get('table.actions') }}}</th>
		</tr>
	</thead>
</table>
@stop

{{-- Scripts --}}
@section('scripts')
<script type="text/javascript">
	var oTable;
	$(document).ready(function() {
		oTable = $('#todos').dataTable({
			"sDom" : "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
			"sPaginationType" : "bootstrap",
			"oLanguage" : {
				"sLengthMenu" : "_MENU_ {{{ Lang::get('admin/general.records_per_page') }}}"
			},
			"bProcessing" : true,
			"bServerSide" : true,
			"sAjaxSource" : "{{ URL::to('admin/todolists/data') }}",
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