@extends('site.layouts.default')

{{-- Page title --}}
@section('page_title')
Blog
@stop

{{-- Content --}}
@section('content')
@foreach ($blogs as $blog)

	<h3><a href="{{{ $blog->url() }}}">{{ String::title($blog->title) }}</a></h3>
      <p class="lead">by <a href="#">{{{ $blog->author->name }}} {{{ $blog->author->surname }}}</a></p>
      <hr>
      <p>
      	<i class="icon-time"></i> Posted on {{{ $blog->date() }}}</p>
      <hr>
      	<a href="{{{ $blog->url() }}}"><img src="http://placehold.it/900x300" class="img-responsive"></a>
      <hr>
      <p>{{ String::tidy(Str::limit($blog->content, 200)) }}</p>
      	<a class="btn btn-primary" href="{{{ $blog->url() }}}">Read More <i class="icon-angle-right"></i></a>
		<a class="btn btn-warning" href="{{{ $blog->url() }}}#blogcomments" class="btn"> {{$blog->blogcomments->count()}}
		{{ \Illuminate\Support\Pluralizer::plural('Blog comment', $blog->blogcomments->count()) }} <i class="icon-comment"></i></a>
      <hr>
@endforeach

<ul class="pager">
	{{ $blogs->links() }}
</ul>

@stop
