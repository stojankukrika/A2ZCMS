@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{ Lang::get('user/user.register') }} ::
@parent
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
	<h1>{{ Lang::get('confide.signup.desc')}}</h1>
</div>
<form method="POST" action="{{ URL::to('user/') }}" accept-charset="UTF-8">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<fieldset>
		<div class="form-group">
			<label class="col-md-2 control-label" for="name">{{ Lang::get('confide.name') }}</label>
			<div class="col-md-10">
				<input class="form-control" tabindex="1" placeholder="{{ Lang::get('confide.name') }}" type="text" name="name" id="name" value="{{ Input::old('name') }}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label" for="surname">{{ Lang::get('confide.surname') }}</label>
			<div class="col-md-10">
				<input class="form-control" tabindex="2" placeholder="{{ Lang::get('confide.surname') }}" type="text" name="surname" id="surname" value="{{ Input::old('surname') }}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label" for="username">{{ Lang::get('confide.username') }}</label>
			<div class="col-md-10">
				<input class="form-control" tabindex="3" placeholder="{{ Lang::get('confide.username') }}" type="text" name="username" id="username" value="{{ Input::old('username') }}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label" for="email">{{ Lang::get('confide::confide.e_mail') }}</label>
			<div class="col-md-10">
				<input class="form-control" tabindex="4" placeholder="{{ Lang::get('confide.e_mail') }}" type="text" name="email" id="email" value="{{ Input::old('email') }}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label" for="password">{{ Lang::get('confide.password') }}</label>
			<div class="col-md-10">
				<input class="form-control" tabindex="5" placeholder="{{ Lang::get('confide.password') }}" type="password" name="password" id="password">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label" for="surname">{{ Lang::get('confide.password_confirmation') }}</label>
			<div class="col-md-10">
				<input class="form-control" tabindex="6" placeholder="{{ Lang::get('confide.password_confirmation') }}" type="password" name="password_confirmation" id="password_confirmation">
			</div>
		</div>

		@if ( Session::get('error') )
		<div class="alert alert-error alert-danger">
			@if ( is_array(Session::get('error')) )
			{{ head(Session::get('error')) }}
			@endif
		</div>
		@endif

		@if ( Session::get('notice') )
		<div class="alert">
			{{ Session::get('notice') }}
		</div>
		@endif

		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<button tabindex="3" type="submit" class="btn btn-primary">
					{{ Lang::get('confide.signup.submit') }}
				</button>
			</div>
		</div>

	</fieldset>
</form>

@stop
