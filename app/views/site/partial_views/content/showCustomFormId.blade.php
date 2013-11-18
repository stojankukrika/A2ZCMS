<hr>
 <div class="row">
  	@if(!empty($showCustomFormId))
  	<div class="col-lg-12 col-md-12">
	@foreach($showCustomFormId as $item)
		<h3>{{$item->title}}<h3>
			@if(!empty($showCustomFormId))
				@foreach($showCustomFormFildId[$item->id] as $field)
					<p>
						<div class="col-lg-6">
							{{ $field->name }}
						</div>
						<div class="col-lg-6">
							{{ $field->name }}
						</div>
					</p>
				@endforeach
			@endif
	@endforeach
	</div>
	@endif
</div> 