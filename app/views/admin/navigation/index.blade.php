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
		<a href="{{{ URL::to('admin/navigation/create') }}}" class="btn btn-small btn-info iframe">
			<i class="icon-plus-sign icon-white"></i> {{{ Lang::get('admin/general.create') }}}</a>
	</div></h3>
</div>

<table id="pages" class="table table-bordered table-hover">
	<thead>
		<tr>
			<th class="span2">{{{ Lang::get('admin/navigation/table.title') }}}</th>
			<th class="span2">{{{ Lang::get('admin/navigation/table.parent') }}}</th>
			<th class="span3">{{{ Lang::get('admin/navigation/table.link_type') }}}</th>
			<th class="span3">{{{ Lang::get('admin/navigation/title.navigation_group') }}}</th>
			<th class="span2">{{{ Lang::get('table.actions') }}}</th>
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
		oTable = $('#pages').dataTable({
			"sDom" : "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
			"sPaginationType" : "bootstrap",
			"oLanguage" : {
				"sLengthMenu" : "_MENU_ {{{ Lang::get('admin/general.records_per_page') }}}"
			},
			"bProcessing" : true,
			"bServerSide" : true,
			"sAjaxSource" : "{{ URL::to('admin/navigation/data') }}",
			"fnDrawCallback" : function(oSettings) {
				$(".iframe").colorbox({
					iframe : true,
					width : "80%",
					height : "80%"
				});
			}
		});
		var startPosition;
		var endPosition;
		$("#pages tbody").sortable({
			cursor : "move",
			start : function(event, ui) {
				startPosition = ui.item.prevAll().length + 1;
			},
			update : function(event, ui) {
				endPosition = ui.item.prevAll().length + 1;
				var navigationList = "";
				$('#pages #row').each(function(i) {
					navigationList = navigationList + ',' + $(this).val();
				});
				$.getJSON("{{ URL::to('admin/navigation/reorder') }}", {
					list : navigationList
				}, function(data) {
					if (data.intSuccess == 1) {
						alert('{{Lang::get("admin/navigation/messages.display_order_updated")}}');
					} else {
						alert('{{Lang::get("admin/navigation/messages.display_order_error")}}');
					}
				});
			}
		});
	}); 
</script>
@stop