<hr>
 <div class="row">
  	@if(!empty($showBlogs))
  	<div class="col-lg-12 col-md-12">
	@foreach($showBlogs as $item)
		<h3><a href="blog/{{$item->id}}">{{$item->title}}</a><h3>
		<p>{{$item->content}}</p>
	@endforeach
	</div>
	@endif
</div> 