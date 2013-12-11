 <br>
 @if(empty($showImages))
	 	@if(!empty($showGallery))
		 	<div class="row">
			@foreach($showGallery as $item)
				<div class="col-lg-4 col-md-4">
						<h3><a href="{{{ URL::to('gallery/'.$item->id) }}}">{{$item->title}}</a></h3>
				</div>
			@endforeach
			</div>
		@endif
  @else  
 	 @if(!empty($showGallery))	
 	<div class="row">
		@foreach($showGallery as $item)			
			<h3><a href="{{{ URL::to('gallery/'.$item->id) }}}">{{$item->title}}</a></h3>
				<p>
			  	@foreach ($showImages[$item->id] as $img)
			  	<div class="col-lg-3 col-md-3">
			  		<img src="{{ URL::asset('gallery/'.$item->folderid.'/thumbs/'.$img->content)}}" />				  	
	     	 	</div>
	            @endforeach
	            </p>
		@endforeach			
	</div>
	@endif	
@endif	
 <hr>
 	