 	{{ ($page->showtitle=='1') ? '<h1>'.$page->name.' </h1>' :"" }}
    {{ ($page->showdate=='1') ? '<p><i class="icon-time"></i>'.Lang::get('site/blog.posted_on').' '.$page->date().' </p>' :"" }}
    	<hr>
    	@if($page->image)
    		<img src="../page/{{$page->image}}" class="img-responsive">
      	<hr>
      	@endif
      	<p>
			{{ $page->content() }}
		</p>	  
	 <hr>