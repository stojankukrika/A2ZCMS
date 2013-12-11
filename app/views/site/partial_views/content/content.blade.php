 <div class="row">
 	@if($page->showtitle=='1') 
	<h1>{{$page->name}}</h1>
@endif
@if($page->showdate=='1') 
	<p><i class="icon-time"></i>{{Lang::get('site/blog.posted_on')}} {{$page->date()}} </p>
@endif
	<hr>
	@if($page->image)
		<img src="../page/{{$page->image}}" class="img-responsive">
  	<hr>
  	@endif
  	<p>
		{{ $page->content() }}
	</p>
	@if($page->showtags=='1') 
	<p id="tags"><i class="icon-tags"></i>{{$page->tags()}}</p>
	@endif
	@if($page->showvote=='1') 
	<p id="vote">{{ Lang::get("site.num_of_votes") }} <span id="countvote">{{$page->voteup-$page->votedown}}</span> 
		@if ( ! Auth::check())
		<br />
		{{ Lang::get('site.add_votes_login') }}
		<br />
		{{ Lang::get('site/blog.click') }} <a href="{{{ URL::to('user/login') }}}">{{ Lang::get('site/blog.here') }}</a> 
		{{ Lang::get('site/blog.to_login') }}
	
		@elseif (!$canPageVote )
		<br><b><i>{{ Lang::get('site.add_votes_permission') }}</i></b>
		@else				
		<span style="display: inline-block;" onclick="contentvote('1','page',{{$page->id}})" class="up"></span>
		<span style="display: inline-block;" onclick="contentvote('0','page',{{$page->id}})" class="down"></span>
		@endif
	</p>
	@endif
 <hr>
 </div> 
