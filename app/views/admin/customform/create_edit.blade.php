@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active">
		<a href="#tab-general" data-toggle="tab">{{{ Lang::get('admin/general.general') }}}</a>
	</li>
	<li class="">
		<a href="#tab-dates" data-toggle="tab">{{{ Lang::get('admin/contactform/table.fields') }}}</a>
	</li>
</ul>
<!-- ./ tabs -->

{{-- Edit Blog Form --}}
<form class="form-horizontal" enctype="multipart/form-data"  method="post" action="@if (isset($customform)){{ URL::to('admin/customform/' . $customform->id . '/edit') }}@endif" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<!-- ./ csrf token -->

	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- General tab -->
		<div class="tab-pane active" id="tab-general">
			<!-- Blog Title -->
			<div class="form-group {{{ $errors->has('title') ? 'error' : '' }}}">
				<div class="col-md-12">
					<label class="control-label" for="title">{{{ Lang::get('admin/general.title') }}}</label>
					<input class="form-control" type="text" name="title" id="title" value="{{{ Input::old('title', isset($customform) ? $customform->title : null) }}}" />
					{{{ $errors->first('title', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ blog title -->

			<!-- Recievers -->
			<div class="form-group {{{ $errors->has('recievers') ? 'error' : '' }}}">
				<div class="col-md-12">
					<label class="control-label" for="recievers">{{{ Lang::get('admin/customform/table.recievers') }}}</label>
					<input class="form-control" type="text" name="recievers" id="recievers" value="{{{ Input::old('recievers', isset($customform) ? $customform->recievers : null) }}}" />
					{{{ $errors->first('recievers', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ resource recievers -->
			<!-- Content -->
			<div class="form-group {{{ $errors->has('message') ? 'error' : '' }}}">
				<div class="col-md-12">
					<label class="control-label" for="message">{{{ Lang::get('admin/customform/table.message') }}}</label>
					<textarea class="form-control full-width wysihtml5" name="message" value="message" rows="10">{{{ Input::old('message', isset($customform) ? $customform->message : null) }}}</textarea>
					{{{ $errors->first('message', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ content -->
		</div>
		<!-- ./ general tab -->
		
		<!-- Dates tab -->
		<div class="tab-pane" id="tab-dates">
			<input class="btn btn-link" id="add" type="button" value="Add field">
			<div id="fields">
				<div class="row responsive-utilities-test">
					<div class="col-md-10 col-xs-10" id="form_fields">
						<ul id="sortable1">
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- ./ dates tab -->
	</div>
	<!-- ./ tabs content -->

	<!-- Form Actions -->
	
	<div class="form-group">
		<div class="col-md-12">
			<button type="reset" class="btn btn-link close_popup">
				<span class="icon-remove"></span>  {{{ Lang::get('admin/general.cancel') }}}
			</button>
			<button type="reset" class="btn btn-default">
				<span class="icon-refresh"></span> {{{ Lang::get('admin/general.reset') }}}
			</button>
			<button type="submit" class="btn btn-success">
				<span class="icon-ok"></span> @if (isset($blog)){{{ Lang::get('admin/general.update') }}} @else {{{ Lang::get('admin/general.create') }}} @endif
			</button>
		</div>
	</div>
	<!-- ./ form actions -->
</form>

<div class="hidden" id ="addfield">
	<li class="ui-state-default" name="formf" value="formf">
				<label class="control-label" for="title">Fild name</label>
				<input type="text" name="title" value="title" id="title">
				<div>
					<label class="control-label" for="mandatory">Mandatory </label>
					<select name="7878" id="mandatory"> 
						<option value="1">No</option>
				  		<option value="2">Yes</option>
				  		<option value="3">Only numbers</option>
				  		<option value="4">Valid email adress</option>
					</select>
					<label class="control-label" for="type">Type </label>
					<select name="gfg" id="type"> 
						<option value="1">Input field</option>
						<option value="2">Text area</option>
						<option value="3">Select</option>
						<option value="4">Radio</option>
						<option value="5">Upload</option>
						<option value="6">Checkbox</option>
					</select>
					<label class="control-label" for="options"> Options</label>
					<input type="text" name="options" value="" id="options">
				</div>
			</li>
</div>
		
@stop
@section('scripts')
<script type="text/javascript">
	$(function() {
		var formfild =$('#addfield').html();
		console.log(formfild);
		$("#add").click(function(){
			$("#sortable1").append(formfild);
		})
		$( "#sortable1" ).sortable();
	});
</script>
@stop
