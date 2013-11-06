@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
{{-- Delete Blog Form --}}
<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<input type="hidden" name="id" value="{{ $galleries->id }}" />
	<!-- ./ csrf token -->

	<!-- Form Actions -->
	<div class="control-group">
		<div class="controls">
			<button type="reset" class="btn btn-link close_popup">
				<span class="icon-remove"></span>  Cancel
			</button>
			<button type="submit" class="btn btn-danger close_popup">
				<span class="icon-trash"></span>  Delete
			</button>
		</div>
	</div>
	<!-- ./ form actions -->
</form>
@stop
