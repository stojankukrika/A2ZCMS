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
		<h3>{{{ Lang::get('site/user.forgot_password') }}}</h3>
	</div>
	<div class="row">
		{{ Confide::makeForgotPasswordForm() }}
	</div>
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
	</div>
</div>
@stop
{{-- Scripts --}}
@section('scripts')
<script>
	$( document ).ready(function() {
		
		$("#email").addClass('form-control');
		$('#email').after('<div class="form-group">&nbsp;</div>');
		$('.input-append > .btn').addClass('btn-primary');
	});
</script>
@stop
