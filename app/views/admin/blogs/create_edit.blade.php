@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active">
		<a href="#tab-general" data-toggle="tab">{{{ Lang::get('admin/general.general') }}}</a>
	</li>
	<li class="">
		<a href="#tab-dates" data-toggle="tab">{{{ Lang::get('admin/blogs/table.publish_date') }}}</a>
	</li>
</ul>
<!-- ./ tabs -->

{{-- Edit Blog Form --}}
<form class="form-horizontal" enctype="multipart/form-data" method="post" 
	action="@if (isset($blog)){{ URL::to('admin/blogs/' . $blog->id . '/edit') }}@endif" autocomplete="off">
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
					<input class="form-control" type="text" name="title" id="title" value="{{{ Input::old('title', isset($blog) ? $blog->title : null) }}}" />
					{{{ $errors->first('title', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ blog title -->

			<!-- Resource link -->
			<div class="form-group {{{ $errors->has('resource_link') ? 'error' : '' }}}">
				<div class="col-md-12">
					<label class="control-label" for="resource_link">{{{ Lang::get('admin/blogs/table.resource_link') }}}</label>
					<input class="form-control" type="text" name="resource_link" id="resource_link" value="{{{ Input::old('resource_link', isset($blog) ? $blog->resource_link : null) }}}" />
					{{{ $errors->first('resource_link', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ resource link -->
			
			<!-- Show image -->
			<div class="form-group {{{ $errors->has('image') ? 'error' : '' }}}">
				<div class="col-lg-12">
					<label class="control-label" for="image">{{{ Lang::get('admin/blogs/table.image') }}}</label>
					<input name="image" type="file" class="uploader" id="image" value="Upload" /> 
				</div>
			</div>
			<!-- ./ show image -->
			
			<!-- Blog categorys Title -->
			<div class="form-group {{{ $errors->has('blog_categorys') ? 'error' : '' }}}">
				<div class="col-md-12">
					<label class="control-label" for="title">{{{ Lang::get('admin/blogs/table.category') }}}</label>
					{{Form::select('blogcategory_id', $options,$blog_category ,array('class'=>'form-control','data-style'=>'btn-primary') );}}
					{{{ $errors->first('blog_categorys', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ blog categorys title -->

			<!-- Content -->
			<div class="form-group {{{ $errors->has('content') ? 'error' : '' }}}">
				<div class="col-md-12">
					<label class="control-label" for="content">{{{ Lang::get('admin/blogs/table.content') }}}</label>
					<textarea class="form-control full-width wysihtml5" name="content" value="content" rows="10">{{{ Input::old('content', isset($blog) ? $blog->content : null) }}}</textarea>
					{{{ $errors->first('content', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ content -->
		</div>
		<!-- ./ general tab -->
		
		<!-- Dates tab -->
		<div class="tab-pane" id="tab-dates">
			<!-- Start publish -->
			<div class="form-group {{{ $errors->has('start_publish') ? 'error' : '' }}}">
				<div class="col-md-12">
					<label class="control-label" for="start_publish">{{{ Lang::get('admin/blogs/table.start_publish') }}}</label>
					<input class="form-control" type="text" name="start_publish" id="start_publish" value="{{{ Input::old('start_publish', isset($blog) ? $blog->start_publish : null) }}}" />
					{{{ $errors->first('start_publish', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ start publish -->

			<!-- End publish -->
			<div class="form-group {{{ $errors->has('end_publish') ? 'error' : '' }}}">
				<div class="col-md-12 controls">
					<label class="control-label" for="end_publish">{{{ Lang::get('admin/blogs/table.end_publish') }}}</label>
					<input class="form-control" type="text" name="end_publish" id="end_publish" value="{{{ Input::old('end_publish', isset($blog) ? $blog->end_publish : null) }}}" />
					{{{ $errors->first('end_publish', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ end publish -->

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
@stop
