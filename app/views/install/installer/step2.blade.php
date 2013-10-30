@extends('install.layouts.default')

@section('title')
Installer | Step 2 of 4
@stop

@section('content')
<div id="install-region">
	@if (Session::has('install_errors'))
	<div class="alert alert-block alert-error">
		<strong>Error!</strong>
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
			<label class="control-label" for="hostname">Host name</label>
			<div class="controls">
				<input type="text" id="hostname" name="hostname" placeholder="localhost" value="{{ (isset($old) ? $old->hostname : '') }}">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="database">Database</label>
			<div class="controls">
				<input type="text" id="database" name="database" placeholder="database" value="{{ (isset($old) ? $old->database : '') }}">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="username">Database username</label>
			<div class="controls">
				<input type="text" id="username" name="username" placeholder="username" value="{{ (isset($old) ? $old->username : '') }}">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="password">Database password</label>
			<div class="controls">
				<input id="password" type="text" name="password" placeholder="password" value="{{ (isset($old) ? $old->password : '') }}">
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn save">
					Next Step
				</button>
			</div>
		</div>
	</form>
</div>
@stop
