<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>A2Z CMS - offline</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- @todo: fill with your company info or remove -->
		<meta name="description" content="">
		<meta name="author" content="">
		<?php
		$asset = Config::get('app.url');
		?>
		<link rel="stylesheet" type="text/css"  href="{{$asset}}assets/site/'.$sitetheme.'/css/bootstrap.min.css">
		
		<link rel="stylesheet" type="text/css" href="{{$asset}}assets/site/'.$sitetheme.'/css/a2zcms.css">		

		<link rel="shortcut icon" href="{{$asset}}assets/admin/ico/favicon.ico">
	</head>

	<body>
		 <div class="container">

      		<div class="row">
				  <div class="col-lg-8">
						<!-- Content -->
						@yield('content')
						<!-- ./ content -->
				</div>

    	</div><!-- /.container -->
	</body>
</html>