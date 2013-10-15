@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ String::title($blog->title) }}} ::
@parent
@stop

{{-- Update the Meta Title --}}
@section('meta_title')
@parent

@stop

{{-- Update the Meta Description --}}
@section('meta_description')
@parent

@stop

{{-- Update the Meta Keywords --}}
@section('meta_keywords')
@parent

@stop

{{-- Content --}}
@section('content')
 <h1 class="header">{{ $blog->title }}</h1>
  <img class="main_pic" alt="main pic" src="http://placehold.it/738x430" />
  <div class="post_content"><p>{{ $blog->content() }} </p>
  <div class="author">{{{ $blog->author->username }}}</div>
  <div class="date">Posted {{{ $blog->date() }}}</div>
</div>
<hr />
 <div class="comments">
<h4>{{{ $blog_comments->count() }}} Comments</h4>

@if ($blog_comments->count())
@foreach ($blog_comments as $comment)

<div class="comment">
    <div class="row">
        <div class="span1">
            <img src="http://placehold.it/171x174" class="img-circle author_pic" />
        </div>
        <div class="span6">
            <div class="name">
               {{{ $comment->author->username }}}
            </div>
            <div class="date">
               {{{ $comment->date() }}}
            </div>
            <div class="response">
               {{{ $comment->content() }}}
			</div>
        </div>
    </div>
</div>

@endforeach
@else
<hr />
@endif
 </div>

@if ( ! Auth::check())
You need to be logged in to add comments.<br /><br />
Click <a href="{{{ URL::to('user/login') }}}">here</a> to login into your account.
@elseif ( ! $canBlogComment )
You don't have the correct permissions to add comments.
@else

@if($errors->has())
<div class="alert alert-danger alert-block">
<ul>
@foreach ($errors->all() as $error)
	<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<div class="new_comment">
    <h4>Add Comment</h4>
    <form method="post" action="{{{ URL::to($blog->slug) }}}">
    	<input type="hidden" name="_token" value="{{{ Session::getToken() }}}" />
       <div class="row">
            <div class="span6">
                <textarea placeholder="Comments" rows="7">{{{ Request::old('comment') }}}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="span6">
                <a href="#" class="btn">Submit</a>
            </div>
        </div>
    </form>
</div>
@endif
@stop
