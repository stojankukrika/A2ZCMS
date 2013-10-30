@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active">
		<a href="#tab-general" data-toggle="tab">General</a>
	</li>
	<li>
		<a href="#tab-permissions" data-toggle="tab">Permissions</a>
	</li>
</ul>
<!-- ./ tabs -->

{{-- Delete Role Form --}}
<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<input type="hidden" name="id" value="{{ $role->id }}" />
	<!-- ./ csrf token -->

	<!-- Form Actions -->
	<div class="control-group">
		<div class="controls">
			<button type="reset" class="btn btn-link close_popup">
				Cancel
			</button>
			<button type="submit" class="btn btn-danger close_popup">
				Delete
			</button>
		</div>
	</div>
	<!-- ./ form actions -->
</form>
@stop
