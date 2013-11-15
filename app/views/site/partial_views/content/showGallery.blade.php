<div class="col-sm-3">
  <div class="panel panel-default text-center">
  @if(!empty($showImages))
	<p>
	@if(!empty($showGallery))
	@foreach($showGallery as $items)
		<h2>{{$item->title}}<h2>
	@endforeach
	@endif
	</p>
  @else
 	 @if(!empty($showGallery))	
		<p>
			@foreach($showGallery as $items)
			<h2>{{$item->title}}<h2>
				 <ul class="list-group">
		             <li class="list-group-item">5 Projects</li>
		         </ul>
			@endforeach
		</p>
	@endif
	@endif
	</div>          
</div>