@extends('admin.layouts.modal')
 <?=HTML::style('fineuploader/fineuploader.css'); ?>
  <?=HTML::style('css/bootstrap.css'); ?>
  
{{-- Content --}}
@section('content')
	{{-- Edit Gallery Form --}}
	<form class="form-horizontal" method="post" action="@if (isset($galleries)){{ URL::to('admin/galleries/' . $galleries->id . '/edit') }}@endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

			<p>Gallery: <b>{{$gallery->content}}</b></p>
</div>
<div id="jquery-wrapped-fine-uploader"></div>
</div>

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

{{-- Scripts --}}
@section('scripts')
<!-- JavaScript -->
<script>

$(document).ready(function () {

  $('#jquery-wrapped-fine-uploader').fineUploader({
    request: {
      endpoint: '<?=URL::to("admin/galleries/upload/".$gallery->id); ?>',
      params: { 'gid' : <?=$gallery->id; ?> },
    },
    text: {
      uploadButton: 'Upload Your Images'
    },
    template: 
    '<div class="qq-uploader span8 offset2">' +
      '<pre class="qq-upload-drop-area span12"><span>{dragZoneText}</span></pre>' +
      '<div class="qq-upload-button btn btn-success" style="width: auto;">{uploadButtonText}</div>' +
      '<span class="qq-drop-processing"><span>{dropProcessingText}</span><span class="qq-drop-processing-spinner"></span></span>' +
      '<ul class="qq-upload-list" style="margin-top: 10px; text-align: center;"></ul>' +
    '</div>',
    classes: {
      success: 'alert alert-success',
      fail: 'alert alert-error'
    },
    debug: true
  });

});

</script>
  <?=HTML::script('fineuploader/jquery.fineuploader-3.1.1.js'); ?>
@stop