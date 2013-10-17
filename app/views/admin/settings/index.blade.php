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

	<li><a href="#">Home</a></li>
					  	<li class="active" >Dashboard</li>
					</ol>		
					<div class="row">	
						
	{{ Form::open() }}
	<div class="col-md-12">
					<div class="box">
						<div class="box-header">
							<h2><i class="icon-th"></i><span class="break"></span>{{{ $title }}}</h2>
							<ul id="myTab" class="nav tab-menu nav-tabs">
								<li><a href="#general_settings">{{ Lang::get('admin/settings/title.general_settings') }}</a></li>
								<li><a href="#analytics_code">{{ Lang::get('admin/settings/title.analytics_code') }}</a></li>
								<li><a href="#meta_data">{{ Lang::get('admin/settings/title.meta_data') }}</a></li>		
								<li><a href="#offline_settings">{{ Lang::get('admin/settings/title.offline_settings') }}</a></li>
							</ul>
						</div>
						<div class="box-content">
							
							<div class="tab-content" id="myTabContent">
								<!-- General tab -->
			<div class="tab-pane active" id="general_settings">
				<!-- Email -->
				<div class="form-group {{{ $errors->has('email') ? 'error' : '' }}}">
                    <div class="col-md-12">
                    	<?php $email = ''; foreach($settings as $v) { if ($v->varname == 'email') { $email =  $v->value; } } ?>
                    	{{Form::label('email', Lang::get('admin/settings/table.email'), array('class' => 'control-label'))}}
                       	{{Form::text('email', Input::old('email', $email) , array('class' => 'form-control'))}} 
						{{ $errors->first('email', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ email -->
					<!-- Title -->
				<div class="form-group {{{ $errors->has('title') ? 'error' : '' }}}">
                    <div class="col-md-12">
                    	<?php $title = ''; foreach($settings as $v) { if ($v->varname == 'title') { $title =  $v->value; } } ?>
                    	{{Form::label('title', Lang::get('admin/settings/table.title'), array('class' => 'control-label'))}}
                       	{{Form::text('title', Input::old('title', $title) , array('class' => 'form-control'))}} 
						{{ $errors->first('title', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ title -->
					<!-- Copyright -->
				<div class="form-group {{{ $errors->has('copyright') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <?php $copyright = ''; foreach($settings as $v) { if ($v->varname == 'copyright') { $copyright =  $v->value; } } ?>
                    	{{Form::label('copyright', Lang::get('admin/settings/table.copyright'), array('class' => 'control-label'))}}
                       	{{Form::text('copyright', Input::old('copyright', $copyright) ,array('class' => 'form-control'))}} 
						{{ $errors->first('copyright', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ copyright -->
					<!-- Dateformat -->
				<div class="form-group {{{ $errors->has('dateformat') ? 'error' : '' }}}">
                    <div class="col-md-12">
                         <?php $dateformat = ''; foreach($settings as $v) { if ($v->varname == 'dateformat') { $dateformat =  $v->value; } } ?>
                    	{{Form::label('dateformat', Lang::get('admin/settings/table.dateformat'), array('class' => 'control-label'))}}
                       	{{Form::text('dateformat', Input::old('dateformat', $dateformat) , array('class' => 'form-control'))}} 
						{{ $errors->first('dateformat', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ dateformat -->
					<!-- Timeformat -->
				<div class="form-group {{{ $errors->has('timeformat') ? 'error' : '' }}}">
                    <div class="col-md-12">
                         <?php $timeformat = ''; foreach($settings as $v) { if ($v->varname == 'timeformat') { $timeformat =  $v->value; } } ?>
                    	{{Form::label('timeformat', Lang::get('admin/settings/table.timeformat'), array('class' => 'control-label'))}}
                       	{{Form::text('timeformat', Input::old('timeformat', $timeformat) , array('class' => 'form-control'))}} 
						{{ $errors->first('timeformat', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ timeformat -->
				
					<!-- Useravatwidth -->
				<div class="form-group {{{ $errors->has('useravatwidth') ? 'error' : '' }}}">
                    <div class="col-md-12">
                         <?php $useravatwidth = ''; foreach($settings as $v) { if ($v->varname == 'useravatwidth') { $useravatwidth =  $v->value; } } ?>
                    	{{Form::label('useravatwidth', Lang::get('admin/settings/table.useravatwidth'), array('class' => 'control-label'))}}
                       	{{Form::text('useravatwidth', Input::old('useravatwidth', $useravatwidth) , array('class' => 'form-control'))}} 
						{{ $errors->first('useravatwidth', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ useravatwidth -->
					<!-- Useravatheight -->
				<div class="form-group {{{ $errors->has('useravatheight') ? 'error' : '' }}}">
                    <div class="col-md-12">
                         <?php $useravatheight = ''; foreach($settings as $v) { if ($v->varname == 'useravatheight') { $useravatheight =  $v->value; } } ?>
                    	{{Form::label('useravatheight', Lang::get('admin/settings/table.useravatheight'), array('class' => 'control-label'))}}
                       	{{Form::text('useravatheight', Input::old('useravatheight', $useravatheight) , array('class' => 'form-control'))}} 
						{{ $errors->first('useravatheight', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ timeformat -->
					<!-- Shortmsg -->
				<div class="form-group {{{ $errors->has('shortmsg') ? 'error' : '' }}}">
                    <div class="col-md-12">
                         <?php $shortmsg = ''; foreach($settings as $v) { if ($v->varname == 'shortmsg') { $shortmsg =  $v->value; } } ?>
                    	{{Form::label('shortmsg', Lang::get('admin/settings/table.shortmsg'), array('class' => 'control-label'))}}
                       	{{Form::text('shortmsg', Input::old('shortmsg', $shortmsg) , array('class' => 'form-control'))}} 
						{{ $errors->first('shortmsg', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ shortmsg -->
					<!-- Pageitem -->
				<div class="form-group {{{ $errors->has('pageitem') ? 'error' : '' }}}">
                    <div class="col-md-12">
                         <?php $pageitem = ''; foreach($settings as $v) { if ($v->varname == 'pageitem') { $pageitem =  $v->value; } } ?>
                    	{{Form::label('pageitem', Lang::get('admin/settings/table.pageitem'), array('class' => 'control-label'))}}
                       	{{Form::text('pageitem', Input::old('pageitem', $pageitem) , array('class' => 'form-control'))}} 
						{{ $errors->first('pageitem', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ pageitem -->
				</div>
								<!-- Analytics tab -->
			<div class="tab-pane active" id="analytics_code">
				<!-- analytics -->
				<div class="form-group {{{ $errors->has('analytics') ? 'error' : '' }}}">
                    <div class="col-md-12">
                         <?php $analytics = ''; foreach($settings as $v) { if ($v->varname == 'analytics') { $analytics =  $v->value; } } ?>
                    	{{Form::label('analytics', Lang::get('admin/settings/table.analytics'), array('class' => 'control-label'))}}
                       	{{Form::textarea('analytics', Input::old('analytics', $analytics) , array('class' => 'form-control'))}} 
						{{ $errors->first('analytics', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ analytics -->
			</div>
			<!-- ./ analytics tab -->
						<div class="tab-pane active" id="meta_data">
				<!-- Metadesc -->
				<div class="form-group {{{ $errors->has('metadesc') ? 'error' : '' }}}">
                     <div class="col-md-12">
                         <?php $metadesc = ''; foreach($settings as $v) { if ($v->varname == 'metadesc') { $metadesc =  $v->value; } } ?>
                    	{{Form::label('metadesc', Lang::get('admin/settings/table.metadesc'), array('class' => 'control-label'))}}
                       	{{Form::textarea('metadesc', Input::old('offlinemessage', $metadesc) , array('class' => 'form-control'))}} 
						{{ $errors->first('metadesc', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ metadesc -->
				
					<!-- Metakey -->
				<div class="form-group {{{ $errors->has('metakey') ? 'error' : '' }}}">
                    <div class="col-md-12">
                         <?php $metakey = ''; foreach($settings as $v) { if ($v->varname == 'metakey') { $metakey =  $v->value; } } ?>
                    	{{Form::label('metakey', Lang::get('admin/settings/table.metakey'), array('class' => 'control-label'))}}
                       	{{Form::text('metakey', Input::old('metakey', $metakey) , array('class' => 'form-control'))}} 
						{{ $errors->first('metakey', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ metakey -->
				
					<!-- Metaauthor -->
				<div class="form-group {{{ $errors->has('metaauthor') ? 'error' : '' }}}">
                    <div class="col-md-12">
                         <?php $metaauthor = ''; foreach($settings as $v) { if ($v->varname == 'metaauthor') { $metaauthor =  $v->value; } } ?>
                    	{{Form::label('metaauthor', Lang::get('admin/settings/table.metaauthor'), array('class' => 'control-label'))}}
                       	{{Form::text('metaauthor', Input::old('metaauthor', $metaauthor) , array('class' => 'form-control'))}} 
						{{ $errors->first('metaauthor', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ metaauthor -->
			</div>
			<!-- ./ meta tab -->
				
			<!-- offline tab -->
			<div class="tab-pane active" id="offline_settings">
				<!-- Offline -->
				<div class="form-group {{{ $errors->has('offline') ? 'error' : '' }}}">
                    <div class="col-md-12">
                         <?php $offline = ''; foreach($settings as $v) { if ($v->varname == 'offline') { $offline =  $v->value; } } ?>
                    	{{Form::label('offline', Lang::get('admin/settings/table.offline'), array('class' => 'control-label'))}}
                       	{{Form::radio('offline', '0', ($offline)?true:false);}} {{Lang::get('admin/settings/table.yes')}}
                       	{{Form::radio('offline', '1', (!$offline)?true:false);}} {{Lang::get('admin/settings/table.no')}}
						{{ $errors->first('offline', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ offline -->
				
					<!-- Offline message -->
				<div class="form-group {{{ $errors->has('offlinemessage') ? 'error' : '' }}}">
                    <div class="col-md-12">
                         <?php $offlinemessage = ''; foreach($settings as $v) { if ($v->varname == 'offlinemessage') { $offlinemessage =  $v->value; } } ?>
                    	{{Form::label('offlinemessage', Lang::get('admin/settings/table.offlinemessage'), array('class' => 'control-label'))}}
                       	{{Form::textarea('offlinemessage', Input::old('offlinemessage', $offlinemessage) , array('class' => 'form-control'))}} 
						{{ $errors->first('offlinemessage', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ offline message -->
			</div>
			<!-- ./ offline tab -->
							</div>
							<div class="form-group">
			<div class="col-md-12">
				<button type="reset" class="btn btn-link close_popup">Cancel</button>
				<button type="reset" class="btn btn-default">Reset</button>
				<button type="submit" class="btn btn-success">Update</button>
			</div>
		</div>
						</div>
					</div>
				</div>

				
		
    
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
