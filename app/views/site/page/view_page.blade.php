@extends('site.layouts.default')

{{-- Page title --}}
@section('page_title')
{{ $page->title }}
@stop


{{-- Content --}}
@section('content')

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
