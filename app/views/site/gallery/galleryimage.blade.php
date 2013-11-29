@extends('site.layouts.default')

{{-- Page title --}}
@section('page_header')
	@if($page->showtitle==1)
	<h1 class="page-header">
		{{{ $page->name }}}
	</h1>
	@endif
@stop
{{-- Page title --}}
@section('page_breadcrumb')
	@if(isset($breadcrumb))
	<ol class="breadcrumb">			          
		{{ $breadcrumb }}
	 <!--<li><a href="#">Home</a></li>
		<li class="active">Blog Home</li>-->
	</ol>
	@endif
@stop
{{-- Add page scripts --}}
@section('page_scripts')
	<style>
	{{{ $page->page_css }}}
	</style>
	<script>
	{{ $page->page_javascript}}
	</script>
@stop
{{-- Sidebar left --}}
@section('sidebar_left')
	@foreach ($sidebar_left as $item)
	
		  <div class="well">			
			{{ $item['content'] }}
		</div>
	@endforeach 
@stop
{{-- Content --}}
@section('content')
<br>
<h3><a href="{{{ URL::to('gallery/'.$gallery->id) }}}">{{ String::title($gallery->title) }}</a></h3>
<div class="row"> 
      <img src="../../gallery/{{{$gallery->folderid}}}/{{{ $gallery_image->content }}}" class="img-responsive">        
     <hr>
     <p id="vote">{{ Lang::get("site.num_of_votes") }} <span id="countvote">{{$gallery->voteup-$gallery->votedown}}</span> 
		@if (!$canImageVote )
		<br><b><i>{{ Lang::get('site.add_votes_permission') }}</i></b>
		@else				
		<span style="display: inline-block;" onclick="contentvote('1','image',{{$gallery_image->id}})" class="up"></span>
		<span style="display: inline-block;" onclick="contentvote('0','image',{{$gallery_image->id}})" class="down"></span>
		@endif
	</p>
<!-- the comment box -->
  <div class="well">            
	<h4>{{{ $gallery_comments->count() }}} {{ Lang::get('site/blog.comments') }}</h4>

	@if ($gallery_comments->count())
	@foreach ($gallery_comments as $comment)

		<h4>
			<b>{{{ $comment->author->username }}}</b>
			<small>	{{{ $comment->date() }}}</small>
		</h4>
          <p>{{{ $comment->content() }}}</p>

	@endforeach
	@else
	<hr />
	@endif
</div>
@if ( ! Auth::check())
{{ Lang::get('site.add_comment_login') }}
<br />
<br />
{{ Lang::get('site/blog.click') }} <a href="{{{ URL::to('user/login') }}}">{{ Lang::get('site/blog.here') }}</a> {{ Lang::get('site/blog.to_login') }}
@elseif ( ! $canGalleryComment )
<br><b></i>{{ Lang::get('site/blog.add_comment_permission') }}</i></b>
@else
@if($errors->has())
<div class="alert alert-danger alert-block">
	<ul>
		@foreach ($errors->all() as $error)
		<li>
			{{ $error }}
		</li>
		@endforeach
	</ul>
</div>
@endif
<div class="new_comment">
	<h4>{{ Lang::get('site/blog.add_comment') }}</h4>
	<form method="post" action="{{{ URL::to('galleryimage/'.$gallery->id.'/'.$gallery_image->id) }}}">
		<input type="hidden" name="_token" value="{{{ Session::getToken() }}}" />
			<div class="form-group">
				<textarea class="form-control" name="gallcomment" id="gallcomment" placeholder="gallcomment" rows="7">{{{ Request::old('gallcomment') }}}</textarea>
				<label id="characterLeft"></label>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-success">{{ Lang::get('site.submit') }}</button>
			</div>
	</form>
</div>
@endif
</div>
@stop
{{-- Sidebar right --}}
@section('sidebar_right')
<div class="col-lg-4">		
	 <div class="well-sm"><br/>
	 	</div>			 
	@foreach ($sidebar_right as $item)
		  <div class="well">			
			{{ $item['content'] }}
		</div>
	@endforeach 
</div>
@stop

{{-- Scripts --}}
@section('scripts')
<script>
	$('#characterLeft').text({{$shortmsg}}+' {{ Lang::get('site/messages.characters_left') }}');
	$('#gallcomment').keyup(function () {
	    var max = {{$shortmsg}};
	    var len = $(this).val().length;
	    if (len >= max) {
	    	$('#gallcomment').val($('#gallcomment').val().substr(0, max));
	        $('#characterLeft').text('{{ Lang::get('site/messages.you_have_reached_the_limit') }}');
	    } else {
	        var ch = max - len;
	        $('#characterLeft').text(ch + ' characters left');
	    }
	});
</script>
@stop