@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active">
		<a href="#tab-general" data-toggle="tab">{{{ Lang::get('admin/general.general') }}}</a>
	</li>
</ul>
<!-- ./ tabs -->

{{-- Create Role Form --}}
<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<!-- ./ csrf token -->

	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- Tab General -->
		<div class="tab-pane active" id="tab-general">
			<!-- Name -->
			<div class="form-group {{{ $errors->has('name') ? 'error' : '' }}}">
				<label class="col-md-2 control-label" for="name">{{ Lang::get('confide.name') }}</label>
				<div class="col-md-10">
					<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name') }}}" />
					{{{ $errors->first('name', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ name -->
		<!-- ./ name -->
			<!-- Permissions -->
		<div class="form-group">
			<label class="col-md-2 control-label" for="name">{{{ Lang::get('admin/roles/table.choose_role') }}}</label>
				<div class="col-md-10">
					<select tabindex="2" name="permission[]" id="permission" multiple="" style="width:350px;" data-placeholder="{{{ Lang::get('admin/roles/table.choose_role') }}}">
		            @foreach ($permissions as $permission)
		            	<option value="{{{ $permission['id'] }}}">{{{ $permission['display_name'] }}}</option>
		            @endforeach
		          </select>
		        </div>
		    </div>
		</div>
	  <!-- ./ permissions -->
	</div>
	<!-- ./ General tab -->

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
				<span class="icon-ok"></span> {{{ Lang::get('admin/general.create') }}}
			</button>
		</div>
	</div>
	<!-- ./ form actions -->
</form>
@stop
{{-- Scripts --}}
@section('scripts')
<script type="text/javascript">
	$(function() {
		$("#permission").select2() // 0-based index;  
	});
</script>
@stop
