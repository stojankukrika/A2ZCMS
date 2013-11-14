<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>{{$title}}</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- @todo: fill with your company info or remove -->
		<meta name="description" content="{{$metadesc}}">
		<meta name="keywords" content="{{$metakey}}">
		<meta name="author" content="{{$metaauthor}}">
		<?php
		$asset = Config::get('app.url');
		?>
		<link rel="stylesheet" type="text/css"  href="{{$asset}}assets/site/css/bootstrap.min.css">	
		<link rel="stylesheet" type="text/css" href="{{$asset}}assets/site/css/jquery-ui-1.10.3.custom.css">		
		<link rel="stylesheet" type="text/css" href="{{$asset}}assets/site/css/jquery.multiselect.css">	
		<link rel="stylesheet" type="text/css" href="{{$asset}}assets/site/css/a2zcms.css">		
		
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="{{$asset}}assets/site/js/html5.js"></script>
		<![endif]-->

		<link rel="shortcut icon" href="{{$asset}}assets/admin/ico/favicon.ico">
		
		{{$analytics}}
		@yield('page_scripts')
		
	</head>

	<body>
	
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
	          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
          	<a class="navbar-brand" href="{{{ URL::to('') }}}"> A2Z CMS </a>
           </div>
					  <!-- Collect the nav links, forms, and other content for toggling -->
			        <div class="collapse navbar-collapse navbar-ex1-collapse">
			          <ul class="nav navbar-nav navbar-right">
			        		@if (isset($top_menu)) {{ $top_menu }} @endif							
						</ul>
			        </div><!-- /.navbar-collapse -->
			      </div><!-- /.container -->
			    </nav>

		 <div class="container">

      		<div class="row">

       		 	<div class="col-lg-12">
 					@yield('page_header')						
	           		@yield('page_breadcrumb')
	        	</div>
	       	</div>
	       	<div class="row">
		      	@yield('sidebar_left')
		        <div class="col-lg-8">
					<!-- Content -->
					@yield('content')
					<!-- ./ content -->
				 </div>
				 	@yield('sidebar_right')
				    <div class="well">			          	
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
		          </div><!-- /well -->
		          <div class="well">
		            <h4>Popular Blog Categories</h4>
		              <div class="row">
		                <div class="col-lg-6">
		                  <ul class="list-unstyled">
		                    <li><a href="#dinosaurs">Dinosaurs</a></li>
		                    <li><a href="#spaceships">Spaceships</a></li>
		                    <li><a href="#fried-foods">Fried Foods</a></li>
		                    <li><a href="#wild-animals">Wild Animals</a></li>
		                  </ul>
		                </div>
		                <div class="col-lg-6">
		                  <ul class="list-unstyled">
		                    <li><a href="#alien-abductions">Alien Abductions</a></li>
		                    <li><a href="#business-casual">Business Casual</a></li>
		                    <li><a href="#robots">Robots</a></li>
		                    <li><a href="#fireworks">Fireworks</a></li>
		                  </ul>
		                </div>
		              </div>
		          </div><!-- /well -->
		          <div class="well">
		            <h4>Side Widget Well</h4>
		            <p>Bootstrap's default well's work great for side widgets! What is a widget anyways...?</p>
		          </div><!-- /well -->
		        </div>
		      </div>

    	</div><!-- /.container -->
    
      <footer>
      	  <div class="row">
      	  	 <div class="collapse navbar-collapse navbar-ex1-collapse col-lg-12">
	          	<ul class="nav navbar-nav navbar-left">
	        		@if (isset($footer_menu)) {{ $footer_menu }} @endif							
				</ul>
			 </div>			        
        </div>
        <div class="row">
          <div class="col-lg-12">
			<span style="text-align:left;float:left">
				&copy; 2013 <a class="a2zcms" href="#">A2Z CMS</a></span>
			<span style="text-align: center;padding-left: 30%">{{$copyright}}</span>
			<span style="text-align:right;float:right">
				Powered by: <a class="a2zcms" href="http://laravel.com/" alt="Laravel 4">Laravel 4</a></span>
		</div>
        </div>
      </footer>

		<!-- start: JavaScript-->
		<!--[if !IE]>-->

		<script src="{{$asset}}assets/site/js/jquery-2.0.3.min.js"></script>

		<!--<![endif]-->

		<!--[if IE]>

		<script src="{{$asset}}assets/site/js/jquery-1.10.2.min.js"></script>

		<![endif]-->

		<!--[if !IE]>-->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='{{$asset}}assets/site/js/jquery-2.0.3.min.js'>" + "<" + "/script>");
		</script>

		<!--<![endif]-->

		<!--[if IE]>

		<script type="text/javascript">
		window.jQuery || document.write("<script src='{{$asset}}assets/site/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
		</script>

		<![endif]-->
		<script src="{{$asset}}assets/site/js/jquery-migrate-1.2.1.min.js"></script>
		<script src="{{$asset}}assets/site/js/bootstrap.js"></script>
		<script src="{{$asset}}assets/site/js/theme.js"></script>
		<script src="{{$asset}}assets/site/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="{{$asset}}assets/site/js/jquery.multiselect.js"></script>
		<!-- end: JavaScript-->
		@yield('scripts')
	</body>
</html>