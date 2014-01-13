@extends('install.layouts.default')

@section('title')
{{ Lang::get('install/installer.installer') }} | {{ Lang::get('install/installer.step') }} 1 {{ Lang::get('install/installer.of') }} 4
@stop
@section('content')
<div id="install-region">
	@if (Session::has('install_errors'))
	<div class="alert alert-block alert-error">
		<strong>{{ Lang::get('install/installer.error') }}</strong>
		@foreach ($errors->all() as $error)
		<li>
			{{ $error }}
		</li>
		@endforeach
	</div>
	@endif
	<form method="post" action="{{ url('install') }}" class="form-horizontal">
		<div id="js-errors" class="hide">
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">
					×
				</button>
				<span></span>
			</div>
		</div>
		    <div class="scrollbox">
		        <h2>MIT License</h2>
		
		        <p>Copyright (C) 2012 A2Z CMS</p>
		
		        <p>Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:</p>
		
		        <p>The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.</p>
		
		        <p>THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.</p>
		    </div>
		     <div class="box">
	            <label>I agree to the license {{Form::checkbox('accept', '1') }}</label>
	        </div>
		<button style="text-align: center;" type="submit" class="btn save">
			{{ Lang::get('install/installer.continue') }}
		</button>
	</form>
</div>
@stop
