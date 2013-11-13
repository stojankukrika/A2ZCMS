@extends('site.layouts.default')

{{-- Page title --}}
@section('page_title')
{{ $blog->title }}
@stop


{{-- Content --}}
@section('content')

 <hr>
          <p><i class="icon-time"></i> {{ Lang::get('site/blog.posted_on') }} {{{ $blog->date() }}} {{ Lang::get('site/blog.by') }} 
          	<a href="#">{{{ $blog->author->username }}}</a></p>
          <hr>
          <img src="http://placehold.it/900x300" class="img-responsive">
          <hr>
          <p>
			{{ $blog->content() }}
			</p>
   		<p>
   			<strong>{{ Lang::get('site/blog.resource') }}:</strong>{{$blog->resource_link}}
   		</p>          
     <hr>

<!-- the comment box -->
  <div class="well">            
	<h4>{{{ $blog_comments->count() }}} {{ Lang::get('site/blog.comments') }}</h4>

	@if ($blog_comments->count())
	@foreach ($blog_comments as $comment)

		<h3>{{{ $comment->author->username }}}
				<small>	{{{ $comment->date() }}}</small>
		</h3>
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
@elseif ( ! $canBlogComment )
{{ Lang::get('site/blog.add_comment_permission') }}
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
	<form method="post" action="{{{ URL::to($blog->slug) }}}">
		<input type="hidden" name="_token" value="{{{ Session::getToken() }}}" />
			<div class="form-group">
				<textarea class="form-control" name="comment" placeholder="comment" rows="7">{{{ Request::old('comment') }}}</textarea>
			</div>
			<div class="form-group">
				<a href="#" class="btn btn-success">{{ Lang::get('site.submit') }}</a>
			</div>
	</form>
</div>
@endif
@stop
