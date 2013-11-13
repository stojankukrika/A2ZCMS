@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')

{{-- Delete User Form --}}
<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<input type="hidden" name="id" value="{{ $user->id }}" />
	<!-- ./ csrf token -->

	<!-- Form Actions -->
	<div class="control-group">
		<div class="controls">
			<button type="reset" class="btn btn-link close_popup">
				<span class="icon-remove"></span>  {{{ Lang::get('admin/general.cancel') }}}
			</button>
			<button type="submit" class="btn btn-danger close_popup">
				<span class="icon-trash"></span>  {{{ Lang::get('admin/general.delete') }}}
			</button>
		</div>
	</div>
	<!-- ./ form actions -->
</form>
@stop