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
	@foreach ($content as $item)
		 {{ $item['content'] }}
	@endforeach 
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