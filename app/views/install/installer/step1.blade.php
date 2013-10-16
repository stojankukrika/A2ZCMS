@extends('install.layouts.default')

@section('title')
  Installer | Step 1
@stop

@section('content')
  <div id="install-region">
    @if (Session::has('install_errors'))
    <div class="alert alert-block alert-error">
      <strong>Error!</strong>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </div>
    @endif
    <form method="post" style="text-align: center;" action="{{ url('install') }}" class="form-horizontal">
      <button style="text-align: center;" type="submit" class="btn save">Install Database &amp; Continue</button>
    </form>
  </div>
@stop
