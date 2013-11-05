@extends('site.layouts.default')

{{-- Page title --}}
@section('page_title')
{{ $page->title }}
@stop


{{-- Content --}}
@section('content')
<style>
{{{ $page->page_css() }}}
</style>
<script>
{{ $page->page_javascript() }}
</script>
 <hr>
          <p><i class="icon-time"></i> Posted on {{{ $page->date() }}} </p>
          <hr>
          <img src="http://placehold.it/900x300" class="img-responsive">
          <hr>
          <p>
			{{ $page->content() }}
			</p>
   		  
     <hr>
@stop
