<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>A2Z CMS</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- @todo: fill with your company info or remove -->
		<meta name="description" content="">
		<meta name="author" content="">
		<?php
		$asset = Config::get('app.url');
		?>
		<link rel="stylesheet" type="text/css"  href="{{$asset}}assets/site/css/bootstrap.min.css">
		
		<link rel="stylesheet" type="text/css" href="{{$asset}}assets/site/css/a2zcms.css">		
		
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="{{$asset}}assets/site/js/html5.js"></script>
		<![endif]-->

		<link rel="shortcut icon" href="{{$asset}}assets/admin/ico/favicon.ico">
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
          	<a class="navbar-brand"href="{{{ URL::to('') }}}"> A2Z CMS </a>
           </div>
					  <!-- Collect the nav links, forms, and other content for toggling -->
			        <div class="collapse navbar-collapse navbar-ex1-collapse">
			          <ul class="nav navbar-nav navbar-right">
			        		<li>
								<a href="{{{ URL::to('') }}}">{{Lang::get('site.home')}}</a>
							</li>
							@if (isset($menu)) {{ $menu }} @endif
							@if (Auth::check())
							@if (Auth::user()->hasRole('admin'))
							<li>
								<a href="{{{ URL::to('admin') }}}">{{Lang::get('site.admin_panel')}}</a>
							</li>
							@endif
							<li>
								<a href="{{{ URL::to('user') }}}">{{Lang::get('site.logged_in_as')}} {{{ Auth::user()->name }}} {{{ Auth::user()->surname }}}</a>
							</li>
							<li>
								<a href="{{{ URL::to('user/logout') }}}">{{Lang::get('site.logout')}}</a>
							</li>
							@else
							<li>
								<a href="{{{ URL::to('user/login') }}}">{{{ Lang::get('site.login') }}}</a>
							</li>
							<li>
								<a href="{{{ URL::to('user/create') }}}">{{{ Lang::get('site.sign_up') }}}</a>
							</li>
							@endif
							<li>
								<a href="{{{ URL::to('contact-us') }}}">{{Lang::get('site.contact_us')}}</a>
							</li>
							
						 </ul>
			        </div><!-- /.navbar-collapse -->
			      </div><!-- /.container -->
			    </nav>

		 <div class="container">

      		<div class="row">

       		 <div class="col-lg-12">
         		<h1 class="page-header">
						<!-- Page title -->
						@yield('page_title')
						<!-- ./ page title -->
					  </h1>
			          <ol class="breadcrumb">
			            <li><a href="#">Home</a></li>
			            <li class="active">Blog Home</li>
			          </ol>
			        </div>
			
			      </div>
			
			      <div class="row">
			      	
			        <div class="col-lg-8">
						<!-- Content -->
						@yield('content')
						<!-- ./ content -->
					 </div>
					 <div class="col-lg-4">
			          <div class="well">
			            <h4>Blog Search</h4>
			            <div class="input-group">
			              <input type="text" class="form-control">
			              <span class="input-group-btn">
			                <button class="btn btn-default" type="button">
			                	<i class="icon-search"></i>
			                </button>
			              </span>
			            </div><!-- /input-group -->
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
          <div class="col-lg-12">
			<span style="text-align:left;float:left">
				&copy; 2013 <a class="a2zcms" href="#">A2Z CMS</a></span>
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
	</body>
</html>