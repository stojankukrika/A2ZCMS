@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ $title }}} :: @parent
@stop

@section('keywords')Gallery administration @stop
@section('author')A2Z CMS @stop
@section('description')Gallery administration index @stop

{{-- Content --}}
@section('content')
	<div class="page-header">
		<h3>
			{{{ $title }}}
		</h3>
	</div>
	 <label class="control-label" for="title">{{ $title }}{{$galleries->title}}</label>
<div id="pictures" name="pictures" class="row">
	</div>
@stop

{{-- Scripts --}}
@section('scripts')
	<script type="text/javascript">
	$(function(){
			var galleryid = {{$galleries->id}};
		    if(galleryid>0){
		      $.ajax({
		        url: '{{ Config::get('app.url')}}admin/galleryimages/imageforgallery/'+galleryid,
		        type: "GET",
		        success: function(data){
		        	$.each(data.aaData, function( i, val ) {
		        		var arr = val.toString().split(',');
					$( "#pictures" ).append( '<div class="col-sm-2 col-xs-6" style="margin-bottom:30px"><img alt="" src="{{ Config::get('app.url')}}/images/'+arr[2]+'/thumbs/'+arr[1]+'" class="img-thumbnail"><div class="image-bar"> <i class="icon-eye-open"></i> '+arr[3]+' <i class="icon-heart"></i> '+arr[4]+'  <a href="{{ Config::get('app.url')}}admin/galleryimages/'+arr[0]+'/delete"><i class="icon-trash"></i></a></div></div>');
						});
		         }
		    });
		    }
		    else {
		    	$('#pictures').empty();
		    }
	})
	</script>
@stop