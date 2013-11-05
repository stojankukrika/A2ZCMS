@extends('site.layouts.offline')
{{-- Web site Title --}}
@section('title')
{{{ Lang::get('site.offline') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')
{{isset($offlinemessage)?$offlinemessage:"sasas";}}
@stop
