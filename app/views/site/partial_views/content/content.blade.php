 	{{ ($page->showtitle=='1') ? '<h1>'.$page->name.' </h1>' :"" }}
    {{ ($page->showdate=='1') ? '<p><i class="icon-time"></i>'.Lang::get('site/blog.posted_on').' '.$page->date().' </p>' :"" }}
    	<hr>
    		<img src="http://placehold.it/900x300" class="img-responsive">
      	<hr>
      	<p>
			{{ $page->content() }}
		</p>	  
	 <hr>