@extends('install.layouts.default')

@section('title')
{{ Lang::get('install/installer.installer') }} | {{ Lang::get('install/installer.step') }} 1 {{ Lang::get('install/installer.of') }} 4
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
	<form method="post" style="text-align: center;" action="{{ url('install') }}" class="form-horizontal">
		<button style="text-align: center;" type="submit" class="btn save">
			{{ Lang::get('install/installer.install_database_continue') }}
		</button>
	</form>
</div>
@stop
