@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
<ul class="nav nav-tabs">
	<li class="active">
		<a href="#tab-general" data-toggle="tab">{{{ Lang::get('admin/general.general') }}}</a>
	</li>
</ul>
{{-- Edit Page Form --}}
<!-- <form class="form-horizontal" method="post" action="{{ URL::to('admin/navigation/create') }}" > -->
<form class="form-horizontal" method="post" action="@if (isset($navigationGroup)){{ URL::to('admin/navigationgroups/' . $navigationGroup->id . '/edit') }}@endif" >
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<!-- ./ csrf token -->

	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- General tab -->
		<div class="tab-pane active" id="tab-general">
			<!-- Post Title -->
			<div class="form-group {{{ $errors->has('title') ? 'error' : '' }}}">
				<div class="col-lg-12">
					<label class="control-label col-lg-2" for="title">{{{ Lang::get('admin/general.title') }}}</label>
					{{ Form::text('title', Input::old('title', isset($navigationGroup) ? $navigationGroup->title : null), array('class' => 'form-control input-sm')) }}
					{{{ $errors->first('title', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ title -->
			
			<!-- Show Date -->
			<div class="form-group {{{ $errors->has('showmenu') ? 'error' : '' }}}">
				<div class="col-lg-12">
					<label class="control-label" for="showmenu">{{{ Lang::get('admin/pages/table.showmenu') }}}</label>
					<label class="radio">
						{{ Form::radio('showmenu', 1, (Input::old('showmenu') == '1' || (isset($navigationGroup->showmenu) && $navigationGroup->showmenu == 1)) ? true : false, array('id'=>'showmenu', 'class'=>'radio')) }}
						{{{ Lang::get('admin/pages/table.yes') }}}	
					</label>
					<label class="radio">
						{{ Form::radio('showmenu', 0, (Input::old('showmenu') == '0' || (isset($navigationGroup->showmenu) && $navigationGroup->showmenu == 0)) ? true : false, array('id'=>'showmenu', 'class'=>'radio')) }}
						{{{ Lang::get('admin/pages/table.no') }}}	
					</label>
	
				</div>
			</div>
			<!-- ./ show date -->
			
			<!-- Show Vote -->
			<div class="form-group {{{ $errors->has('showfooter') ? 'error' : '' }}}">
				<div class="col-lg-12">
					<label class="control-label" for="showfooter">{{{ Lang::get('admin/pages/table.showfooter') }}}</label>
					<label class="radio">
						{{ Form::radio('showfooter', 1, (Input::old('showfooter') == '1' || (isset($navigationGroup->showfooter) && $navigationGroup->showfooter == 1)) ? true : false, array('id'=>'showfooter', 'class'=>'radio')) }}
						{{{ Lang::get('admin/pages/table.yes') }}}	
					</label>
					<label class="radio">
						{{ Form::radio('showfooter', 0, (Input::old('showfooter') == '0' || (isset($navigationGroup->showfooter) && $navigationGroup->showfooter == 0)) ? true : false, array('id'=>'showfooter', 'class'=>'radio')) }}
						{{{ Lang::get('admin/pages/table.no') }}}	
					</label>	
				</div>
			</div>
			<!-- ./ show vote -->
			
			<!-- Show Tags -->
			<div class="form-group {{{ $errors->has('showsidebar') ? 'error' : '' }}}">
				<div class="col-lg-12">
					<label class="control-label" for="showsidebar">{{{ Lang::get('admin/pages/table.showsidebar') }}}</label>
					<label class="radio">
						{{ Form::radio('showsidebar', 1, (Input::old('showsidebar') == '1' || (isset($navigationGroup->showsidebar) && $navigationGroup->showsidebar == 1)) ? true : false, array('id'=>'showsidebar', 'class'=>'radio')) }}
						{{{ Lang::get('admin/pages/table.yes') }}}	
					</label>
					<label class="radio">
						{{ Form::radio('showsidebar', 0, (Input::old('showsidebar') == '0' || (isset($navigationGroup->showsidebar) && $navigationGroup->showsidebar == 0)) ? true : false, array('id'=>'showsidebar', 'class'=>'radio')) }}
						{{{ Lang::get('admin/pages/table.no') }}}	
					</label>
	
				</div>
			</div>
			<!-- ./ show tags -->
				
		</div>
		<!-- ./ general tab -->

	</div>
	<!-- ./ tabs content -->

	<!-- Form Actions -->
	<div class="form-group">
		<div class="col-md-12">
			<button type="reset" class="btn btn-link close_popup">
				<span class="icon-remove"></span>  {{{ Lang::get('admin/general.cancel') }}}
			</button>
			<button type="reset" class="btn btn-default">
				<span class="icon-refresh"></span> {{{ Lang::get('admin/general.reset') }}}
			</button>
			<button type="submit" class="btn btn-success">
				<span class="icon-ok"></span> @if (isset($navigationGroup)){{{ Lang::get('admin/general.update') }}} @else {{{ Lang::get('admin/general.create') }}} @endif
			</button>
		</div>
	</div>
	<!-- ./ form actions -->
</form>
@stop
