<?php

class CustomFormController extends BaseController {

		/**
	 * CustomForm Model
	 * @var CustomForm
	 */
	protected $customform;

	/**
	 * User Model
	 * @var User
	 */
	protected $user;
	/**
	 * Settings Model
	 * @var Settings
	 */
	protected $settings;
	/**
	 * Inject the models.
	 * @param Blog $blog
	 * @param User $user
	 */
	protected $navigation;
	public function __construct(CustomForm $customform, User $user, Settings $settings) {
		parent::__construct();
		$this -> customform = $customform;
		$this -> user = $user;
		$settings = Settings::all();
		$this -> settings = $settings;

	}
	
	/**
	 * post a custom form.
	 *
	 * @param  string  $id
	 * @return Redirect
	 */
	public function postView($id) {

		$user = $this -> user -> currentUser();
		
		// Get this custom form a
		$customform = $this -> customform -> where('id', '=', $id) -> first();
		$customform_fields = CustomFormField::where('custom_form_id', '=', $id) -> first();
		if (is_null($customform) || is_null($customform_fields)) {
			// If we ended up in here, it means that
			// a page or a blog blog didn't exist.
			// So, this means that it is time for
			// 404 error page.
			return App::abort(404);
		}
		
		$emailadmin = "";
        foreach ($this->settings as $v) {
                if ($v -> varname == 'email') {
                        $emailadmin = $v -> value;
                }
        }
		$emailadmin = $emailadmin.','.$customform->recievers;
		$rules = array();
		foreach ($customform_fields as $fields) {
			switch ($fields['mandatory']) {
				case '2':
					$rules[$fields->name] = 'required|';
					break;
				case '3':
					$rules[$fields->name] = 'required|numeric';
					break;
				case '4':
					$rules[$fields->name] = 'required|email';
					break;
			}
			
		}
		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);
		
		// Check if the form validates with success
		if ($validator -> passes()) {
			// Save the comment
			$data = Input::except('_token');
			
			if (strpos($emailadmin,'.') !== false && strpos($emailadmin,'@') !== false && strlen($emailadmin)>6) {
			
			$emailadmin = explode(';', $emailadmin);
			foreach ($emailadmin as $email) {
					if(Mail::send('emails.customform', $data, function($message)
					{
					    $message->to($email)
					    		->subject(Lang::get('site/customform.contact_custom_message'));
					})){
					return Redirect::back() -> with(Lang::get('site/customform.success'), Lang::get('site/customform.comment_added'));
					}
				}
			}
		}
			

		// Redirect to this custom form
		return Redirect::back() -> withInput() -> withErrors($validator);
	}
}
