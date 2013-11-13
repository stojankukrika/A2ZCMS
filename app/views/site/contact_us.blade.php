@extends('site.layouts.default')

{{-- Content --}}
@section('content')

  <form role="form" method="POST" action="contact-form-submission.php">
              <div class="form-group col-lg-4">
                <label for="input1">{{ Lang::get('site/contact_us.name') }}</label>
                <input type="text" name="contact_name" class="form-control" id="input1">
              </div>
              <div class="form-group col-lg-4">
                <label for="input2">{{ Lang::get('site/contact_us.email') }}</label>
                <input type="email" name="contact_email" class="form-control" id="input2">
              </div>
              <div class="form-group col-lg-4">
                <label for="input3">{{ Lang::get('site/contact_us.phone') }}</label>
                <input type="phone" name="contact_phone" class="form-control" id="input3">
              </div>
              <div class="clearfix"></div>
              <div class="form-group col-lg-12">
                <label for="input4">{{ Lang::get('site/contact_us.message') }}</label>
                <textarea name="contact_message" class="form-control" rows="6" id="input4"></textarea>
              </div>
              <div class="form-group col-lg-12">
                <input type="hidden" name="save" value="contact">
                <button type="submit" class="btn btn-primary">{{ Lang::get('site/contact_us.submit') }}</button>
              </div>
            </form>
@stop
