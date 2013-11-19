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
		<h1>{{ Lang::get('site/messages.title') }}</h1>
		<ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#service-one" data-toggle="tab">{{ Lang::get('site/messages.inbox') }}</a></li>
            <li><a href="#service-two" data-toggle="tab">{{ Lang::get('site/messages.send') }}</a></li>
            <li><a href="#service-three" data-toggle="tab">{{ Lang::get('site/messages.new_message') }}</a></li>
          </ul>
            <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="service-one">
           
              @foreach  ($received as $item)
                <div class="panel panel-default">
	              <div class="panel-heading">
	                <h4 class="panel-title">
	                  <a class="accordion-toggle" id="msg-{{{$item->id}}}" data-toggle="collapse" data-parent="#accordion" href="#{{{$item->id}}}">
	                   <b>{{{ $item->subject }}}</b>
	                  </a>
	                </h4><span>{{{ $item->sender->surname }}} {{{ $item->sender->name }}}</span> 
	                ({{{ date($dateformat.$timeformat, strtotime($item->sender->created_at)) }}})
	              </div>
	              <div id="{{{$item->id}}}" class="panel-collapse collapse">
	                <div class="panel-body">
	                  {{{$item->content}}}
	                </div>
	              </div>
	            </div>
	         @endforeach
          </div>
           <div class="tab-pane fade in" id="service-two">
             
          @foreach  ($send as $item)
              	 <div class="panel panel-default">
	              <div class="panel-heading">
	                <h4 class="panel-title">
	                  <a class="accordion-toggle" id="" data-toggle="collapse" data-parent="#accordion" href="#{{{$item->id}}}">
	                    <b>{{{ $item->subject }}}</b>
	                  </a>
	                </h4><span>{{{ $item->receiver->surname }}} {{{ $item->receiver->name }}}</span> 
 					({{{ date($dateformat.$timeformat, strtotime($item->sender->created_at)) }}})
	              </div>
	              <div id="{{{$item->id}}}" class="panel-collapse collapse">
	                <div class="panel-body">
	                  {{{$item->content}}}
	                </div>
	              </div>
	            </div>
	         @endforeach

          </div>
          <div class="tab-pane fade in" id="service-three">
             
             <form role="form" method="POST" action="messages/sendmessage">
	             <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	              <div class="form-group col-lg-4">
	                <label for="input1">{{ Lang::get('site/messages.subject') }}</label>
	              	<input class="form-control" type="text" name="subject" id="subject" >
	              </div>
	               <div class="clearfix"></div>
	               <div class="form-group col-lg-4">
	                <label for="input1">{{ Lang::get('site/messages.receivers') }}</label>
	               <select name="recipients[]" multiple="multiple" id="recipients">
	                     @foreach($allUsers as $usr)
	                        <option value="{{ $usr->id}}">{{ $usr->surname }} {{ $usr->name }}</option>
	                     @endforeach     
	                </select>     
	              </div>
	               <div class="clearfix"></div>
	              <div class="form-group col-lg-12">
	                <label for="input4">{{ Lang::get('site/messages.message') }}</label>
	                <textarea name="content" class="form-control" rows="6" id="content"></textarea>
	              </div>
	              <div class="form-group col-lg-12">
	                <button type="submit" class="btn btn-primary">{{ Lang::get('site.submit') }}</button>
	              </div>
            </form>

          </div>
       </div>
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

	{{-- Scripts --}}
	@section('scripts')
	<script>
		$( document ).ready(function() {
			
			/*set a multiselect users for sending a message*/
			$("#recipients").multiselect();
		
			/*mark message as read*/
			$("[id^='msg-']").click(function() {

				var values = $(this).attr("id");
				var value = values.split('-')[1];
					$.ajax({
						url: 'messages/'+value+'/read',
						type: "GET",							
					})
			})
		
		});
	</script>
	@stop