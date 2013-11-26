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
		<a href="{{{ URL::to('admin/customform/create') }}}" class="btn btn-small btn-info iframe">
			<span class="icon-plus-sign icon-white"></span> {{{ Lang::get('admin/general.create') }}}</a>
	</div></h3>
</div>

<table id="contactforms" class="table table-striped table-hover">
	<thead>
		<tr>
			<th class="col-md-6">{{{ Lang::get('admin/customform/table.title') }}}</th>
			<th class="col-md-2">{{{ Lang::get('admin/customform/table.items') }}}</th>
			<th class="col-md-2">{{{ Lang::get('admin/customform/table.created_at') }}}</th>
			<th class="col-md-2">{{{ Lang::get('table.actions') }}}</th>
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
		oTable = $('#contactforms').dataTable({
			"sDom" : "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
			"sPaginationType" : "bootstrap",
			"oLanguage" : {
				"sLengthMenu" : "_MENU_ {{{ Lang::get('admin/general.records_per_page') }}}"
			},
			"bProcessing" : true,
			"bServerSide" : true,
			"sAjaxSource" : "{{ URL::to('admin/customform/data') }}",
			"fnDrawCallback" : function(oSettings) {
				$(".iframe").colorbox({
					iframe : true,
					width : "80%",
					height : "80%",
					onClosed : function() {
						window.location.reload();
					}
				});
			}
		});
	}); 
</script>
@stop