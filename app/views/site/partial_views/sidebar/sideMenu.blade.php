@if (isset($side_menu)) 
<h4>{{{ Lang::get('site/partial_views/sidebar/sideMenu.sidemenu') }}}</h4>
	<ul class="list-unstyled"> 	
		{{ $side_menu }} @endif
	</ul>