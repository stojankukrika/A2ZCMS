<h4>{{{ Lang::get('site/partial_views/sidebar/search.title') }}}</h4>
<form method="POST" action="{{ URL::to('search') }}" accept-charset="UTF-8">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<fieldset>
		<div class="form-group">
			<label class="col-md-4 control-label" for="email">{{{ Lang::get('site/partial_views/sidebar/search.term') }}}</label>
			<div class="col-md-8">
				<input class="form-control" tabindex="1" placeholder="{{{ Lang::get('site/partial_views/sidebar/search.term') }}}" type="text" name="term" id="term" value="{{ Input::old('term') }}">
			</div>
		</div>
		<p>
			<button tabindex="2" type="submit" class="btn btn-primary">
				{{{ Lang::get('site/partial_views/sidebar/search.submit') }}}
			</button>
		</p>
	</fieldset>
</form>	