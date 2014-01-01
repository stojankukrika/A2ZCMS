@extends('admin.layouts.default') 

{{-- Web site Title --}}
@section('title')
{{{ $title }}} ::
@stop

{{-- Content --}}
@section('content')
	<div class="row">				
		<div class="col-lg-3 col-sm-6 col-xs-6 col-xxs-12">
			<div class="smallstat box">
				<i class="icon-bell blue"></i>
				<span class="title">{{{ Lang::get('admin/general.to_do_list') }}}</span>
				<span class="value">{{$to_do_list_not_finish}}</span>
				<a class="more" href="{{{ URL::to('admin/todolists') }}}">
					<span>{{Lang::get('admin/general.view_more')}}</span>
					<i class="icon-chevron-right"></i>
				</a>
			</div>
		</div><!--/col-->				
		<div class="col-lg-3 col-sm-6 col-xs-6 col-xxs-12">
			<div class="smallstat box">
				<i class="icon-list-alt darkGreen"></i>
				<span class="title">{{{ Lang::get('admin/general.custom_form') }}}</span>
				<span class="value">{{$customform}}</span>
				<a class="more" href="{{{ URL::to('admin/customform') }}}">
					<span>{{Lang::get('admin/general.view_more')}}</span>
					<i class="icon-chevron-right"></i>
				</a>
			</div>
		</div><!--/col-->				
		<div class="col-lg-3 col-sm-6 col-xs-6 col-xxs-12">
			<div class="smallstat box">
				<i class="icon-globe red"></i>
				<span class="title">{{{ Lang::get('admin/general.pages') }}}</span>
				<span class="value">{{$pages}}</span>
				<a class="more" href="{{{ URL::to('admin/pages') }}}">
					<span>{{{ Lang::get('admin/general.view_more') }}}</span>
					<i class="icon-chevron-right"></i>
				</a>
			</div>
		</div><!--/col-->				
		<div class="col-lg-3 col-sm-6 col-xs-6 col-xxs-12">
			<div class="smallstat box">
				<i class="icon-book lightOrange"></i>
				<span class="title">{{{ Lang::get('admin/general.blog') }}}</span>
				<span class="value">{{$blog}}</span>
				<a class="more" href="{{{ URL::to('admin/blogs') }}}">
					<span>{{Lang::get('admin/general.view_more')}}</span>
					<i class="icon-chevron-right"></i>
				</a>
			</div>
		</div><!--/col-->
		<div class="col-lg-3 col-sm-6 col-xs-6 col-xxs-12">
			<div class="smallstat box">
				<i class="icon-camera pink"></i>
				<span class="title">{{{ Lang::get('admin/general.gallery') }}}</span>
				<span class="value">{{$gallery}}</span>
				<a class="more" href="{{{ URL::to('admin/galleries') }}}">
					<span>{{Lang::get('admin/general.view_more')}}</span>
					<i class="icon-chevron-right"></i>
				</a>
			</div>
		</div><!--/col-->				
		<div class="col-lg-3 col-sm-6 col-xs-6 col-xxs-12">
			<div class="smallstat box">
				<i class="icon-user yellow"></i>
				<span class="title">{{{ Lang::get('admin/general.users') }}}</span>
				<span class="value">{{$users}}</span>
				<a class="more" href="{{{ URL::to('admin/users') }}}">
					<span>{{Lang::get('admin/general.view_more')}}</span>
					<i class="icon-chevron-right"></i>
				</a>
			</div>
		</div><!--/col-->				
		<div class="col-lg-3 col-sm-6 col-xs-6 col-xxs-12">
			<div class="smallstat box">
				<i class="icon-cogs grey"></i>
				<span class="title">{{{ Lang::get('admin/general.settings') }}}</span>
				<span class="value">{{$settings}}</span>
				<a class="more" href="{{{ URL::to('admin/settings') }}}">
					<span>{{Lang::get('admin/general.view_more')}}</span>
					<i class="icon-chevron-right"></i>
				</a>
			</div>
		</div><!--/col-->				
	</div>
@stop