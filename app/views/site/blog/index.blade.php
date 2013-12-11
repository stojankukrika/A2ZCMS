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
@if(!empty($sidebar_left))
<br>
	<div class="col-xs-6 col-lg-4">
	@foreach ($sidebar_left as $item)	
		  <div class="well">			
			{{ $item['content'] }}
		</div>
	@endforeach 
	</div>
@endif
@stop
{{-- Content --}}
@section('content')
<div class="col-xs-12 col-sm-6 col-lg-8">
<div class="page-header">
		<h3>{{{ $blog->title }}}</h3>
	</div>
         <p><i class="icon-time"></i> {{ Lang::get('site/blog.posted_on') }} {{{ $blog->date() }}} {{ Lang::get('site/blog.by') }} 
          	<a href="#">{{{ $blog->author->username }}}</a></p>
          <hr>
          @if($blog->image)
          <img src="../blog/{{$blog->image}}" class="img-responsive">
          <hr>
          @endif
          <p>
			{{ $blog->content() }}
			</p>
   		<p>
   			<strong>{{ Lang::get('site/blog.resource') }}:</strong>{{$blog->resource_link}}
   		</p>          
     <hr>
     <p id="vote">{{ Lang::get("site.num_of_votes") }} <span id="countvote">{{$blog->voteup-$blog->votedown}}</span> 
		@if (!$canBlogVote )
		<br><b><i>{{ Lang::get('site.add_votes_permission') }}</i></b>
		@else				
		<span style="display: inline-block;" onclick="contentvote('1','blog',{{$blog->id}})" class="up"></span>
		<span style="display: inline-block;" onclick="contentvote('0','blog',{{$blog->id}})" class="down"></span>
		@endif
	</p>
	<!-- the comment box -->
  <div class="well">            
	<h4>{{{ $blog_comments->count() }}} {{ Lang::get('site/blog.comments') }}</h4>

	@if ($blog_comments->count())
	@foreach ($blog_comments as $comment)

		<h4><b>{{{ $comment->author->username }}}</b>
				<small>	{{{ $comment->date() }}}</small>
		</h4>
          <p>{{{ $comment->content() }}}</p>
	@endforeach
	@else
	<hr />
	@endif
	</div>
	@if ( ! Auth::check())
	{{ Lang::get('site/blog.add_comment_login') }}
	<br />
	<br />
	{{ Lang::get('site/blog.click') }} <a href="{{{ URL::to('user/login') }}}">{{ Lang::get('site/blog.here') }}</a> 
	{{ Lang::get('site/blog.to_login') }}
	<br>
	@elseif ( ! $canBlogComment )
	<br><b><i>{{ Lang::get('site/blog.add_comment_permission') }}</i></b>
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
		<form method="post" action="{{{ URL::to('blog/'.$blog->slug) }}}">
			<input type="hidden" name="_token" value="{{{ Session::getToken() }}}" />
				<div class="form-group">
					<textarea class="form-control" name="blogcomment" id="blogcomment" placeholder="blogcomment" rows="7">{{{ Request::old('blogcomment') }}}</textarea>
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
	@if(!empty($sidebar_right))
		<br>
		<div class="col-xs-6 col-lg-4">
		@foreach ($sidebar_right as $item)
			  <div class="well">			
				{{ $item['content'] }}
			</div>
		@endforeach 
		</div>
	@endif
@stop
{{-- Scripts --}}
@section('scripts')
@stop