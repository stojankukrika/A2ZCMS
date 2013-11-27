@extends('install.layouts.default')

@section('title')
{{ Lang::get('install/installer.installer') }} | {{ Lang::get('install/installer.step') }} 4 {{ Lang::get('install/installer.of') }} 4
@stop
@section('content')
<div id="install-region">
	@if (Session::has('install_errors'))
	<div class="alert alert-block alert-error">
		<strong>{{ Lang::get('install/installer.error') }}</strong>
		@foreach ($errors->all() as $error)
		<li>
			{{ $error }}
		</li>
		@endforeach
	</div>
	@endif
	<form method="post" style="text-align: center;" action="{{ url('install/step4') }}" class="form-horizontal">
		<p>
			{{ Lang::get('install/installer.config_info') }}
		</p>
		<div class="control-group">
			<label class="control-label" for="title">{{ Lang::get('install/installer.site_title') }}</label>
			<div class="controls">
				<input type="text" id="title" name="title" placeholder="Site Title" value="{{ (isset($old) ? $old->title : '') }}">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="theme">{{ Lang::get('install/installer.site_theme') }}</label>
			<div class="controls">
				<select name="theme">
					<?php
						foreach(glob(base_path() . '\public\assets\site\*', GLOB_ONLYDIR) as $dir) {
						    $dir = str_replace(base_path() . '\public\assets\site\\', '', $dir);
						   echo '<option value="'.$dir.'">'.ucfirst($dir).'</option>';
						}
					?>
				</select>
			</div>
		</div>
	<div class="control-group">
			<label class="control-label" for="per_page">{{ Lang::get('install/installer.posts_per_page') }}</label>
			<div class="controls">
				<input type="number" name="per_page" id="per_page" value="5" type="number" min="3" max="20" step="1">
			</div>
		</div>
		<button style="text-align: center;" type="submit" class="btn save">
			{{ Lang::get('install/installer.finish') }}
		</button>
	</form>
</div>
@stop
{{-- Scripts --}}
@section('scripts')
<script type="text/javascript">
	$(function() {
 		$("#per_page").keyup(function () { 
		    this.value = this.value.replace(/[^0-9\.]/g,'');
		});
 	})
</script>
 @stop
