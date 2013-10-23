@extends('admin.layouts.modal')
<style>
  /* Fine Uploader
      -------------------------------------------------- */
    .qq-upload-list {
      text-align: left;
    }
    /* For the bootstrapped demos */
    li.alert-success {
      background-color: #DFF0D8;
    }
    li.alert-error {
      background-color: #F2DEDE;
    }
    .alert-error .qq-upload-failed-text {
      display: inline;
    }
</style>
{{-- Content --}}
@section('content')
	{{-- Edit Gallery Form --}}
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

			<p>Gallery: <b>{{$galleries->title}}</b></p>

		<div id="jquery-wrapped-fine-uploader"></div>


		<!-- Form Actions -->
		<div class="form-group">
			<div class="col-md-12">
				<button type="reset" class="btn btn-link close_popup">Cancel</button>
			</div>
		</div>
@stop

{{-- Scripts --}}
@section('scripts')
<!-- JavaScript -->
<script>

$(document).ready(function () {

  $('#jquery-wrapped-fine-uploader').fineUploader({
    request: {
      endpoint: '<?=URL::to("admin/galleries/".$galleries->id."/upload/"); ?>',
      params: { 'gid' : {{$galleries->id}},'_token':'{{ csrf_token() }}' },
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
@stop