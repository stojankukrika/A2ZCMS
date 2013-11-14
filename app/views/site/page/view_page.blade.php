@extends('site.layouts.default')

{{-- Page title --}}
@section('page_title')
{{ $page->title }}
@stop

{{-- Add page scripts --}}
@section('page_scripts')
	<style>
	{{{ $page->page_css() }}}
	</style>
	<script>
	{{ $page->page_javascript() }}
	</script>
@stop

{{-- Sidebar left --}}
@section('sidebar_left')
<!--<div class="col-lg-4">					 
  <div class="well">	
 </div>
</div>-->
@stop

{{-- Content --}}
@section('content')
 	<hr>
  	{{ ($page->showtitle=='1') ? '<h1>'.$page->name.' </h1>' :"" }}
    {{ ($page->showdate=='1') ? '<p><i class="icon-time"></i>'.Lang::get('site/blog.posted_on').' '.$page->date().' </p>' :"" }}
    	<hr>
    		<img src="http://placehold.it/900x300" class="img-responsive">
      	<hr>
      	<p>
			{{ $page->content() }}
		</p>	  
	 <hr>
@stop

{{-- Sidebar right --}}
@section('sidebar_right')
<!--<div class="col-lg-4">					 
  <div class="well">	
 </div>
</div>-->
@stop
