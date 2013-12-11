@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ $title }}} ::
@stop

{{-- Content --}}
@section('content')
<div class="page-header">

	{{ Form::open() }}
	<div class="col-md-12">
		<div class="box">
			<div class="box-header">
				<h2><i class="icon-th"></i><span class="break"></span>{{{ $title }}}</h2>
				<ul id="myTab" class="nav tab-menu nav-tabs">
					<li>
						<a href="#general_settings">{{ Lang::get('admin/settings/title.general_settings') }}</a>
					</li>
					<li>
						<a href="#analytics_code">{{ Lang::get('admin/settings/title.analytics_code') }}</a>
					</li>
					<li>
						<a href="#meta_data">{{ Lang::get('admin/settings/title.meta_data') }}</a>
					</li>
					<li>
						<a href="#searchcode">{{ Lang::get('admin/settings/title.searchcode') }}</a>
					</li>
					<li>
						<a href="#offline_settings">{{ Lang::get('admin/settings/title.offline_settings') }}</a>
					</li>
					
				</ul>
			</div>
			<div class="box-content">

				<div class="tab-content" id="myTabContent">
					<!-- General tab -->
					<div class="tab-pane active" id="general_settings">
						<!-- Email -->
						<div class="form-group {{{ $errors->has('email') ? 'error' : '' }}}">
							<div class="col-md-12">
								<?php $email = '';
								foreach ($settings as $v) {
									if ($v -> varname == 'email') { $email = $v -> value;
									}
								} ?>
								{{Form::label('email', Lang::get('admin/settings/table.email'), array('class' => 'control-label'))}}
								{{Form::text('email', Input::old('email', $email) , array('class' => 'form-control'))}}
								{{ $errors->first('email', '<span class="help-inline">:message</span>') }}
							</div>
						</div>
						<!-- ./ email -->
						<!-- Title -->
						<div class="form-group {{{ $errors->has('title') ? 'error' : '' }}}">
							<div class="col-md-12">
								<?php $title = '';
								foreach ($settings as $v) {
									if ($v -> varname == 'title') { $title = $v -> value;
									}
								} ?>
								{{Form::label('title', Lang::get('admin/settings/table.title'), array('class' => 'control-label'))}}
								{{Form::text('title', Input::old('title', $title) , array('class' => 'form-control'))}}
								{{ $errors->first('title', '<span class="help-inline">:message</span>') }}
							</div>
						</div>
						<!-- ./ title -->
						<!-- Copyright -->
						<div class="form-group {{{ $errors->has('copyright') ? 'error' : '' }}}">
							<div class="col-md-12">
								<?php $copyright = '';
								foreach ($settings as $v) {
									if ($v -> varname == 'copyright') { $copyright = $v -> value;
									}
								} ?>
								{{Form::label('copyright', Lang::get('admin/settings/table.copyright'), array('class' => 'control-label'))}}
								{{Form::text('copyright', Input::old('copyright', $copyright) ,array('class' => 'form-control'))}}
								{{ $errors->first('copyright', '<span class="help-inline">:message</span>') }}
							</div>
						</div>
						<!-- ./ copyright -->
						<!-- Dateformat -->
						<div class="form-group {{{ $errors->has('dateformat') ? 'error' : '' }}}">
							<div class="col-md-12">
								<?php $dateformat = '';
								foreach ($settings as $v) {
									if ($v -> varname == 'dateformat') { $dateformat = $v -> value;
									}
								} ?>
								{{Form::label('dateformat', Lang::get('admin/settings/table.dateformat'), array('class' => 'control-label'))}}
								{{Form::text('dateformat', Input::old('dateformat', $dateformat) , array('class' => 'form-control'))}}
								{{ $errors->first('dateformat', '<span class="help-inline">:message</span>') }}
							</div>
						</div>
						<!-- ./ dateformat -->
						<!-- Timeformat -->
						<div class="form-group {{{ $errors->has('timeformat') ? 'error' : '' }}}">
							<div class="col-md-12">
								<?php $timeformat = '';
								foreach ($settings as $v) {
									if ($v -> varname == 'timeformat') { $timeformat = $v -> value;
									}
								} ?>
								{{Form::label('timeformat', Lang::get('admin/settings/table.timeformat'), array('class' => 'control-label'))}}
								{{Form::text('timeformat', Input::old('timeformat', $timeformat) , array('class' => 'form-control'))}}
								{{ $errors->first('timeformat', '<span class="help-inline">:message</span>') }}
							</div>
						</div>
						<!-- ./ timeformat -->

						<!-- Useravatwidth -->
						<div class="form-group {{{ $errors->has('useravatwidth') ? 'error' : '' }}}">
							<div class="col-md-12">
								<?php $useravatwidth = '';
								foreach ($settings as $v) {
									if ($v -> varname == 'useravatwidth') { $useravatwidth = $v -> value;
									}
								} ?>
								{{Form::label('useravatwidth', Lang::get('admin/settings/table.useravatwidth'), array('class' => 'control-label'))}}
								{{Form::text('useravatwidth', Input::old('useravatwidth', $useravatwidth) , array('class' => 'form-control'))}}
								{{ $errors->first('useravatwidth', '<span class="help-inline">:message</span>') }}
							</div>
						</div>
						<!-- ./ useravatwidth -->
						<!-- Useravatheight -->
						<div class="form-group {{{ $errors->has('useravatheight') ? 'error' : '' }}}">
							<div class="col-md-12">
								<?php $useravatheight = '';
								foreach ($settings as $v) {
									if ($v -> varname == 'useravatheight') { $useravatheight = $v -> value;
									}
								} ?>
								{{Form::label('useravatheight', Lang::get('admin/settings/table.useravatheight'), array('class' => 'control-label'))}}
								{{Form::text('useravatheight', Input::old('useravatheight', $useravatheight) , array('class' => 'form-control'))}}
								{{ $errors->first('useravatheight', '<span class="help-inline">:message</span>') }}
							</div>
						</div>
						<!-- ./ timeformat -->
						<!-- Pageitem -->
						<div class="form-group {{{ $errors->has('pageitem') ? 'error' : '' }}}">
							<div class="col-md-12">
								<?php $pageitem = '';
								foreach ($settings as $v) {
									if ($v -> varname == 'pageitem') { $pageitem = $v -> value;
									}
								} ?>
								{{Form::label('pageitem', Lang::get('admin/settings/table.pageitem'), array('class' => 'control-label'))}}
								{{Form::text('pageitem', Input::old('pageitem', $pageitem) , array('class' => 'form-control'))}}
								{{ $errors->first('pageitem', '<span class="help-inline">:message</span>') }}
							</div>
						</div>
						<!-- ./ pageitem -->
						
						<!-- site theme -->
						<div class="form-group {{{ $errors->has('sitetheme') ? 'error' : '' }}}">
							<div class="col-md-12">
								{{Form::label('sitetheme', Lang::get('admin/settings/table.sitetheme'), array('class' => 'control-label'))}}
								<select name="sitetheme" id="sitetheme" class="form-control input-sm">
								<?php
									$sitetheme = '';
									foreach ($settings as $v) {
										if ($v -> varname == 'sitetheme') { $sitetheme = $v -> value;
										}
									}
									foreach(glob(base_path() . '\public\assets\site\*', GLOB_ONLYDIR) as $dir) {
									    $dir = str_replace(base_path() . '\public\assets\site\\', '', $dir);
									   echo '<option value="'.$dir.'"';
									   if($dir==$sitetheme) echo 'selected="selected"';
									   echo '>'.ucfirst($dir).'</option>';
									}
								?>
								</select>
							</div>
						</div>
						<!-- ./ pageitem -->
					</div>
					<!-- Analytics tab -->
					<div class="tab-pane active" id="analytics_code">
						<!-- analytics -->
						<div class="form-group {{{ $errors->has('analytics') ? 'error' : '' }}}">
							<div class="col-md-12">
								<?php $analytics = '';
								foreach ($settings as $v) {
									if ($v -> varname == 'analytics') { $analytics = $v -> value;
									}
								} ?>
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
								<?php $metadesc = '';
								foreach ($settings as $v) {
									if ($v -> varname == 'metadesc') { $metadesc = $v -> value;
									}
								} ?>
								{{Form::label('metadesc', Lang::get('admin/settings/table.metadesc'), array('class' => 'control-label'))}}
								{{Form::textarea('metadesc', Input::old('offlinemessage', $metadesc) , array('class' => 'form-control'))}}
								{{ $errors->first('metadesc', '<span class="help-inline">:message</span>') }}
							</div>
						</div>
						<!-- ./ metadesc -->

						<!-- Metakey -->
						<div class="form-group {{{ $errors->has('metakey') ? 'error' : '' }}}">
							<div class="col-md-12">
								<?php $metakey = '';
								foreach ($settings as $v) {
									if ($v -> varname == 'metakey') { $metakey = $v -> value;
									}
								} ?>
								{{Form::label('metakey', Lang::get('admin/settings/table.metakey'), array('class' => 'control-label'))}}
								{{Form::text('metakey', Input::old('metakey', $metakey) , array('class' => 'form-control'))}}
								{{ $errors->first('metakey', '<span class="help-inline">:message</span>') }}
							</div>
						</div>
						<!-- ./ metakey -->

						<!-- Metaauthor -->
						<div class="form-group {{{ $errors->has('metaauthor') ? 'error' : '' }}}">
							<div class="col-md-12">
								<?php $metaauthor = '';
								foreach ($settings as $v) {
									if ($v -> varname == 'metaauthor') { $metaauthor = $v -> value;
									}
								} ?>
								{{Form::label('metaauthor', Lang::get('admin/settings/table.metaauthor'), array('class' => 'control-label'))}}
								{{Form::text('metaauthor', Input::old('metaauthor', $metaauthor) , array('class' => 'form-control'))}}
								{{ $errors->first('metaauthor', '<span class="help-inline">:message</span>') }}
							</div>
						</div>
						<!-- ./ metaauthor -->
					</div>
					<!-- ./ meta tab -->					
					<!-- searchcode-->
					<div class="tab-pane active" id="searchcode">
						<!-- analytics -->
						<div class="form-group {{{ $errors->has('searchcode') ? 'error' : '' }}}">
							<div class="col-md-12">
								<?php $searchcode = '';
								foreach ($settings as $v) {
									if ($v -> varname == 'searchcode') { $searchcode = $v -> value;
									}
								} ?>
								{{Form::label('searchcode', Lang::get('admin/settings/table.searchcode'), array('class' => 'control-label'))}}
								{{Form::textarea('searchcode', Input::old('searchcode', $searchcode) , array('class' => 'form-control'))}}
								{{ $errors->first('searchcode', '<span class="help-inline">:message</span>') }}
							</div>
						</div>
						<!-- ./ analytics -->
					</div>
					<!-- /searchcode-->
					<!-- offline tab -->
					<div class="tab-pane active" id="offline_settings">
						<!-- Offline -->
						<div class="form-group {{{ $errors->has('offline') ? 'error' : '' }}}">
							<div class="col-md-12">
								<?php $offline = '';
								foreach ($settings as $v) {
									if ($v -> varname == 'offline') { $offline = $v -> value;
									}
								} ?>
								{{Form::label('offline', Lang::get('admin/settings/table.offline'), array('class' => 'control-label'))}}
								<label class="radio">
									{{ Form::radio('offline', 1, (Input::old('offline') == '1'  || $offline == '1') ? true : false, array('id'=>'offline', 'class'=>'radio')) }}
									{{{ Lang::get('admin/pages/table.yes') }}}	
								</label>
								<label class="radio">
									{{ Form::radio('offline', 0, (Input::old('offline') == '0' || $offline == '0') ? true : false, array('id'=>'offline', 'class'=>'radio')) }}
									{{{ Lang::get('admin/pages/table.no') }}}	
								</label>
							</div>
						</div>
						<!-- ./ offline -->

						<!-- Offline message -->
						<div class="form-group {{{ $errors->has('offlinemessage') ? 'error' : '' }}}">
							<div class="col-md-12">
								<?php $offlinemessage = '';
								foreach ($settings as $v) {
									if ($v -> varname == 'offlinemessage') { $offlinemessage = $v -> value;
									}
								} ?>
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
						<button type="reset" class="btn btn-link close_popup">
							<span class="icon-remove"></span>  {{{ Lang::get('admin/general.cancel') }}}
						</button>
						<button type="reset" class="btn btn-default">
							<span class="icon-refresh"></span> {{{ Lang::get('admin/general.reset') }}}
						</button>
						<button type="submit" class="btn btn-success">
							<span class="icon-ok"></span> @if (isset($settings)){{{ Lang::get('admin/general.update') }}} @else {{{ Lang::get('admin/general.create') }}} @endif
						</button>
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
		$("#tabs").tabs();
		$('#useravatwidth,#useravatheight,#shortmsg,#pageitem').keyup(function () { 
			    this.value = this.value.replace(/[^0-9\.]/g,'');
			});
	}); 
</script>
@stop
