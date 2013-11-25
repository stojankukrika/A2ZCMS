@extends('install.layouts.default')

@section('title')
{{ Lang::get('install/installer.installer') }} | {{ Lang::get('install/installer.complite') }}
@stop
@section('content')
<div id="install-region">
	<h1>{{ Lang::get('install/installer.success') }}</h1>
	<p>
		{{ Lang::get('install/installer.install_complete') }}
	</p>
	<p>
		{{ Lang::get('install/installer.you_can_now') }} <a href="{{{ URL::to('') }}}">{{ Lang::get('install/installer.go_to_heome_page') }}</a>
	</p>
</div>
@stop
