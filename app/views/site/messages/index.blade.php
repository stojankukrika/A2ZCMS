@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ $title }}} :: @parent
@stop

{{-- Content --}}
@section('content')
		<ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#service-one" data-toggle="tab">Inbox</a></li>
            <li><a href="#service-two" data-toggle="tab">Send</a></li>
            <li><a href="#service-three" data-toggle="tab">New message</a></li>
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
	                <label for="input1">Subject</label>
	              	<input class="form-control" type="text" name="subject" id="subject" >
	              </div>
	               <div class="clearfix"></div>
	               <div class="form-group col-lg-4">
	                <label for="input1">Receivers</label>
	               <select name="recipients[]" multiple="multiple" id="recipients">
	                     @foreach($allUsers as $usr)
	                        <option value="{{ $usr->id}}">{{ $usr->surname }} {{ $usr->name }}</option>
	                     @endforeach     
	                </select>     
	              </div>
	               <div class="clearfix"></div>
	              <div class="form-group col-lg-12">
	                <label for="input4">Message</label>
	                <textarea name="content" class="form-control" rows="6" id="content"></textarea>
	              </div>
	              <div class="form-group col-lg-12">
	                <button type="submit" class="btn btn-primary">Submit</button>
	              </div>
            </form>

          </div>
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