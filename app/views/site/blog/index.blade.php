@extends('site.layouts.default')

{{-- Content --}}
@section('content')
@foreach ($blogs as $blog)
<div class="row">
	<div class="col-md-8">
		<!-- Blog Title -->
		<div class="row">
			<div class="col-md-8">
				<h4><strong><a href="{{{ $blog->url() }}}">{{ String::title($blog->title) }}</a></strong></h4>
			</div>
		</div>
		<!-- ./ blog title -->

		<!-- Blog Content -->
		<div class="row">
			<div class="col-md-2">
				<a href="{{{ $blog->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
			</div>
			<div class="col-md-6">
				<p>
					{{ String::tidy(Str::limit($blog->content, 200)) }}
				</p>
				<p><a class="btn btn-mini btn-default" href="{{{ $blog->url() }}}">Read more</a></p>
			</div>
		</div>
		<!-- ./ blog content -->

		<!-- Blog Footer -->
		<div class="row">
			<div class="col-md-8">
				<p></p>
				<p>
					<span class="glyphicon glyphicon-user"></span> by <span class="muted">{{{ $blog->author->username }}}</span>
					| <span class="glyphicon glyphicon-calendar"></span> <!--Oct 28th, 2013-->{{{ $blog->date() }}}
					| <span class="glyphicon glyphicon-comment"></span> <a href="{{{ $blog->url() }}}#blogcomments">{{$blog->blogcomments->count()}} 
					{{ \Illuminate\Support\Pluralizer::plural('BlogComment', $blog->blogcomments->count()) }}</a>
				</p>
			</div>
		</div>
		<!-- ./ post footer -->
	</div>
</div>

<hr />
@endforeach

{{ $blogs->links() }}

@stop
