<!DOCTYPE html>

<html lang="en">

	<head id="Starter-Site">

		<meta charset="UTF-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title> @section('title')
			Administration
			@show </title>

		<meta name="keywords" content="@yield('keywords')" />
		<meta name="author" content="@yield('author')" />
		<!-- Google will often use this as its description of your page/site. Make it good. -->
		<meta name="description" content="@yield('description')" />

		<!-- Speaking of Google, don't forget to set your site up: http://google.com/webmasters -->
		<meta name="google-site-verification" content="">

		<!-- Dublin Core Metadata : http://dublincore.org/ -->
		<meta name="DC.title" content="Project Name">
		<meta name="DC.subject" content="@yield('description')">
		<meta name="DC.creator" content="@yield('author')">

		<!--  Mobile Viewport Fix -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

		<?php
			$asset = Config::get('app.url');
		?>
		<!-- start: CSS -->
		<link href="{{$asset}}assets/admin/css/bootstrap.min.css" rel="stylesheet">
		<link href="{{$asset}}assets/admin/css/print.css" rel="stylesheet" type="text/css" media="print"/>
		<link href="{{$asset}}assets/admin/css/jquery.dataTables.css" rel="stylesheet">
		<link href="{{$asset}}assets/admin/css/colorbox.css" rel="stylesheet">
		<link href="{{$asset}}assets/admin/css/style.min.css" rel="stylesheet">

		<!-- end: CSS -->

		<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>

		<script src="{{$asset}}assets/admin/js/html5.js"></script>
		<script src="{{$asset}}assets/admin/js/respond.min.js"></script>

		<![endif]-->

		<!-- start: Favicon and Touch Icons -->
		<link rel="shortcut icon" href="{{$asset}}assets/admin/ico/favicon.ico">
		<!-- end: Favicon and Touch Icons -->
	</head>

	<body>
		<!-- start: Header -->
		<header class="navbar">
			<div class="container">
				<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a id="main-menu-toggle" class="hidden-xs open"><i class="icon-reorder"></i></a>
				<a class="navbar-brand col-md-2 col-sm-1 col-xs-2" href="#"><span>A2Z CMS</span></a>
				<div id="search" class="col-sm-5 col-xs-8 col-lg-3">
					<select>
						<option>everything</option>
						<option>messages</option>
						<option>comments</option>
						<option>users</option>
					</select>
					<input type="text" placeholder="search" />
					<i class="icon-search"></i>
				</div>
				<!-- start: Header Menu -->
				<div class="nav-no-collapse header-nav">
					<ul class="nav navbar-nav pull-right">
					
						<!-- start: User Dropdown -->
						<li class="dropdown">
							<a class="btn account dropdown-toggle" data-toggle="dropdown" href="#">
							<div class="avatar"><img src="{{$asset}}avatar/avatar.png" alt="Avatar">
							</div>
							<div class="user">
								<span class="hello">Welcome!</span>
								<span class="name">{{{ Auth::user()->name }}} {{{ Auth::user()->surname }}}</span>
							</div> </a>
							<ul class="dropdown-menu">
								<li>
									<a href="{{{ URL::to('/') }}}"><i class="icon-home"></i> {{ Lang::get('admin/general.homepage') }}</a>
								</li>
								<li>
									<a href="{{{ URL::to('/user') }}}"><i class="icon-user"></i> Profile</a>
								</li>
								<li>
									<a href="{{{ URL::to('user/settings') }}}"><i class="icon-cog"></i> {{ Lang::get('admin/general.settings') }}</a>
								</li>
								<li>
									<a href="#"><i class="icon-envelope"></i> Messages</a>
								</li>
								<li>
									<a href="{{{ URL::to('user/logout') }}}"><i class="icon-road icon-white"></i> {{ Lang::get('admin/general.logout') }}</a>
								</li>
							</ul>
						</li>
						<!-- end: User Dropdown -->
					</ul>
				</div>
				<!-- end: Header Menu -->

			</div>
		</header>
		<!-- end: Header -->
		<div class="container">
			<div class="row">

				<!-- start: Main Menu -->
				<div id="sidebar-left" class="col-lg-2 col-sm-1 ">

					<div class="sidebar-nav nav-collapse collapse navbar-collapse">
						<ul class="nav main-menu">
							<li>
								<a href="{{{ URL::to('admin') }}}"><i class="icon-dashboard"></i><span class="hidden-sm text">Dashboard</span></a>
							</li>
							<li>
								<a href="{{{ URL::to('admin/todolists') }}}"><i class="icon-lightbulb"></i><span class="hidden-sm text">To-do list</span></a>
							</li>
							<li>
								<a class="dropmenu" href="{{{ URL::to('admin/pages') }}}"><i class="icon-list-alt"></i><span class="hidden-sm text"> Pages</span><span class="chevron closed"></span></a>
								<ul>
									<li>
										<a href="{{{ URL::to('admin/navigationgroups') }}}"><i class="icon-th-list"></i> Navigation Group</a>
									</li>
									<li>
										<a href="{{{ URL::to('admin/pages') }}}"><i class="icon-envelope"></i> Pages</a>
									</li>
									<li>
										<a href="{{{ URL::to('admin/navigation') }}}"><i class="icon-file"></i> Navigation</a>
									</li>
								</ul>
							</li>
							<li>
								<a class="dropmenu" href="{{{ URL::to('admin/blogs') }}}"><i class="icon-external-link"></i><span class="hidden-sm text">Blog</span><span class="chevron closed"></span></a>
								<ul>
									<li>
										<a class="submenu" href="{{{ URL::to('admin/blogcategorys') }}}"><i class="icon-rss"></i><span class="hidden-sm text"> Blog categorys</span></a>
									</li>
									<li>
										<a class="submenu" href="{{{ URL::to('admin/blogs') }}}"><i class="icon-book"></i><span class="hidden-sm text"> Blog</span></a>
									</li>
									<li>
										<a class="submenu" href="{{{ URL::to('admin/blogcomments') }}}"><i class="icon-comment-alt"></i> <span class="hidden-sm text">Blog comments</span></a>
									</li>
								</ul>
							</li>
							<li>
								<a class="dropmenu" href="{{{ URL::to('admin/galleries') }}}"><i class="icon-camera"></i><span class="hidden-sm text">Gallery</span><span class="chevron closed"></span></a>
								<ul>
									<li>
										<a class="submenu" href="{{{ URL::to('admin/galleryimages') }}}"><i class="icon-rss"></i><span class="hidden-sm text"> Gallery images</span></a>
									</li>
									<li>
										<a class="submenu" href="{{{ URL::to('admin/galleries') }}}"><i class="icon-camera-retro"></i><span class="hidden-sm text"> Gallery</span></a>
									</li>
									<li>
										<a class="submenu" href="{{{ URL::to('admin/galleryimagecomments') }}}"><i class="icon-comments-alt"></i> <span class="hidden-sm text">Gallery comments</span></a>
									</li>
								</ul>
							</li>

							<li>
								<a class="dropmenu" href="{{{ URL::to('admin/users') }}}"><i class="icon-group"></i><span class="hidden-sm text"> Users </span><span class="chevron closed"></span></a>
								<ul>
									<li>
										<a class="submenu" href="{{{ URL::to('admin/users') }}}"><i class="icon-user"></i><span class="hidden-sm text"> Users</span></a>
									</li>
									<li>
										<a class="submenu" href="{{{ URL::to('admin/roles') }}}"><i class="icon-user-md"></i><span class="hidden-sm text"> Roles</span></a>
									</li>
								</ul>
							</li>
							<li>
								<a href="{{{ URL::to('admin/settings') }}}"><i class=" icon-cogs"></i><span class="hidden-sm text"> {{ Lang::get('admin/general.settings') }}</span></a>
							</li>
						</ul>
					</div>
					<a href="{{{ URL::to('admin') }}}#" id="main-menu-min" class="full visible-md visible-lg"><i class="icon-double-angle-left"></i></a>
				</div>
				<!-- end: Main Menu -->
				<!-- start: Content -->
				<div id="content" class="col-lg-10 col-sm-11 ">

					<div class="row">

						<div class="col-sm-12 col-md-12">
							<ol class="breadcrumb">
								<!-- Content -->
								@yield('content')
								<!-- ./ content -->
						</div><!--/row-->

					</div><!--/col-->
				</div><!--/row-->

			</div>
			<!-- end: Content -->

		</div><!--/row-->

		</div><!--/container-->

		<div class="clearfix"></div>

		<footer>
			<p>
				<span style="text-align:left;float:left">&copy; 2013 <a href="#">A2Z CMS</a></span>
				<span class="hidden-phone" style="text-align:right;float:right">Powered by: <a href="http://laravel.com/" alt="Laravel 4">Laravel 4</a></span>
			</p>

		</footer>

		<!-- start: JavaScript-->
		<!--[if !IE]>-->
		<script src="{{$asset}}assets/admin/js/jquery-2.0.3.min.js"></script>
		<!--<![endif]-->
		<!--[if IE]>
		<script src="{{$asset}}assets/admin/js/jquery-1.10.2.min.js"></script>
		<![endif]-->

		<script src="{{$asset}}assets/admin/js/jquery-migrate-1.2.1.min.js"></script>
		<script src="{{$asset}}assets/admin/js/bootstrap.min.js"></script>

		<!-- page scripts -->
		<script src="{{$asset}}assets/admin/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="{{$asset}}assets/admin/js/jquery.ui.touch-punch.min.js"></script>
				<!--[if lte IE 8]>
			<script language="javascript" type="text/javascript" src="{{$asset}}assets/admin/js/excanvas.min.js"></script>
		<![endif]-->		
		<script src="{{$asset}}assets/admin/js/jquery.dataTables.min.js"></script>
		<script src="{{$asset}}assets/admin/js/dataTables.bootstrap.min.js"></script>
		<!-- theme scripts -->
		<script src="{{$asset}}assets/admin/js/custom.min.js"></script>
		<script src="{{$asset}}assets/admin/js/jquery.colorbox.js"></script>

		<!-- end: JavaScript-->
		@yield('scripts')

	</body>
</html>
