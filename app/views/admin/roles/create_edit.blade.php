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

{{-- Edit Role Form --}}
<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<!-- ./ csrf token -->

	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- General tab -->
		<div class="tab-pane active" id="tab-general">
			<!-- Name -->
			<div class="form-group {{{ $errors->has('name') ? 'error' : '' }}}">
				<label class="col-md-2 control-label" for="name">{{ Lang::get('confide.name') }}</label>
				<div class="col-md-10">
					<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($role) ? $role->name : null) }}}" />
					{{{ $errors->first('name', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ name -->
			<!-- Permissions -->
			<div class="form-group">
			<label class="col-md-2 control-label" for="name">{{{ Lang::get('admin/roles/table.choose_role') }}}</label>
				<div class="col-md-10">
					<select tabindex="3" name="permission[]" id="permission" multiple="" style="width:350px;" data-placeholder="{{{ Lang::get('admin/roles/table.choose_role') }}}">
		             <optgroup label="{{{ Lang::get('admin/roles/table.userrole') }}}">
		            	@foreach ($permissionsUser as $permission)
		            	<option value="{{{ $permission['id'] }}}"
		            	@foreach($permisionsadd as $item)
		            		@if($item['permission_id']==$permission['id']) selected='selected';
		            		@endif
		            	@endforeach
		            	>{{{ $permission['display_name'] }}}</option>
		            @endforeach
		             </optgroup>
  					<optgroup label="{{{ Lang::get('admin/roles/table.adminrole') }}}">
		             	@foreach ($permissionsAdmin as $permission)
		            	<option value="{{{ $permission['id'] }}}"
		            	@foreach($permisionsadd as $item)
		            		@if($item['permission_id']==$permission['id']) selected='selected';
		            		@endif
		            	@endforeach
		            	>{{{ $permission['display_name'] }}}</option>
		            @endforeach
		            </optgroup>
		          </select>
		        </div>
		    </div>
		    <!-- ./ permissions -->
		</div>
		<!-- ./ General tab -->
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
				<span class="icon-ok"></span>@if (isset($role)){{{ Lang::get('admin/general.update') }}} @else {{{ Lang::get('admin/general.create') }}} @endif
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
