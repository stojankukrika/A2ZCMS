@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ $title }}} :: @parent
@stop

@section('keywords')Settings @stop
@section('author')A2Z CMS @stop
@section('description')Settings @stop

{{-- Content --}}
@section('content')
	<div class="page-header">
		<h3>
			{{{ $title }}}
		</h3>
	</div>
	{{ Form::open(array('url' => '')) }}
    <div id="tabs">
		<ul>
		<li><a href="#general_settings">{{ Lang::get('admin/settings/title.general_settings') }}</a></li>
		<li><a href="#analytics_code">{{ Lang::get('admin/settings/title.analytics_code') }}</a></li>
		<li><a href="#meta_data">{{ Lang::get('admin/settings/title.meta_data') }}</a></li>		
		<li><a href="#offline_settings">{{ Lang::get('admin/settings/title.offline_settings') }}</a></li>
		</ul>
		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="general_settings">
				<!-- Email -->
				<div class="form-group {{{ $errors->has('email') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        {{Form::label('email', Lang::get('admin/settings/table.email'), array('class' => 'control-label'))}}
                       	{{Form::text('email', Input::old('email', isset($settings) ? $settings->email : null) , array('class' => 'form-control'))}} 
						{{{ $errors->first('email', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ email -->
				
					<!-- Email -->
				<div class="form-group {{{ $errors->has('email') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        {{Form::label('email', Lang::get('admin/settings/table.email'), array('class' => 'control-label'))}}
                       	{{Form::text('email', Input::old('email', isset($settings) ? $settings->email : null) , array('class' => 'form-control'))}} 
						{{{ $errors->first('email', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ email -->
					<!-- Email -->
				<div class="form-group {{{ $errors->has('email') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        {{Form::label('email', Lang::get('admin/settings/table.email'), array('class' => 'control-label'))}}
                       	{{Form::text('email', Input::old('email', isset($settings) ? $settings->email : null) , array('class' => 'form-control'))}} 
						{{{ $errors->first('email', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ email -->
					<!-- Email -->
				<div class="form-group {{{ $errors->has('email') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        {{Form::label('email', Lang::get('admin/settings/table.email'), array('class' => 'control-label'))}}
                       	{{Form::text('email', Input::old('email', isset($settings) ? $settings->email : null) , array('class' => 'form-control'))}} 
						{{{ $errors->first('email', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ email -->
			</div>
			<!-- ./ general tab -->
			
			<!-- Analytics tab -->
			<div class="tab-pane active" id="analytics_code">
				<!-- analytics -->
				<div class="form-group {{{ $errors->has('email') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        {{Form::label('analytics', Lang::get('admin/settings/table.analytics'), array('class' => 'control-label'))}}
                       	{{Form::textarea('analytics', Input::old('offlinemessage', isset($settings) ? $settings->analytics : null) , array('class' => 'form-control'))}} 
						{{{ $errors->first('analytics', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ analytics -->
			</div>
			<!-- ./ analytics tab -->
			
			<!-- General tab -->
			<div class="tab-pane active" id="offline_settings">
				<!-- Offline -->
				<div class="form-group {{{ $errors->has('email') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        {{Form::label('offline', Lang::get('admin/settings/table.offline'), array('class' => 'control-label'))}}
                       	{{Form::radio('offline', '0', true);}} {{Lang::get('admin/settings/table.yes')}}
                       	{{Form::radio('offline', '1', false);}} {{Lang::get('admin/settings/table.no')}}
						{{{ $errors->first('email', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ offline -->
				
					<!-- Offline message -->
				<div class="form-group {{{ $errors->has('email') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        {{Form::label('offlinemessage', Lang::get('admin/settings/table.offlinemessage'), array('class' => 'control-label'))}}
                       	{{Form::textarea('offlinemessage', Input::old('offlinemessage', isset($settings) ? $settings->offlinemessage : null) , array('class' => 'form-control'))}} 
						{{{ $errors->first('offlinemessage', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ offline message -->
				
			</div>
			<!-- ./ general tab -->
			
				<!-- Meta data tab -->
			<div class="tab-pane active" id="meta_data">
				<!-- Offline -->
				<div class="form-group {{{ $errors->has('email') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        {{Form::label('offline', Lang::get('admin/settings/table.offline'), array('class' => 'control-label'))}}
                       	{{Form::radio('offline', '0', true);}} {{Lang::get('admin/settings/table.yes')}}
                       	{{Form::radio('offline', '1', false);}} {{Lang::get('admin/settings/table.no')}}
						{{{ $errors->first('email', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ offline -->
				
					<!-- Offline message -->
				<div class="form-group {{{ $errors->has('email') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        {{Form::label('offlinemessage', Lang::get('admin/settings/table.offlinemessage'), array('class' => 'control-label'))}}
                       	{{Form::textarea('offlinemessage', Input::old('offlinemessage', isset($settings) ? $settings->offlinemessage : null) , array('class' => 'form-control'))}} 
						{{{ $errors->first('offlinemessage', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ offline message -->
				
			</div>
			<!-- ./ meta data tab -->
			
			<!-- Form Actions -->
		<div class="form-group">
			<div class="col-md-12">
				<element class="btn-cancel close_popup">Cancel</element>
				<button type="reset" class="btn btn-default">Reset</button>
				<button type="submit" class="btn btn-success">@if (isset($blog)){{ "Update" }} @else {{ "Create" }} @endif</button>
			</div>
		</div>
		<!-- ./ form actions -->
		
    
{{ Form::close() }}
</div>
@stop
@section('scripts')
	 <script>
		$(function() {
			$( "#tabs" ).tabs();
		});
	</script>
@stop
