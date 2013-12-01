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
	<h3> {{ Lang::get('site/user.edit_settings') }}</h3>
</div>
<div class="row">
<form class="" method="post" action="{{ URL::to('user/' . $user->id . '/edit') }}"  
	enctype="multipart/form-data" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<!-- ./ csrf token -->
	<!-- General tab -->
	<div class="tab-pane active" id="tab-general">

		<!-- Name -->
		<div class="form-group {{{ $errors->has('name') ? 'error' : '' }}}">
			<label class="col-md-2 control-label" for="name">{{ Lang::get('confide.name') }}</label>
			<div class="col-md-10">
				<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', $user->name) }}}" />
				{{{ $errors->first('name', '<span class="help-inline">:message</span>') }}}
			</div>
		</div>
		<!-- ./ name -->
		<br><br>
		<!-- Surname -->
		<div class="form-group {{{ $errors->has('surname') ? 'error' : '' }}}">
			<label class="col-md-2 control-label" for="surname">{{ Lang::get('confide.surname') }}</label>
			<div class="col-md-10">
				<input class="form-control" type="text" name="surname" id="surname" value="{{{ Input::old('surname', $user->surname) }}}" />
				{{{ $errors->first('surname', '<span class="help-inline">:message</span>') }}}
			</div>
		</div>
		<!-- ./ surname -->
		<br><br>
		<!-- Avatar -->
		<div class="form-group">
			<label class="col-md-2 control-label" for="avatar">{{{ Lang::get('confide.avatar') }}}</label>
			<div class="col-md-10">
				<input name="avatar" type="file" class="uploader" id="avatar" value="Upload" />
			</div> 
		</div>
		<!-- ./ avatar -->
		<br><br>
		<!-- Password -->
		<div class="form-group {{{ $errors->has('password') ? 'error' : '' }}}">
			<label class="col-md-2 control-label" for="password">{{ Lang::get('confide.password') }}</label>
			<div class="col-md-10">
				<input class="form-control" type="password" name="password" id="password" value="" />
				{{{ $errors->first('password', '<span class="help-inline">:message</span>') }}}
			</div>
		</div>
		<!-- ./ password -->
		<br><br>
		<!-- Password Confirm -->
		<div class="form-group {{{ $errors->has('password_confirmation') ? 'error' : '' }}}">
			<label class="col-md-2 control-label" for="password_confirmation">{{ Lang::get('confide.password_confirmation') }}</label>
			<div class="col-md-10">
				<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" value="" />
				{{{ $errors->first('password_confirmation', '<span class="help-inline">:message</span>') }}}
			</div>
		</div>
		<!-- ./ password confirm -->
	</div>
	<!-- ./ general tab -->

	<!-- Form Actions -->
	<div class="form-group">
		<div class="col-md-offset-2 col-md-10">
			<button type="submit" class="btn btn-success">
				{{ Lang::get('confide.update') }}
			</button>
		</div>
	</div>
	<!-- ./ form actions -->
</form>
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
@stop
