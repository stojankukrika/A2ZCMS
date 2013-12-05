@extends('site.layouts.default')
{{-- Page title --}}
@section('page_header')
	@if($page->showtitle==1)
	<h1 class="page-header">
		{{{ $page->name }}}
	</h1>
	@endif
@stop
{{-- Page title --}}
@section('page_breadcrumb')
	@if(isset($breadcrumb))
	<ol class="breadcrumb">			          
		{{ $breadcrumb }}
	 <!--<li><a href="#">Home</a></li>
		<li class="active">Blog Home</li>-->
	</ol>
	@endif
@stop
{{-- Add page scripts --}}
@section('page_scripts')
	<style>
	{{{ $page->page_css }}}
	</style>
	<script>
	{{ $page->page_javascript}}
	</script>
@stop
{{-- Sidebar left --}}
@section('sidebar_left')
	@foreach ($sidebar_left as $item)
	
		  <div class="well">			
			{{ $item['content'] }}
		</div>
	@endforeach 
@stop
{{-- Content --}}
@section('content')
<br>
@if(!empty($showCustomFormId))
<hr>
 <div class="row">
  	<div class="col-lg-12 col-md-12">
	@foreach($showCustomFormId as $item)
		<h3>{{$item->title}}</h3>
			@if(!empty($showCustomFormId))
				<form action="{{{ URL::to('customform/'.$item->id) }}}" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{{ Session::getToken() }}}" />
				@foreach($showCustomFormFildId[$item->id] as $field)
						<div class="col-lg-6 form-group">
							{{ $field->name }}
						</div>
						<div class="col-lg-6 form-group">
							      @if($field->type == '1')
							            <input type="text" class="form-control" name="{{Str::slug($field->name)}}" value=""/>
							      @elseif($field->type == '2')
							             <textarea  class="form-control" rows="6" name="{{Str::slug($field->name)}}" /></textarea>
							      @elseif($field->type == '3')
							            <select class="form-control" name="{{Str::slug($field->name)}}">
							            	<?php
								            	$options = rtrim($field->options, ";");
												$options = explode(';', $options);
												foreach ($options as $value) {
													echo "<option value='".Str::slug($value)."'>".$value."</option>";
												}
							            	?>
							            </select>
							      @elseif($field->type == '4')
					      			<?php
						            	$options = rtrim($field->options,";");
										$options = explode(';', $options);
										foreach ($options as $value) {
											echo "<input  class='form-control' type='radio' name='".Str::slug($field->name)."' value='".Str::slug($value)."'>".$value."<br>";
										}
					            	?>
							      @elseif($field->type == '5')
							         	<input type="file"  class="form-control" name="{{Str::slug($field->name)}}" value="">
							      @elseif($field->type == '6')
							         <?php
						            	$options = rtrim($field->options,";");
										$options = explode(';', $options);
										foreach ($options as $value) {
											echo "<input  class='form-control' type='checkbox' name='".Str::slug($field->name)."' value='".Str::slug($value)."'>".$value."<br>";
										}
					            	?>
					              @endif						
						</div>
				@endforeach
				<input class="btn btn-primary" type="submit" value="Submit">
				</form>
			@endif
	@endforeach
	</div>	
</div> 
@endif
@endif
@stop
{{-- Sidebar right --}}
@section('sidebar_right')
<div class="col-lg-4">		
	 <div class="well-sm"><br/>
	 	</div>			 
	@foreach ($sidebar_right as $item)
		  <div class="well">			
			{{ $item['content'] }}
		</div>
	@endforeach 
</div>
@stop
