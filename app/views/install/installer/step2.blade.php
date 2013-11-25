@extends('install.layouts.default')

@section('title')
{{ Lang::get('install/installer.installer') }} | {{ Lang::get('install/installer.step') }} 2 {{ Lang::get('install/installer.of') }} 4
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
	<form method="post" action="{{ url('install/step2') }}" class="form-horizontal">
		<div id="js-errors" class="hide">
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">
					×
				</button>
				<span></span>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="hostname">{{ Lang::get('install/installer.host_name') }}</label>
			<div class="controls">
				<input type="text" id="hostname" name="hostname" placeholder="localhost" value="{{ (isset($old) ? $old->hostname : '') }}">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="database">{{ Lang::get('install/installer.database') }}</label>
			<div class="controls">
				<input type="text" id="database" name="database" placeholder="database" value="{{ (isset($old) ? $old->database : '') }}">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="username">{{ Lang::get('install/installer.database_username') }}</label>
			<div class="controls">
				<input type="text" id="username" name="username" placeholder="username" value="{{ (isset($old) ? $old->username : '') }}">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="password">{{ Lang::get('install/installer.database_password') }}</label>
			<div class="controls">
				<input id="password" type="text" name="password" placeholder="password" value="{{ (isset($old) ? $old->password : '') }}">
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn save">
					{{ Lang::get('install/installer.next_step') }}
				</button>
			</div>
		</div>
	</form>
</div>
@stop
