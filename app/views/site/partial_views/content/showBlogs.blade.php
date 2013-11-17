 <div class="panel panel-default text-center">
  	<p>
	@if(!empty($showBlogs))
	@foreach($showBlogs as $items)
		<h2>{{$item->title}}<h2>
		<p>{{$item->content}}</p>
	@endforeach
	@endif
	</p>
	</div> 