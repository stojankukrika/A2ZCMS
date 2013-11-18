<hr>
 <div class="row">
  @if(empty($showImages))
	@if(!empty($showGallery))
	@foreach($showGallery as $item)
		<div class="col-lg-4 col-md-4">
				<h3><a href="{{{ URL::to('gallery/'.$item->folderid) }}}">{{$item->title}}</a><h3>
		</div>
	@endforeach
	@endif
  @else
 	 @if(!empty($showGallery))	
			@foreach($showGallery as $item)
				<div class="col-lg-4 col-md-4">
				<h3><a href="{{{ URL::to('gallery/'.$item->folderid) }}}">{{$item->title}}</a><h3>
					<p>
				  	@foreach ($showImages[$item->id] as $img)
				  		<img src="{{ URL::asset('images/'.$item->folderid.'/thumbs/'.$img->content)}}" />
		            @endforeach
		            </p>
		     	 </div>
			@endforeach
	@endif
	@endif
	</div> 