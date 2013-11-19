@extends('admin.layouts.default')

@section('content')
<div class="page-header">
<form class="form-horizontal" method="post" action="{{ URL::to('admin/users/profile') }}" autocomplete="off">

<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<!-- ./ csrf token -->
	<!-- name -->
			<div class="form-group">
				<label class="col-md-2 control-label" for="name">{{ Lang::get('confide.name') }}</label>
				<div class="col-md-10">
					<input class="form-control" tabindex="1" placeholder="{{ Lang::get('confide.name') }}" type="text" name="name" id="name" value="{{{ Input::old('name', isset($user) ? $user->name : null) }}}">
				</div>
			</div>
			<!-- name -->
			<!-- surname -->
			<div class="form-group">
				<label class="col-md-2 control-label" for="surname">{{ Lang::get('confide.surname') }}</label>
				<div class="col-md-10">
					<input class="form-control" tabindex="2" placeholder="{{ Lang::get('confide.surname') }}" type="text" name="surname" id="surname" value="{{{ Input::old('surname', isset($user) ? $user->surname : null) }}}">
				</div>
			</div>
			<!-- surname -->
			<!-- Password -->
			<div class="form-group {{{ $errors->has('password') ? 'error' : '' }}}">
				<label class="col-md-2 control-label" for="password">{{ Lang::get('confide.password') }}</label>
				<div class="col-md-10">
					<input class="form-control"  tabindex="5" placeholder="{{ Lang::get('confide.password') }}" type="password" name="password" id="password" value="" />
					{{{ $errors->first('password', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ password -->

			<!-- Password Confirm -->
			<div class="form-group {{{ $errors->has('password_confirmation') ? 'error' : '' }}}">
				<label class="col-md-2 control-label" for="password_confirmation">{{ Lang::get('confide.password_confirmation') }}</label>
				<div class="col-md-10">
					<input class="form-control" type="password" tabindex="6" placeholder="{{ Lang::get('confide.password_confirmation') }}"  name="password_confirmation" id="password_confirmation" value="" />
					{{{ $errors->first('password_confirmation', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ password confirm -->

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
				<span class="icon-ok"></span> @if (isset($user)){{{ Lang::get('admin/general.update') }}} @else {{{ Lang::get('admin/general.create') }}} @endif
			</button>
		</div>
	</div>
	<!-- ./ form actions -->
	</form>
</div>
@stop