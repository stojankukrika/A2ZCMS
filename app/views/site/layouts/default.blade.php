<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>A2Z CMS</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- @todo: fill with your company info or remove -->
    <meta name="description" content="">
    <meta name="author" content="">
    <?php 
	$asset = Config::get('app.url');
	?>
    <link rel="stylesheet" type="text/css"  href="{{$asset}}assets/site/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{$asset}}assets/site/css/theme.css">
    <link rel="stylesheet" type="text/css" href="{{$asset}}assets/site/css/blog.css"> 
     <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
    
            
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="{{$asset}}assets/site/js/html5.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="{{$asset}}assets/admin/ico/favicon.ico">
  </head>

  <body>  
  	 <a href="#" class="scrolltop">
        <span>up</span>
    </a>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
    		<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
          	</a>
          	<a class="brand" href="{{{ URL::to('') }}}">
                A2Z CMS
            </a>
		  	<div class="nav-collapse collapse">
                <ul class="nav pull-right">
                    <li><a href="{{{ URL::to('') }}}">{{Lang::get('site.home')}}</a></li>
                     @if (isset($menu)) {{ $menu }} @endif
                    @if (Auth::check())
                        @if (Auth::user()->hasRole('admin'))
                        <li><a href="{{{ URL::to('admin') }}}">{{Lang::get('site.admin_panel')}}</a></li>
                        @endif
                        <li><a href="{{{ URL::to('user') }}}">{{Lang::get('site.logged_in_as')}} {{{ Auth::user()->username }}}</a></li>
                        <li><a href="{{{ URL::to('user/logout') }}}">{{Lang::get('site.logout')}}</a></li>
                        @else
                        <li><a href="{{{ URL::to('user/login') }}}">{{{ Lang::get('site.login') }}}</a></li>
                        <li><a href="{{{ URL::to('user/create') }}}">{{{ Lang::get('site.sign_up') }}}</a></li>
                        @endif
                </ul>
	        </div>
        </div>
      </div>
    </div>
    
    
 <div id="blog_post">
        <div class="container">
            <div class="row">

                <div class="span8">
	  	<!-- Page title -->
			@yield('page_title')
			<!-- ./ page title -->
			
	<!-- Content -->
			@yield('content')
			<!-- ./ content -->
         </div>

                <div class="span3 sidebar offset1">
					<br>
                    <input type="text" class="input-large search-query" placeholder="Search">

                    <h4 class="sidebar_header">
                        Menu
                    </h4>

                    <ul class="sidebar_menu">
                        <li><a href="#">Suspendisse Semper Ipsum</a></li>
                        <li><a href="#">Maecenas Euismod Elit</a></li>
                        <li><a href="#">Suspendisse Semper Ipsum</a></li>
                        <li><a href="#">Maecenas Euismod Elit</a></li>
                        <li><a href="#">Suspendisse Semper Ipsum</a></li>
                    </ul>

                    <h4 class="sidebar_header">
                        Recent posts
                    </h4>

                    <ul class="recent_posts">
                        <li>
                            <div class="row">
                                <div class="span1">
                                    <a href="blog-post.html">
                                        <img class="thumb" alt="thumb post" src="http://placehold.it/300x272" />
                                    </a>
                                </div>
                                <div class="span2">
                                    <a class="link" href="blog-post.html">Suspendisse Semper Ipsum</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row">
                                <div class="span1">
                                    <a href="blog-post.html">
                                        <img class="thumb" alt="thumb post" src="http://placehold.it/300x272" />
                                    </a>
                                </div>
                                <div class="span2">
                                    <a class="link" href="blog-post.html">Maecenas Euismod Elit</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row">
                                <div class="span1">
                                    <a href="blog-post.html">
                                        <img class="thumb" alt="thumb post" src="http://placehold.it/300x272" />
                                    </a>
                                </div>
                                <div class="span2">
                                    <a class="link" href="blog-post.html">Suspendisse Semper Ipsum</a>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>

            </div>
        </div>
    </div>
    <div id="footer">
        <div class="container">
             <div class="row copyright">
                <div class="span5">
                </div>
                <div class="span2 offset5 copy">
                    <p>&copy; 2013 - A2Z CMS</p>
                </div>
            </div>
        </div>
    </div>
    
   <!-- start: JavaScript-->
	<!--[if !IE]>-->

			<script src="{{$asset}}assets/site/js/jquery-2.0.3.min.js"></script>

	<!--<![endif]-->

	<!--[if IE]>
	
		<script src="{{$asset}}assets/site/js/jquery-1.10.2.min.js"></script>
	
	<![endif]-->

	<!--[if !IE]>-->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='{{$asset}}assets/site/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

	<!--<![endif]-->

	<!--[if IE]>
	
		<script type="text/javascript">
	 	window.jQuery || document.write("<script src='{{$asset}}assets/site/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
		</script>
		
	<![endif]-->
	<script src="{{$asset}}assets/site/js/jquery-migrate-1.2.1.min.js"></script>
    
   <script src="{{$asset}}assets/site/js/bootstrap.min.js"></script>
    <script src="{{$asset}}assets/site/js/theme.js"></script>
  </body>
</html>