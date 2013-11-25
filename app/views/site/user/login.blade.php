@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('user/user.login') }}} ::
@parent
@stop

{{-- Page title --}}
@section('page_title')
<span>Login</span><small>Access to your account</small></h2>
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
	<h3>{{Lang::get('confide.login.desc')}}</h3>
</div>
<div class="row">
<form method="POST" action="{{ URL::to('user/login') }}" accept-charset="UTF-8">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<fieldset>
		<div class="form-group">
			<label class="col-md-2 control-label" for="email">{{ Lang::get('confide.username_e_mail') }}</label>
			<div class="col-md-10">
				<input class="form-control" tabindex="1" placeholder="{{ Lang::get('confide.username_e_mail') }}" type="text" name="email" id="email" value="{{ Input::old('email') }}">
			</div>
		</div>
		<div class="form-group">&nbsp;</div>
		<div class="form-group">
			<label class="col-md-2 control-label" for="password"> {{ Lang::get('confide::confide.password') }} </label>
			<div class="col-md-10">
				<input class="form-control" tabindex="2" placeholder="{{ Lang::get('confide.password') }}" type="password" name="password" id="password">
			</div>
		</div>
	
		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<div class="checkbox">
					<label for="remember">{{ Lang::get('confide.login.remember') }}
						<input type="hidden" name="remember" value="0">
						<input tabindex="4" type="checkbox" name="remember" id="remember" value="1">
					</label>
				</div>
			</div>
		</div>

		@if ( Session::get('error') )
		<div class="alert alert-danger">
			{{ Session::get('error') }}
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
					{{ Lang::get('confide.login.submit') }}
				</button>
				<a class="btn btn-default" href="{{ Url::to('user/forgot') }}">{{ Lang::get('confide.login.forgot_password') }}</a>
			</div>
		</div>
	</fieldset>
</form>
<div class="form-group">&nbsp;</div>
<div class="form-group">
	<div class="jumbotron">
		<h2>{{{ Lang::get('site/partial_views/sidebar/login.need_an_account') }}}</h2>
		<p>
			{{{ Lang::get('site/partial_views/sidebar/login.create_an_account_here') }}}
		</p>
		<p>
			<a href="{{ Url::to('user/create') }}" class="btn btn-info">{{{ Lang::get('site/partial_views/sidebar/login.create_account') }}}</a>
		</p>
	</div>

</div>

@stop

{{-- Sidebar right --}}
@section('sidebar_right')
<div class="col-lg-4">		
	 <div class="well-sm"><br/>
	 	</div>			 
	@foreach ($sidebar_right as $item)
		  <div class="well">			
			{{ $item['content'] }}
		</div>
	@endforeach 
</div>
@stop
