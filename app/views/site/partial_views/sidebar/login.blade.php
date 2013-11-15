<ul class="list-unstyled">
   	@if (Auth::check())
   	<h4>{{{ Lang::get('site/partial_views/sidebar/login.welcome') }}} {{Auth::user()->name}} {{Auth::user()->surname}}</h4>
		@if (Auth::user()->hasRole('admin'))
		<li>
			<a href="{{{ URL::to('admin') }}}">{{{ Lang::get('site/partial_views/sidebar/login.admin_panel') }}}</a>
		</li>
		@endif
		<li>
			<a href="{{{ URL::to('user/messages') }}}">{{{ Lang::get('site/partial_views/sidebar/login.messages') }}} ({{$unreadmessages}})</a>
		</li>
		<li>
			<a href="{{{ URL::to('user') }}}">{{{ Lang::get('site/partial_views/sidebar/login.edit_profile') }}}</a>
		</li>
		<li>
			<a href="{{{ URL::to('user/logout') }}}">{{{ Lang::get('site/partial_views/sidebar/login.logout') }}}</a>
		</li>
		@else
		
       <h4>{{{ Lang::get('site/partial_views/sidebar/login.desc') }}}</h4>
		<form method="POST" action="{{ URL::to('login') }}" accept-charset="UTF-8">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<fieldset>
				<div class="form-group">
					<label class="col-md-4 control-label" for="email">{{{ Lang::get('site/partial_views/sidebar/login.username_e_mail') }}}</label>
					<div class="col-md-8">
						<input class="form-control" tabindex="1" placeholder="{{{ Lang::get('site/partial_views/sidebar/login.username_e_mail') }}}" type="text" name="email" id="email" value="{{ Input::old('email') }}">
					</div>
				</div>
				<div class="form-group">&nbsp;</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="password"> {{{ Lang::get('site/partial_views/sidebar/login.password') }}}</label>
					<div class="col-md-8">
						<input class="form-control" tabindex="2" placeholder="{{{ Lang::get('site/partial_views/sidebar/login.password') }}}" type="password" name="password" id="password">
					</div>
				</div>
			
				<div class="form-group">
					<div class="col-md-offset-2 col-md-10">
						<div class="checkbox">
							<label for="remember">{{{ Lang::get('site/partial_views/sidebar/login.remember') }}}
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
				
				<p>
					<button tabindex="3" type="submit" class="btn btn-primary">
						{{{ Lang::get('site/partial_views/sidebar/login.submit') }}}
					</button>
					<a class="btn btn-default" href="{{ Url::to('user/forgot') }}">{{{ Lang::get('site/partial_views/sidebar/login.forgot_password') }}}</a>
				</p>
			</fieldset>
		</form>	
        		    <h4>{{{ Lang::get('site/partial_views/sidebar/login.need_an_account') }}}</h4>
						<p>
							{{{ Lang::get('site/partial_views/sidebar/login.create_an_account_here') }}}
						</p>
						<p>
							<a href="{{ Url::to('user/create') }}" class="btn btn-info">{{{ Lang::get('site/partial_views/sidebar/login.create_account') }}}</a>
						</p>
		@endif
	</ul>