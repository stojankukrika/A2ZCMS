<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>A2Z CMS - Install</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- @todo: fill with your company info or remove -->
		<meta name="description" content="">
		<meta name="author" content="">

		<link rel="stylesheet" type="text/css"  href="{{asset('assets/install/css/bootstrap.min.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('assets/install/css/bootstrap-responsive.min.css')}}">
		<!-- Font awesome - iconic font with IE7 support -->
		<link rel="stylesheet" type="text/css" href="{{asset('assets/install/css/font-awesome.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('assets/install/css/font-awesome-ie7.css')}}">
		<!-- Bootbusiness theme -->
		<link rel="stylesheet" type="text/css" href="{{asset('assets/install/css/a2zcms.css')}}">

		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="{{asset('assets/site/js/html5.js')}}"></script>
		<![endif]-->

		<link rel="shortcut icon" href="{{asset('assets/admin/ico/favicon.ico')}}">
	</head>

	<body>
		<!-- Start: HEADER -->
		<header>
			<!-- Start: Navigation wrapper -->
			<div class="navbar navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<a class="brand brand-bootbus" href="#">Install A2Z CMS</a>
						<!-- Below button used for responsive navigation -->
						<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>
				</div>
			</div>
			<!-- End: Navigation wrapper -->
		</header>
		<!-- End: HEADER -->

		<div id="install">
			<div class="container">
				<div class="row">
					<div class="span12">
						<!-- Title -->
						<h3> @yield('title') </h3>
						<!-- ./ title -->
						<!-- Content -->
						@yield('content')
						<!-- ./ content -->
					</div>

				</div>
			</div>
		</div>
		<footer>
			<div class="container">
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

		<script src="{{asset('assets/install/js/jquery-2.0.3.min.js')}}"></script>

		<!--<![endif]-->

		<!--[if IE]>

		<script src="{{asset('assets/install/js/jquery-1.10.2.min.js')}}"></script>

		<![endif]-->

		<!--[if !IE]>-->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='{{asset('assets/install/js/jquery-2.0.3.min.js')}}'>" + "<" + "/script>");
		</script>

		<!--<![endif]-->

		<!--[if IE]>

		<script type="text/javascript">
		window.jQuery || document.write("<script src='{{asset('assets/admin/js/jquery-1.10.2.min.js')}}'>"+"<"+"/script>");
		</script>

		<![endif]-->
		<script src="{{asset('assets/install/js/jquery-migrate-1.2.1.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('assets/install/js/bootstrap.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('assets/install/js/boot-business.js')}}" type="text/javascript"></script>
	</body>
</html>