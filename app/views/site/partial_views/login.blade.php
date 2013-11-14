<ul class="list-unstyled">
   	@if (Auth::check())
   	<h4>Welcome {{Auth::user()->name}} {{Auth::user()->surname}}</h4>
		@if (Auth::user()->hasRole('admin'))
		<li>
			<a href="{{{ URL::to('admin') }}}">{{Lang::get('site.admin_panel')}}</a>
		</li>
		@endif
		<li>
			<a href="{{{ URL::to('user/messages') }}}">{{Lang::get('site.messages')}} ({{$unreadmessages}})</a>
		</li>
		<li>
			<a href="{{{ URL::to('user') }}}">{{Lang::get('site.edit_profile')}}</a>
		</li>
		<li>
			<a href="{{{ URL::to('user/logout') }}}">{{Lang::get('site.logout')}}</a>
		</li>
		@else
		<div class="row">
       <h4>{{Lang::get('confide.login.desc')}}</h4>
		<form method="POST" action="{{ URL::to('login') }}" accept-charset="UTF-8">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<fieldset>
				<div class="form-group">
					<label class="col-md-4 control-label" for="email">{{ Lang::get('confide.username_e_mail') }}</label>
					<div class="col-md-8">
						<input class="form-control" tabindex="1" placeholder="{{ Lang::get('confide.username_e_mail') }}" type="text" name="email" id="email" value="{{ Input::old('email') }}">
					</div>
				</div>
				<div class="form-group">&nbsp;</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="password"> {{ Lang::get('confide::confide.password') }} </label>
					<div class="col-md-8">
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
		</div>
			<div class="row">
        		    <h4>Need an Account?</h4>
						<p>
							Create an account here
						</p>
						<p>
							<a href="{{ Url::to('user/create') }}" class="btn btn-info"> Create Account </a>
						</p>
			</div>
		@endif
	</ul>