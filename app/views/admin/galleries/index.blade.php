@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ $title }}} :: @parent
@stop

@section('keywords')Gallery administration @stop
@section('author')A2Z CMS @stop
@section('description')Gallery administration index @stop

{{-- Content --}}
@section('content')
<div class="page-header">
	<h3> {{{ $title }}}
	<div class="pull-right">
		<a href="{{{ URL::to('admin/galleries/create') }}}" class="btn btn-small btn-info iframe">
			<span class="icon-plus-sign icon-white"></span> Create</a>
	</div></h3>
</div>

<table id="galleries" class="table table-striped table-hover">
	<thead>
		<tr>
			<th class="col-md-4">{{{ Lang::get('admin/galleries/table.title') }}}</th>
			<th class="col-md-2">{{{ Lang::get('admin/galleries/table.images') }}}</th>
			<th class="col-md-2">{{{ Lang::get('admin/galleries/table.comments') }}}</th>
			<th class="col-md-2">{{{ Lang::get('admin/galleries/table.created_at') }}}</th>
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
		oTable = $('#galleries').dataTable({
			"sDom" : "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
			"sPaginationType" : "bootstrap",
			"oLanguage" : {
				"sLengthMenu" : "_MENU_ records per page"
			},
			"bProcessing" : true,
			"bServerSide" : true,
			"sAjaxSource" : "{{ URL::to('admin/galleries/data') }}",
			"fnDrawCallback" : function(oSettings) {
				$(".iframe").colorbox({
					iframe : true,
					width : "80%",
					height : "80%",
					onClosed : function() {
						oTable.fnReloadAjax();
					}
				});
			}
		});
	}); 
</script>
@stop