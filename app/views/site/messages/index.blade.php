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
	                  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#{{{$item->id}}}">
	                   {{{ $item->subject }}}
	                  </a>
	                </h4><span>Test user</span>
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
	                  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#{{{$item->id}}}">
	                    {{{ $item->subject }}}
	                  </a>
	                </h4><span>Admin Adminovic</span>
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
             
             <form role="form" method="POST" action="contact-form-submission.php">
              <div class="form-group col-lg-4">
                <label for="input1">Name</label>
                <input type="text" name="contact_name" class="form-control" id="input1">
              </div>
               <div class="clearfix"></div>
              <div class="form-group col-lg-12">
                <label for="input4">Message</label>
                <textarea name="contact_message" class="form-control" rows="6" id="input4"></textarea>
              </div>
              <div class="form-group col-lg-12">
                <input type="hidden" name="save" value="contact">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>

          </div>
       </div>
	@stop
	
	{{-- Scripts --}}
	@section('scripts')
	<script>
		$('#sidebar-left').addClass('minified');
		$(window).bind('beforeunload', function(){
		 	$('#sidebar-left').removeClass('minified');
		});
	</script>
	@stop