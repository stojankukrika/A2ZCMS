@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	{{-- Edit Gallery Form --}}
	<form class="form-horizontal" method="post" action="@if (isset($galleries)){{ URL::to('admin/galleries/' . $galleries->id . '/edit') }}@endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

				<!-- Blog Title -->
				<div class="form-group {{{ $errors->has('title') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label" for="title">Gallery Title</label>
						<input class="form-control" type="text" name="title" id="title" value="{{{ Input::old('title', isset($galleries) ? $galleries->title : null) }}}" />
						{{{ $errors->first('title', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ blog title -->
									
				<!-- Start publish -->
				<div class="form-group {{{ $errors->has('start_publish') ? 'error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="start_publish">Start publish</label>
						<input class="form-control" type="text" name="start_publish" id="start_publish" value="{{{ Input::old('start_publish', isset($galleries) ? $galleries->start_publish : null) }}}" />
						{{{ $errors->first('start_publish', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ start publish -->

				<!-- End publish -->
				<div class="form-group {{{ $errors->has('end_publish') ? 'error' : '' }}}">
					<div class="col-md-12 controls">
                        <label class="control-label" for="end_publish">End publish</label>
						<input class="form-control" type="text" name="end_publish" id="end_publish" value="{{{ Input::old('end_publish', isset($galleries) ? $galleries->end_publish : null) }}}" />
						{{{ $errors->first('end_publish', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ end publish -->

		<!-- Form Actions -->
		<div class="form-group">
			<div class="col-md-12">
				<button type="reset" class="btn btn-link close_popup">Cancel</button>
				<button type="reset" class="btn btn-default">Reset</button>
				<button type="submit" class="btn btn-success">@if (isset($galleries)){{ "Update" }} @else {{ "Create" }} @endif</button>
			</div>
		</div>
		<!-- ./ form actions -->
	</form>
@stop
