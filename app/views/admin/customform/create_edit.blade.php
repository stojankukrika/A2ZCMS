@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active">
		<a href="#tab-general" data-toggle="tab">{{{ Lang::get('admin/general.general') }}}</a>
	</li>
	<li class="">
		<a href="#tab-dates" data-toggle="tab">{{{ Lang::get('admin/customform/table.fields') }}}</a>
	</li>
</ul>
<!-- ./ tabs -->

{{-- Edit Custom Form --}}
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
					<label class="control-label" for="recievers">{{{ Lang::get('admin/customform/table.recievers') }}} <small>{{Lang::get('admin/customform/table.info_recievers')}}</small></label>
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
						<label class="control-label"><b>{{Lang::get('admin/customform/table.info')}}</b></label>
						<ul id="sortable1">
							<input type="hidden" value="{{isset($customform)?$customform->customformfields->count():'0'}}" name="count" id="count">
							<input type="hidden" value="" name="pagecontentorder" id="pagecontentorder">
							<?php $id=1;?>
							@if(!empty($customformfields))
								@foreach($customformfields as $item)								
									<li class="ui-state-default" name="formf" value="{{$id}}" id="formf{{$id}}">
										<label class="control-label" for="name">Fild name</label>
										<input type="text" id="name{{$item->id}}" value="{{$item->name}}" name="name{{$id}}">
										<div>
											<label class="control-label" for="mandatory">Mandatory </label>
											<select name="mandatory{{$id}}" id="mandatory{{$id}}"> 
												<option value="1" {{($item->mandatory=='1')?"selected":""}}>No</option>
										  		<option value="2" {{($item->mandatory=='2')?"selected":""}}>Yes</option>
										  		<option value="3" {{($item->mandatory=='3')?"selected":""}}>Only numbers</option>
										  		<option value="4" {{($item->mandatory=='4')?"selected":""}}>Valid email adress</option>
											</select>
											<label class="control-label" for="type">Type </label>
											<select name="type{{$id}}" id="type{{$id}}"> 
												<option value="1" {{($item->type=='1')?"selected":""}}>Input field</option>
												<option value="2" {{($item->type=='2')?"selected":""}}>Text area</option>
												<option value="3" {{($item->type=='3')?"selected":""}}>Select</option>
												<option value="4" {{($item->type=='4')?"selected":""}}>Radio</option>
												<option value="5" {{($item->type=='5')?"selected":""}}>Upload</option>
												<option value="6" {{($item->type=='6')?"selected":""}}>Checkbox</option>
											</select>
											<label class="control-label" for="options"> Options</label>
											<input type="text" name="options{{$id}}" value="{{$item->options}}" id="options{{$item->id}}">
										</div>
									</li>
									<?php $id++;?>
								@endforeach
							@endif
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
				<span class="icon-ok"></span> @if (isset($customform)){{{ Lang::get('admin/general.update') }}} @else {{{ Lang::get('admin/general.create') }}} @endif
			</button>
		</div>
	</div>
	<!-- ./ form actions -->
</form>

<div class="hidden" id ="addfield">
	<li class="ui-state-default" name="formf" value="" id="formf">
		<label class="control-label" for="name">Fild name</label>
		<input type="text" id="name" value="" name="name">
		<div>
			<label class="control-label" for="mandatory">Mandatory </label>
			<select name="mandatory" id="mandatory"> 
				<option value="1">No</option>
		  		<option value="2">Yes</option>
		  		<option value="3">Only numbers</option>
		  		<option value="4">Valid email adress</option>
			</select>
			<label class="control-label" for="type">Type </label>
			<select name="type" id="type"> 
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
		var count = {{isset($customform)?$customform->customformfields->count():'0'}};
		var formfild =$('#addfield').html();
		$("#add").click(function(){
			count++;
			
			formfild = formfild.replace('<li class="ui-state-default" name="formf" value="formf" id="formf">', '<li class="ui-state-default" name="formf'+count+'" value="'+count+'" id="formf'+count+'">');
			formfild = formfild.replace('<input id="name" value="" name="name" type="text">', '<input id="name'+count+'" value="" name="name'+count+'" type="text">');
			formfild = formfild.replace('<select name="mandatory" id="mandatory">', '<select name="mandatory'+count+'" id="mandatory'+count+'">');
			formfild = formfild.replace('<select name="type" id="type">', '<select name="type'+count+'" id="type'+count+'">');
			formfild = formfild.replace('<input name="options" value="" id="options" type="text">', '<input name="options'+count+'" value="" id="options'+count+'" type="text">');

			$("#sortable1").append(formfild);
			$('#count').val(count);
			
		})
		$( "#sortable1" ).sortable();
		
		$('.btn-success').click(function(){
		 	var neworder = new Array();
	        $('#sortable1 li').each(function() { 
	            //get the id
	            var name  = $(this).children('[name^="name"]').attr("value");
	            var mandatory  = $(this).children().children('[name^="mandatory"]').attr("value");
	            var type  = $(this).children().children('[name^="type"]').attr("value");
	            var options  = $(this).children().children('[name^="options"]').attr("value");
	            neworder.push(name);
	            neworder.push(mandatory);
	            neworder.push(type);
	            neworder.push(options);
	        });
	        $('#pagecontentorder').val(neworder);
        });
	});
</script>
@stop
