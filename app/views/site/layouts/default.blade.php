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
		<link rel="stylesheet" type="text/css"  href="{{asset('assets/site/'.$sitetheme.'/css/bootstrap.min.css')}}">	
		<link rel="stylesheet" type="text/css" href="{{asset('assets/site/'.$sitetheme.'/css/jquery-ui-1.10.3.custom.css')}}">		
		<link rel="stylesheet" type="text/css" href="{{asset('assets/site/'.$sitetheme.'/css/jquery.multiselect.css')}}">	
		<link rel="stylesheet" type="text/css" href="{{asset('assets/site/'.$sitetheme.'/css/a2zcms.css')}}">		
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="{{asset('assets/site/'.$sitetheme.'/js/html5.js')}}"></script>
		<![endif]-->
		<link rel="shortcut icon" href="{{asset('admin/ico/favicon.ico')}}">
		{{$analytics}}
		@yield('page_scripts')		
	</head>
	<body>	
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
	      	<a class="navbar-brand" href="{{{ URL::to('') }}}"> {{$title}} </a>
           </div>
		 <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav navbar-right">
        		@if (isset($top_menu)) {{ $top_menu }} @endif							
			</ul>
        </div>
      </div>
	</nav>
	<div class="container">
       	<div class="row">
	      	@yield('sidebar_left')
	        <div class="col-lg-8">
				@yield('content')
				</div>
			 </div>
			 	@yield('sidebar_right')
	    </div>
	</div>
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
		<script src="{{asset('assets/site/'.$sitetheme.'/js/jquery-2.0.3.min.js')}}"></script>
		<!--<![endif]-->
		<!--[if IE]>
		<script src="{{asset('assets/site/js/'.$sitetheme.'/jquery-1.10.2.min.js')}}"></script>
		<![endif]-->
		<!--[if !IE]>-->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='{{asset('assets/site/'.$sitetheme.'/js/jquery-2.0.3.min.js')}}'>" + "<" + "/script>");
		</script>
		<!--<![endif]-->
		<!--[if IE]>
		<script type="text/javascript">
		window.jQuery || document.write("<script src='{{asset('assets/site/'.$sitetheme.'/js/jquery-1.10.2.min.js')}}'>"+"<"+"/script>");
		</script>
		<![endif]-->
		<script src="{{asset('assets/site/'.$sitetheme.'/js/jquery-migrate-1.2.1.min.js')}}"></script>
		<script src="{{asset('assets/site/'.$sitetheme.'/js/bootstrap.js')}}"></script>
		<script src="{{asset('assets/site/'.$sitetheme.'/js/theme.js')}}"></script>
		<script src="{{asset('assets/site/'.$sitetheme.'/js/jquery-ui-1.10.3.custom.min.js')}}"></script>
		<script src="{{asset('assets/site/'.$sitetheme.'/js/jquery.validate.js')}}"></script>
		<script src="{{asset('assets/site/'.$sitetheme.'/js/select2.js')}}"></script>
		<script src="{{asset('assets/site/'.$sitetheme.'/js/jquery.multiselect.js')}}"></script>
		<!-- end: JavaScript-->
		@yield('scripts')
	</body>
</html>