@extends('install.layouts.default')

@section('title')
  Installer | Complete
@stop

@section('content')
  <div id="install-region">
    <h1>Success</h1>
    <p>Install complete.</p>
    <p>You can now <a href="{{{ URL::to('') }}}">go to home page.</a></p>
  </div>
@stop
