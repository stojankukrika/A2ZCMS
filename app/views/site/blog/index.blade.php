@extends('site.layouts.default')

{{-- Page title --}}
@section('page_title')
<h1 class="header">Blog <hr></h1>
@stop

{{-- Content --}}
@section('content')
@foreach ($blogs as $blog)

<div class="post">
        <div class="row">
            <div class="span3">
                <a href="{{{ $blog->url() }}}">
                    <img class="main_pic" alt="main pic" src="http://placehold.it/260x180" />
                </a>
            </div>
            <div class="span4 info">
                <a href="{{{ $blog->url() }}}">
                    <h3>{{ String::title($blog->title) }}</h3>
                </a>
                <p>{{ String::tidy(Str::limit($blog->content, 200)) }}</p>
                <div class="post_info">
                    <div class="author">
                        {{{ $blog->author->name }}} {{{ $blog->author->surname }}}
                    </div>
                    <div class="date">
                        {{{ $blog->date() }}}
                    </div>
                </div>
            </div>
        </div><br>
        <a href="{{{ $blog->url() }}}" class="btn">Read more <i class="icon-chevron-right"></i></a>
        <a href="{{{ $blog->url() }}}#blogcomments" class="btn">
        	 {{$blog->blogcomments->count()}} 
        	{{ \Illuminate\Support\Pluralizer::plural('Blog comment', $blog->blogcomments->count()) }} <i class="icon-comment"></i></a>
    </div>
<hr>
@endforeach

{{ $blogs->links() }}

@stop
