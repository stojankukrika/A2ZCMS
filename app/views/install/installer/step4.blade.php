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
					<option value="default">default</option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="per_page">{{ Lang::get('install/installer.posts_per_page') }}</label>
			<div class="controls">
				<input type="number" name="per_page" value="5">
			</div>
		</div>
		<button style="text-align: center;" type="submit" class="btn save">
			{{ Lang::get('install/installer.finish') }}
		</button>
	</form>
</div>
@stop
